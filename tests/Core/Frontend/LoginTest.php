<?php
/**
 * ownCloud
*
* @author Artur Neumann
* @copyright 2017 Artur Neumann info@individual-it.net
*
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
* License as published by the Free Software Foundation; either
* version 3 of the License, or any later version.
*
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU AFFERO GENERAL PUBLIC LICENSE for more details.
*
* You should have received a copy of the GNU Affero General Public
* License along with this library.  If not, see <http://www.gnu.org/licenses/>.
*
*/

use Test\SeleniumTestCase;

class LoginTest extends SeleniumTestCase {

	public function testNormalLogin() {

		$this->webDriver->get($this->rootURL);
		$login = $this->webDriver->findElement ( WebDriverBy::id("user"));
		$login->click();
		$login->sendKeys("admin");

		$login = $this->webDriver->findElement ( WebDriverBy::id("password"));
		$login->click();
		$login->sendKeys("admin");

		$login = $this->webDriver->findElement ( WebDriverBy::id("submit"));
		$login->click();
		sleep(5);
		$fileElement = $this->webDriver->findElement(WebDriverBy::xpath("//span[@class='innernametext']"));
		$this->assertEquals($fileElement->getText(), "welcome");
	}
}
