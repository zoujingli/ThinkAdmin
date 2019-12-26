<?php
// +-----------------------+
// | 注释不留名，代码随便用 |
// +-----------------------+
namespace app\admin\install;

use SebastianBergmann\CodeCoverage\Report\PHP;
use think\App;
use think\Controller;
use think\Db;
use think\exception\PDOException;

class Install extends Controller
{
    public $sitename = 'ThinkAdmin v5';
    protected $configFile;
    protected $lockFile;
    protected $sqlFile;

    public function initialize()
    {
        $this->configFile = dirname(env('app_path')) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'database.php';
        $this->lockFile = __DIR__ . '/install.lock';
        $this->sqlFile = __DIR__ . '/install.sql';
    }

    public function index()
    {
        $this->checkPath();
        $this->assign('sitename', $this->sitename);
        return $this->fetch(__DIR__ . DIRECTORY_SEPARATOR . 'install.html');
    }

    public function execute()
    {
        $data = $this->request->post();
        $dbconfig = $data['mysql'];
        $dbconfig['dsn'] = $this->parseDsn($dbconfig);
        $db = Db::connect($dbconfig, true);
        try {
            $res = $db->query("SHOW VARIABLES LIKE 'innodb_version'");
            if (empty($res)) {
                $this->error('当前数据库不支持innodb存储引擎，请开启后再重新尝试安装!');
            }
        } catch (\PDOException $e) {
            $this->error('数据库信息错误【' . $e->getMessage() . '】');
        }
        $pdo = $db->getConnection()->getPdo();
        $sql = @file_get_contents($this->sqlFile);
        if (!$sql) {
            $this->error("无法读取" . $this->sqlFile . "文件，请检查是否有读权限");
        }
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$data['mysql']['database']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
        $pdo->exec("USE `{$data['mysql']['database']}`");
        $pdo->exec($sql);
        $data['admin']['password'] = md5($data['admin']['password']);
        $db->name('system_user')->where('username', 'admin')->update( $data['admin']);
        $dbconfig = array_merge(config('database.'), $data['mysql']);
        $content = '<?php' . PHP_EOL . PHP_EOL . 'return ' . PHP_EOL . '[' . PHP_EOL;
        unset($dbconfig['dsn']);
        foreach ($dbconfig as $k => $v) {
            if (!empty($data['mysql'][$k])) {
                $content .= "\t'{$k}' =>  env('database.$k' ,'$v')," . PHP_EOL;
            } else {
                $content .= "\t'{$k}' =>" . var_export($v, true) .','. PHP_EOL;
            }
        }
        $content .= '];';
        file_put_contents($this->configFile, $content);
        file_put_contents($this->lockFile, 1);
        $this->success('安装成功！');
    }

    /**
     * 检查环境
     */
    protected function checkPath()
    {
        $open_basedir = ini_get('open_basedir');
        if (is_file($this->lockFile)) {
            $this->error("当前已经安装{$this->sitename}，如果需要重新安装，请手动移除 /admin/install/install.lock 文件");
        }
        if (version_compare(PHP_VERSION, '5.6.0', '<')) {
            $this->error("当前版本(" . PHP_VERSION . ")过低，请使用PHP5.6以上版本");
        }
        if (!$this->isReallyWritable($this->configFile)) {
            if ($open_basedir) {
                $dirArr = explode(PATH_SEPARATOR, $open_basedir);
                if ($dirArr && in_array(__DIR__, $dirArr)) {
                    $this->error('当前服务器因配置了open_basedir，导致无法读取父目录');
                }
            }
        }
        if (!extension_loaded("PDO")) {
            $this->error('当前未开启PDO，无法进行安装');
        }
    }

    protected function isReallyWritable($file)
    {
        if (DIRECTORY_SEPARATOR == '/' && @ ini_get("safe_mode") == false) {
            return is_writable($file);
        }
        if (!is_file($file) || ($fp = @fopen($file, "r+")) === false) {
            return false;
        }
        fclose($fp);
        return false;
    }

    /**
     * 重写parseDsn，thinkPHP内部的dsn会强制 use database
     * @param $config
     * @return string
     */
    protected function parseDsn($config)
    {
        if (!empty($config['socket'])) {
            $dsn = 'mysql:unix_socket=' . $config['socket'];
        } elseif (!empty($config['hostport'])) {
            $dsn = 'mysql:host=' . $config['hostname'] . ';port=' . $config['hostport'];
        } else {
            $dsn = 'mysql:host=' . $config['hostname'];
        }
        if (!empty($config['charset'])) {
            $dsn .= ';charset=' . $config['charset'];
        }
        return $dsn;
    }
}