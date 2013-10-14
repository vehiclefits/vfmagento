<?php
$mageRoot = str_replace('vf-upgrade', '', dirname($_SERVER['SCRIPT_FILENAME']));

require_once $mageRoot . 'app/code/local/Elite/vendor/autoload.php';
putenv('PHINX_MIGRATIONS_DIR=test');
putenv('PHINX_DBNAME=localhost');
putenv('PHINX_DBNAME=magento');
putenv('PHINX_DB_USER=root');
putenv('PHINX_DB_PASS=');
putenv('PHINX_DB_PORT=3306');

require_once $mageRoot . 'lib/Zend/Config.php';
require_once $mageRoot . 'lib/Zend/Config/Xml.php';
$config = new Zend_Config_Xml($mageRoot.'app/etc/local.xml');
$dbConfig = $config->toArray();
$dbinfo = $dbConfig['global']['resources']['default_setup']['connection'];

$_SERVER['PHINX_MIGRATIONS_DIR'] = $mageRoot.'app/code/local/Elite/migrations';
$_SERVER['PHINX_HOST'] = $dbinfo['host'];
$_SERVER['PHINX_USER'] = $dbinfo['username'];
$_SERVER['PHINX_PASSWORD'] = $dbinfo['password'];
$_SERVER['PHINX_DBNAME'] = $dbinfo['dbname'];
$_SERVER['PHINX_PORT'] = 3306;


use Symfony\Component\Console\Output\Output;


file_put_contents($mageRoot.'var/vf-upgrade-progress.txt', '');
chmod($mageRoot.'var/vf-upgrade-progress.txt', 0777);

class BufferedOutput extends Output
{
    protected $buffer;

    public function doWrite($message, $newline)
    {
        global $mageRoot;
        $h = fopen($mageRoot.'var/vf-upgrade-progress.txt', 'a');
        fwrite($h, $message . ($newline? PHP_EOL: ''));
        $this->buffer .= $message. ($newline? PHP_EOL: '');
    }

    public function getBuffer()
    {
        return $this->buffer;
    }
}

ini_set('display_errors',1);
error_reporting(E_ALL);

$input = new \Symfony\Component\Console\Input\StringInput('migrate -c '.$mageRoot.'app/code/local/Elite/phinx.yml -e main');

$output = new BufferedOutput;

$app = new Phinx\Console\PhinxApplication('0.2.8');
$app->setAutoExit(false);

$app->run($input, $output);