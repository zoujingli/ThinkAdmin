<?php
namespace Qiniu\Tests;

use Qiniu\Processing\Operation;
use Qiniu\Processing\PersistentFop;
use PHPUnit\Framework\TestCase;

class FopTest extends TestCase
{
    public function testExifPub()
    {
        $fop = new Operation('7xkv1q.com1.z0.glb.clouddn.com');
        list($exif, $error) = $fop->execute('grape.jpg', 'exif');
        $this->assertNull($error);
        $this->assertNotNull($exif);
    }

    public function testExifPrivate()
    {
        global $testAuth;
        $fop = new Operation('private-res.qiniudn.com', $testAuth);
        list($exif, $error) = $fop->execute('noexif.jpg', 'exif');
        $this->assertNotNull($error);
        $this->assertNull($exif);
    }

    public function testbuildUrl()
    {
        $fops = 'imageView2/2/h/200';
        $fop = new Operation('7xkv1q.com1.z0.glb.clouddn.com');
        $url = $fop->buildUrl('grape.jpg', $fops);
        $this->assertEquals($url, 'http://7xkv1q.com1.z0.glb.clouddn.com/grape.jpg?imageView2/2/h/200');

        $fops = array('imageView2/2/h/200', 'imageInfo');
        $url = $fop->buildUrl('grape.jpg', $fops);
        $this->assertEquals($url, 'http://7xkv1q.com1.z0.glb.clouddn.com/grape.jpg?imageView2/2/h/200|imageInfo');
    }
}
