<?php
/**
 * @author Tom Needham
 * @copyright 2016 Tom Needham tom@owncloud.com
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later.
 * See the COPYING-README file.
 */

namespace OCA\Federation\Tests;

use Doctrine\DBAL\Driver\Statement;
use OCA\Federation\Panels\Admin;
use OCP\BackgroundJob\IJobList;
use OCP\DB\QueryBuilder\IQueryBuilder;
use OCP\Http\Client\IClientService;
use OCP\IConfig;
use OCP\IDBConnection;
use OCP\IL10N;
use OCP\ILogger;
use OCP\Security\ISecureRandom;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @package OCA\Federation\Tests
 */
class PanelTest extends \Test\TestCase {

	/** @var \OCA\Federation\Panels\Admin */
	private $panel;

	private $connection;

	private $l;

	private $logger;

	private $jobList;

	private $clientService;

	private $secureRandom;

	private $config;

	private $eventDispatcher;

	public function setUp() {
		parent::setUp();
		$this->connection = $this->getMockBuilder(IDBConnection::class)->getMock();
		$this->l = $this->getMockBuilder(IL10N::class)->getMock();
		$this->clientService = $this->getMockBuilder(IClientService::class)->getMock();
		$this->logger = $this->getMockBuilder(ILogger::class)->getMock();
		$this->jobList = $this->getMockBuilder(IJobList::class)->getMock();
		$this->secureRandom = $this->getMockBuilder(ISecureRandom::class)->getMock();
		$this->config = $this->getMockBuilder(IConfig::class)->getMock();
		$this->eventDispatcher = $this->getMockBuilder(EventDispatcherInterface::class)->getMock();

		$this->panel = new Admin(
			$this->connection,
			$this->l,
			$this->clientService,
			$this->logger,
			$this->jobList,
			$this->secureRandom,
			$this->config,
			$this->eventDispatcher
			);
	}

	public function testGetSection() {
		$this->assertEquals('sharing', $this->panel->getSectionID());
	}

	public function testGetPriority() {
		$this->assertTrue(is_integer($this->panel->getPriority()));
		$this->assertTrue($this->panel->getPriority() > -100);
		$this->assertTrue($this->panel->getPriority() < 100);
	}

	public function testGetPanel() {
		$queryBuilder = $this->getMockBuilder(IQueryBuilder::class)->getMock();
		$queryBuilder->expects($this->once())->method('select')->willReturn($queryBuilder);
		$queryBuilder->expects($this->once())->method('from')->willReturn($queryBuilder);
		$statement = $this->getMockBuilder(Statement::class)->getMock();
		$queryBuilder->expects($this->once())->method('execute')->willReturn($statement);
		$statement->expects($this->once())->method('fetchAll')->willReturn([]);
		$this->connection->expects($this->once())->method('getQueryBuilder')->willReturn($queryBuilder);
		$templateHtml = $this->panel->getPanel()->fetchPage();
		$this->assertContains('<div id="ocFederationSettings" class="section">', $templateHtml);
	}

}
