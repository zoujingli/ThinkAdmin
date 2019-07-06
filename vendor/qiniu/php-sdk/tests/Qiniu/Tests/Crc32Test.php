<?php
namespace Qiniu\Tests;

use Qiniu;
use PHPUnit\Framework\TestCase;

class Crc32Test extends TestCase
{
    public function testData()
    {
        $a = '你好';
        $b = \Qiniu\crc32_data($a);
        $this->assertEquals('1352841281', $b);
    }

    public function testFile()
    {
        $b = \Qiniu\crc32_file(__file__);
        $c = \Qiniu\crc32_file(__file__);
        $this->assertEquals($c, $b);
    }
}
