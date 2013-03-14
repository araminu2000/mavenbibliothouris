<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';
require_once 'PHPUnit/Extensions/SeleniumTestCase/Driver.php';
require_once 'PHPUnit/Extensions/SeleniumTestSuite.php';
 
class ExampleTest extends PHPUnit_Extensions_SeleniumTestCase {
 
public function setUp() {
        $this->setBrowser('*firefox');
        $this->setBrowserUrl('http://www.emag.ro');
}
 
public function provider() {
         return array (array (array ('http://www.emag.ro/laptopuri/notebook-dell-inspiron-n7110-cu-    procesor-intel-174-coretm-i5-2430m-240ghz-4gb-500gb-nvidia-geforce-gt-525m-1gb-microsoft-windows-7-home-premium-diamond-black--pDL-271962367?ref=hp_rec_1', '3.17999') ) );
}
 
/**
* @dataProvider provider
*/
public function test_example($data) {
        $this->open($data[0]);
        //$sitePrice = (float)$this->getText('//span[@itemprop="price"]');
        $this->assertEquals('ok','ok');
}
 
}
