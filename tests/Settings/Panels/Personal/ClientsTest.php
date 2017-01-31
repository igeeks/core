<?php
/**
 * @author Tom Needham
 * @copyright 2016 Tom Needham tom@owncloud.com
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later.
 * See the COPYING-README file.
 */

namespace Tests\Settings\Panels\Personal;

use OC\Settings\Panels\Personal\Clients;
use OCP\Defaults;
use OCP\IConfig;

/**
 * @package Tests\Settings\Panels\Personal
 */
class ClientsTest extends \Test\TestCase {

	/** @var \OC\Settings\Panels\Personal\Clients */
	private $panel;

	/** @var \OCP\Config */
	private $config;

    /** @var \OCP\Defaults */
    private $defaults;

	public function setUp() {
		parent::setUp();
		$this->config = $this->getMockBuilder(IConfig::class)->getMock();
        $this->defaults = $this->getMockBuilder(Defaults::class)->getMock();
		$this->panel = new Clients($this->config, $this->defaults);
	}

	public function testGetSection() {
		$this->assertEquals('general', $this->panel->getSectionID());
	}

	public function testGetPriority() {
		$this->assertTrue(is_integer($this->panel->getPriority()));
		$this->assertTrue($this->panel->getPriority() < 100);
        $this->assertTrue($this->panel->getPriority() > -100);
	}

	public function testGetPanel() {
		$map = [
			[
				'customclient_desktop',
				null,
				'/custom_desktop'
			],
			[
				'customclient_android',
				null,
				'/custom_android'
			],
			[
				'customclient_ios',
				null,
				'/custom_ios'
			]
		];
		$this->config->expects($this->exactly(3))->method('getSystemValue')->will($this->returnValueMap($map));
		$templateHtml = $this->panel->getPanel()->fetchPage();
		$this->assertContains('/custom_desktop', $templateHtml);
		$this->assertContains('/custom_ios', $templateHtml);
		$this->assertContains('custom_android', $templateHtml);
	}

}
