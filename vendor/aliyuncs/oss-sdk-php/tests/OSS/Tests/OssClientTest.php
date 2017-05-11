<?php

namespace OSS\Tests;

use OSS\Core\OssException;
use OSS\OssClient;

class OssClientTest extends \PHPUnit_Framework_TestCase
{
    public function testConstrunct()
    {
        try {
            $ossClient = new OssClient('id', 'key', 'http://oss-cn-hangzhou.aliyuncs.com');
            $this->assertFalse($ossClient->isUseSSL());
            $ossClient->setUseSSL(true);
            $this->assertTrue($ossClient->isUseSSL());
            $this->assertTrue(true);
            $this->assertEquals(3, $ossClient->getMaxRetries());
            $ossClient->setMaxTries(4);
            $this->assertEquals(4, $ossClient->getMaxRetries());
            $ossClient->setTimeout(10);
            $ossClient->setConnectTimeout(20);
        } catch (OssException $e) {
            assertFalse(true);
        }
    }

    public function testConstrunct2()
    {
        try {
            $ossClient = new OssClient('id', "", 'http://oss-cn-hangzhou.aliyuncs.com');
            $this->assertFalse(true);
        } catch (OssException $e) {
            $this->assertEquals("access key secret is empty", $e->getMessage());
        }
    }

    public function testConstrunct3()
    {
        try {
            $ossClient = new OssClient("", 'key', 'http://oss-cn-hangzhou.aliyuncs.com');
            $this->assertFalse(true);
        } catch (OssException $e) {
            $this->assertEquals("access key id is empty", $e->getMessage());
        }
    }

    public function testConstrunct4()
    {
        try {
            $ossClient = new OssClient('id', 'key', "");
            $this->assertFalse(true);
        } catch (OssException $e) {
            $this->assertEquals('endpoint is empty', $e->getMessage());
        }
    }

    public function testConstrunct5()
    {
        try {
            $ossClient = new OssClient('id', 'key', "123.123.123.1");
        } catch (OssException $e) {
            $this->assertTrue(false);
        }
    }

    public function testConstrunct6()
    {
        try {
            $ossClient = new OssClient('id', 'key', "https://123.123.123.1");
            $this->assertTrue($ossClient->isUseSSL());
        } catch (OssException $e) {
            $this->assertTrue(false);
        }
    }

    public function testConstrunct7()
    {
        try {
            $ossClient = new OssClient('id', 'key', "http://123.123.123.1");
            $this->assertFalse($ossClient->isUseSSL());
        } catch (OssException $e) {
            $this->assertTrue(false);
        }
    }

    public function testConstrunct8()
    {
        try {
            $ossClient = new OssClient('id', 'key', "http://123.123.123.1", true);
            $ossClient->listBuckets();
            $this->assertFalse(true);
        } catch (OssException $e) {

        }
    }

    public function testConstrunct9()
    {
        try {
	    $accessKeyId = ' ' . getenv('OSS_ACCESS_KEY_ID') . ' ';
	    $accessKeySecret = ' ' . getenv('OSS_ACCESS_KEY_SECRET') . ' ';
	    $endpoint = ' ' . getenv('OSS_ENDPOINT') . '/ ';
            $ossClient = new OssClient($accessKeyId, $accessKeySecret , $endpoint, false);
            $ossClient->listBuckets();
        } catch (OssException $e) {
            $this->assertFalse(true);
        }
    }

}
