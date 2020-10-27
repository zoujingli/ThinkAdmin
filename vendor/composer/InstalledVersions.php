<?php

namespace Composer;

use Composer\Semver\VersionParser;






class InstalledVersions
{
private static $installed = array (
  'root' => 
  array (
    'pretty_version' => '6.x-dev',
    'version' => '6.9999999.9999999.9999999-dev',
    'aliases' => 
    array (
    ),
    'reference' => '2ec3ac9e203d49e1e55a027e90002117cf84ea0a',
    'name' => 'zoujingli/thinkadmin',
  ),
  'versions' => 
  array (
    'endroid/qr-code' => 
    array (
      'pretty_version' => '1.9.3',
      'version' => '1.9.3.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c9644bec2a9cc9318e98d1437de3c628dcd1ef93',
    ),
    'league/flysystem' => 
    array (
      'pretty_version' => '1.1.3',
      'version' => '1.1.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '9be3b16c877d477357c015cec057548cf9b2a14a',
    ),
    'league/flysystem-cached-adapter' => 
    array (
      'pretty_version' => '1.1.0',
      'version' => '1.1.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd1925efb2207ac4be3ad0c40b8277175f99ffaff',
    ),
    'league/mime-type-detection' => 
    array (
      'pretty_version' => '1.5.1',
      'version' => '1.5.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '353f66d7555d8a90781f6f5e7091932f9a4250aa',
    ),
    'psr/cache' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd11b50ad223250cf17b86e38383413f5a6764bf8',
    ),
    'psr/container' => 
    array (
      'pretty_version' => '1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b7ce3b176482dbbc1245ebf52b181af44c2cf55f',
    ),
    'psr/log' => 
    array (
      'pretty_version' => '1.1.3',
      'version' => '1.1.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '0f73288fd15629204f9d42b7055f72dacbe811fc',
    ),
    'psr/simple-cache' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '408d5eafb83c57f6365a3ca330ff23aa4a5fa39b',
    ),
    'symfony/options-resolver' => 
    array (
      'pretty_version' => 'v3.4.45',
      'version' => '3.4.45.0',
      'aliases' => 
      array (
      ),
      'reference' => '0edf31d2e34f4adb72dd4d2e4a8aa21f84b943e5',
    ),
    'topthink/framework' => 
    array (
      'pretty_version' => 'v6.0.5',
      'version' => '6.0.5.0',
      'aliases' => 
      array (
      ),
      'reference' => '85625d984f5c96699dc27d384869f206c3aec1cc',
    ),
    'topthink/think-helper' => 
    array (
      'pretty_version' => 'v3.1.4',
      'version' => '3.1.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c28d37743bda4a0455286ca85b17b5791d626e10',
    ),
    'topthink/think-orm' => 
    array (
      'pretty_version' => 'v2.0.34',
      'version' => '2.0.34.0',
      'aliases' => 
      array (
      ),
      'reference' => '57f9b98895b0ff4ae7b7b75e51456fd8cb8fb629',
    ),
    'topthink/think-template' => 
    array (
      'pretty_version' => 'v2.0.7',
      'version' => '2.0.7.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e98bdbb4a4c94b442f17dfceba81e0134d4fbd19',
    ),
    'topthink/think-view' => 
    array (
      'pretty_version' => 'v1.0.14',
      'version' => '1.0.14.0',
      'aliases' => 
      array (
      ),
      'reference' => 'edce0ae2c9551ab65f9e94a222604b0dead3576d',
    ),
    'zoujingli/ip2region' => 
    array (
      'pretty_version' => 'v1.0.8',
      'version' => '1.0.8.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd6be3ab9da1a1ab7e3cd51c4aa634a34de358ce6',
    ),
    'zoujingli/think-library' => 
    array (
      'pretty_version' => 'v6.0.x-dev',
      'version' => '6.0.9999999.9999999-dev',
      'aliases' => 
      array (
        0 => '9999999-dev',
      ),
      'reference' => '51051855309a5752c0adb8f8d63129a43fd139ce',
    ),
    'zoujingli/thinkadmin' => 
    array (
      'pretty_version' => '6.x-dev',
      'version' => '6.9999999.9999999.9999999-dev',
      'aliases' => 
      array (
      ),
      'reference' => '2ec3ac9e203d49e1e55a027e90002117cf84ea0a',
    ),
    'zoujingli/wechat-developer' => 
    array (
      'pretty_version' => 'v1.2.26',
      'version' => '1.2.26.0',
      'aliases' => 
      array (
      ),
      'reference' => '5ecafcd810627cd9217c3d7f18c7026612418278',
    ),
  ),
);







public static function getInstalledPackages()
{
return array_keys(self::$installed['versions']);
}









public static function isInstalled($packageName)
{
return isset(self::$installed['versions'][$packageName]);
}














public static function satisfies(VersionParser $parser, $packageName, $constraint)
{
$constraint = $parser->parseConstraints($constraint);
$provided = $parser->parseConstraints(self::getVersionRanges($packageName));

return $provided->matches($constraint);
}










public static function getVersionRanges($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

$ranges = array();
if (isset(self::$installed['versions'][$packageName]['pretty_version'])) {
$ranges[] = self::$installed['versions'][$packageName]['pretty_version'];
}
if (array_key_exists('aliases', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['aliases']);
}
if (array_key_exists('replaced', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['replaced']);
}
if (array_key_exists('provided', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['provided']);
}

return implode(' || ', $ranges);
}





public static function getVersion($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['version'])) {
return null;
}

return self::$installed['versions'][$packageName]['version'];
}





public static function getPrettyVersion($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['pretty_version'])) {
return null;
}

return self::$installed['versions'][$packageName]['pretty_version'];
}





public static function getReference($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['reference'])) {
return null;
}

return self::$installed['versions'][$packageName]['reference'];
}





public static function getRootPackage()
{
return self::$installed['root'];
}







public static function getRawData()
{
return self::$installed;
}



















public static function reload($data)
{
self::$installed = $data;
}
}
