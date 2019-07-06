<?php
namespace Qiniu\Tests;

use Qiniu\Http\Client;
use PHPUnit\Framework\TestCase;

class DownloadTest extends TestCase
{
    public function test()
    {
        global $testAuth;
        $base_url = 'http://pojiwyou0.bkt.clouddn.com/demo.png';
        $private_url = $testAuth->privateDownloadUrl($base_url);
        $response = Client::get($private_url);
        $this->assertEquals(200, $response->statusCode);
    }

    public function testFop()
    {
        global $testAuth;
        $base_url = 'http://pojiwyou0.bkt.clouddn.com/demo.png?imageInfo';
        $private_url = $testAuth->privateDownloadUrl($base_url);
        $response = Client::get($private_url);
        $this->assertEquals(200, $response->statusCode);
    }
}
