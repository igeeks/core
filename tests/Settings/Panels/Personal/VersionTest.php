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

use OC\Settings\Panels\Personal\Version;

/**
 * @package Tests\Settings\Panels\Personal
 */
class VersionTest extends \Test\TestCase {

	/** @var \OC\Settings\Panels\Personal\Version */
	private $panel;

	public function setUp() {
		parent::setUp();
		$this->panel = new Version;
	}

	public function testGetSection() {
		$this->assertEquals('general', $this->panel->getSectionID());
	}

	public function testGetPriority() {
		$this->assertTrue(is_integer($this->panel->getPriority()));
		$this->assertTrue($this->panel->getPriority() > -100);
		$this->assertTrue($this->panel->getPriority() < 100);
	}

	public function testGetPanel() {
		$templateHtml = $this->panel->getPanel()->fetchPage();
		$this->assertContains('<a href="', $templateHtml);
	}

}
