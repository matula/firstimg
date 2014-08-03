<?php
use Matula\Firstimg\Firstimg;

class FirstimgTest extends PHPUnit_Framework_TestCase {

    public function testCanInstantiateFirstimg()
    {
        $fi = new Firstimg('http://google.com');
        $this->assertEquals('Matula\Firstimg\Firstimg', get_class($fi));
    }

    public function testDidntInstatiateWithUrlThrowsException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $fi = new Firstimg();
    }

    public function testCanReturnHtmlFromAUrl()
    {
        $fi = new Firstimg('http://www.terrymatula.com/simple.php');
        $html = '<html><head><title>Simple Page</title></head><body><h2>Hello</h2><img src="open.gif"></body></html>';
        $this->assertEquals($html, $fi->getHtml());
    }

    public function testNotFoundUrl()
    {
        $this->setExpectedException('Exception');
        $fi = new Firstimg('http://www.terrymatula.com/blah.php');
        $fi->getHtml();
    }

    public function testFoundFirstImage()
    {
        $fi = new Firstimg('http://www.terrymatula.com/simple.php');
        $image = 'http://www.terrymatula.com/open.gif';
        $this->assertEquals($image, $fi->findImage()->getImageUri());
    }
}
 