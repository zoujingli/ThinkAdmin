<?php
// Hack to override the time returned from the S3SignatureV4
// @codingStandardsIgnoreStart
namespace Qiniu {
    function time()
    {
        return isset($_SERVER['override_qiniu_auth_time'])
            ? 2234567890
            : \time();
    }
}

namespace Qiniu\Tests {
    use Qiniu\Auth;
    use PHPUnit\Framework\TestCase;

    // @codingStandardsIgnoreEnd

    class AuthTest extends TestCase
    {

        public function testSign()
        {
            global $dummyAuth;
            $token = $dummyAuth->sign('test');
            $this->assertEquals('abcdefghklmnopq:mSNBTR7uS2crJsyFr2Amwv1LaYg=', $token);
        }

        public function testSignWithData()
        {
            global $dummyAuth;
            $token = $dummyAuth->signWithData('test');
            $this->assertEquals(
                'abcdefghklmnopq:-jP8eEV9v48MkYiBGs81aDxl60E=:dGVzdA==',
                $token
            );
        }

        public function testSignRequest()
        {
            global $dummyAuth;
            $token = $dummyAuth->signRequest('http://www.qiniu.com?go=1', 'test', '');
            $this->assertEquals('abcdefghklmnopq:cFyRVoWrE3IugPIMP5YJFTO-O-Y=', $token);
            $ctype = 'application/x-www-form-urlencoded';
            $token = $dummyAuth->signRequest('http://www.qiniu.com?go=1', 'test', $ctype);
            $this->assertEquals(
                $token,
                'abcdefghklmnopq:svWRNcacOE-YMsc70nuIYdaa1e4='
            );
        }

        public function testPrivateDownloadUrl()
        {
            global $dummyAuth;
            $_SERVER['override_qiniu_auth_time'] = true;
            $url = $dummyAuth->privateDownloadUrl('http://www.qiniu.com?go=1');
            $expect = 'http://www.qiniu.com?go=1&e=2234571490&token=abcdefghklmnopq:Hvi3R79Sl6wZy1c331nv0iIFoJk=';
            $this->assertEquals($expect, $url);
            unset($_SERVER['override_qiniu_auth_time']);
        }

        public function testUploadToken()
        {
            global $dummyAuth;
            $_SERVER['override_qiniu_auth_time'] = true;
            $token = $dummyAuth->uploadToken('1', '2', 3600, array('endUser' => 'y'));
            // @codingStandardsIgnoreStart
            $exp = 'abcdefghklmnopq:GracWhW1iGwVL6haVH5dr4gjqeo=:eyJlbmRVc2VyIjoieSIsInNjb3BlIjoiMToyIiwiZGVhZGxpbmUiOjIyMzQ1NzE0OTB9';
            // @codingStandardsIgnoreEnd
            $this->assertEquals($exp, $token);
            unset($_SERVER['override_qiniu_auth_time']);
        }
    }
}
