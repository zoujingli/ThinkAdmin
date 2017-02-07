<?php
namespace Qiniu\Tests;

use Qiniu;
use Qiniu\Zone;

class ZoneTest extends \PHPUnit_Framework_TestCase
{
    protected $zone;
    protected $zoneHttps;
    protected $ak;

    protected $bucketName;
    protected $bucketNameBC;
    protected $bucketNameNA;


    protected function setUp()
    {
        global $bucketName;
        $this->bucketName = $bucketName;

        global $bucketNameBC;
        $this->bucketNameBC = $bucketNameBC;

        global $bucketNameNA;
        $this->bucketNameNA = $bucketNameNA;

        global $accessKey;
        $this->ak = $accessKey;

        $this->zone = new Zone();
        $this->zoneHttps = new Zone('https');
    }

    public function testUpHosts()
    {

        // test nb http
        list($upHosts, $err) = $this->zone->getUpHosts($this->ak, $this->bucketName);
        $this->assertNull($err);
        $this->assertEquals('http://up.qiniu.com', $upHosts[0]);
        $this->assertEquals('http://upload.qiniu.com', $upHosts[1]);

        // test bc http
        list($upHosts, $err) = $this->zone->getUpHosts($this->ak, $this->bucketNameBC);
        $this->assertNull($err);
        $this->assertEquals('http://up-z1.qiniu.com', $upHosts[0]);
        $this->assertEquals('http://upload-z1.qiniu.com', $upHosts[1]);

        // test na http
        list($upHosts, $err) = $this->zone->getUpHosts($this->ak, $this->bucketNameNA);
        $this->assertNull($err);
        $this->assertEquals('http://up-na0.qiniu.com', $upHosts[0]);

        // test nb https
        list($upHosts, $err) = $this->zoneHttps->getUpHosts($this->ak, $this->bucketName);
        $this->assertNull($err);
        $this->assertEquals('https://up.qbox.me', $upHosts[0]);

        // test bc https
        list($upHosts, $err) = $this->zoneHttps->getUpHosts($this->ak, $this->bucketNameBC);
        $this->assertNull($err);
        $this->assertEquals('https://up-z1.qbox.me', $upHosts[0]);

        // test na https
        list($upHosts, $err) = $this->zoneHttps->getUpHosts($this->ak, $this->bucketNameNA);
        $this->assertNull($err);
        $this->assertEquals('https://up-na0.qbox.me', $upHosts[0]);
    }

    public function testUpHostByToken()
    {
        $uptoken_bc = 'QWYn5TFQsLLU1pL5MFEmX3s5DmHdUThav9WyOWOm:bl77a3xPdTyBNYFGVRy
        oIQNyp_s=:eyJzY29wZSI6InBocHNkay1iYyIsImRlYWRsaW5lIjoxNDcwNzI1MzE1LCJ1cEhvc
        3RzIjpbImh0dHA6XC9cL3VwLXoxLnFpbml1LmNvbSIsImh0dHA6XC9cL3VwbG9hZC16MS5xaW5p
        dS5jb20iLCItSCB1cC16MS5xaW5pdS5jb20gaHR0cDpcL1wvMTA2LjM4LjIyNy4yNyJdfQ==';

        list($upHost, $err) = $this->zone->getUpHostByToken($uptoken_bc);
        $this->assertEquals('http://up-z1.qiniu.com', $upHost);
        $this->assertEquals(null, $err);

        list($upHostBackup, $err) = $this->zone->getBackupUpHostByToken($uptoken_bc);
        $this->assertEquals('http://upload-z1.qiniu.com', $upHostBackup);
        $this->assertEquals(null, $err);


        $uptoken_bc_https = 'QWYn5TFQsLLU1pL5MFEmX3s5DmHdUThav9WyOWOm:7I47O-vFcN5TKO
        6D7cobHPVkyIA=:eyJzY29wZSI6InBocHNkay1iYyIsImRlYWRsaW5lIjoxNDcwNzIyNzQ1LCJ1c
        Ehvc3RzIjpbImh0dHBzOlwvXC91cC16MS5xYm94Lm1lIl19';
        list($upHost, $err) = $this->zoneHttps->getUpHostByToken($uptoken_bc_https);
        $this->assertEquals('https://up-z1.qbox.me', $upHost);
        $this->assertEquals(null, $err);

        list($upHostBackup, $err) = $this->zoneHttps->getBackupUpHostByToken($uptoken_bc_https);
        $this->assertEquals('https://up-z1.qbox.me', $upHostBackup);
        $this->assertEquals(null, $err);
    }

    public function testIoHosts()
    {

        // test nb http
        $ioHost = $this->zone->getIoHost($this->ak, $this->bucketName);
        $this->assertEquals('http://iovip.qbox.me', $ioHost);

        // test bc http
        $ioHost = $this->zone->getIoHost($this->ak, $this->bucketNameBC);
        $this->assertEquals('http://iovip-z1.qbox.me', $ioHost);

        // test na http
        $ioHost = $this->zone->getIoHost($this->ak, $this->bucketNameNA);
        $this->assertEquals('http://iovip-na0.qbox.me', $ioHost);

        // test nb https
        $ioHost = $this->zoneHttps->getIoHost($this->ak, $this->bucketName);
        $this->assertEquals('https://iovip.qbox.me', $ioHost);

        // test bc https
        $ioHost = $this->zoneHttps->getIoHost($this->ak, $this->bucketNameBC);
        $this->assertEquals('https://iovip-z1.qbox.me', $ioHost);

        // test na https
        $ioHost = $this->zoneHttps->getIoHost($this->ak, $this->bucketNameNA);
        $this->assertEquals('https://iovip-na0.qbox.me', $ioHost);
    }
}
