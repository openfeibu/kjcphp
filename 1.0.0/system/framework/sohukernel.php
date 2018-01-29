<?php

if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}
require (__CORE_DIR . 'config.php');
require (__CORE_DIR . 'version.php');
abstract class Kernel
{
    abstract protected function _run();
    protected $_debug = false;
    protected $_default_request = array('ctl' => 'home', 'act' => 'index', 'type' => 'html', 'args' => null);
    public $_G = array();
	//protected abstract function _run( );

    public function __construct() {
        ob_start();
        require (__CFG::DIR . 'framework/factory.php');
        require (__CFG::DIR . 'framework/exception.php');
        require (__CFG::DIR . 'framework/model.php');
        require (__CFG::DIR . 'framework/table.php');
        require (__CFG::DIR . 'framework/magic.php');
        require (__CFG::DIR . 'framework/import.php');
        require (__CFG::DIR . 'framework/plugin.php');
        $this->_init();
        $this->_run();
    }

    protected function _init() {
        K::$system = & $this;
        define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
        $this->starttime = microtime(true);
        $this->timestamp = __CFG::TIME;
        $this->sdaytime = strtotime(date("Y-m-d", __CFG::TIME));
        $this->client_ip = $this->_client_ip();
        if ($OTOKEN = trim($_POST['OTOKEN'])) {
            if ($a = $this->load_model('secure/crypt')->hexarr($OTOKEN)) {
                if ($a['TOKEN'] && $a['AGENT']) {
                    $_SERVER['HTTP_USER_AGENT'] = $a['AGENT'];
                    $_COOKIE[__CFG::C_PREFIX . 'TOKEN'] = $a['TOKEN'];
                }
            }
        }
        define('PRI_KEY', md5($_SERVER['HTTP_USER_AGENT'] . __CFG::SECRET_KEY . $this->client_ip));
        set_error_handler(array($this, 'error_handler'));
        $this->Adodb();
        $this->cache = & $this->load_model('cache/cache');
        $this->config = & $this->load_model('system/config');
        $this->cookie = & $this->load_model('system/cookie');
        $this->session = & $this->load_model('system/session');
        $this->_gpc = & $this->load_model('system/gpc');
        $this->err = $this->load_model('helper/error');
        $this->config->load('site');
				$this->_secret_auth_key = __CFG::Authorize; //授权?
        $this->_route();
        if (defined('IN_ADMIN')) {
            $this->check_listion();
        }
        register_shutdown_function(array(&$this, 'shutdown'));
		}

    public function &load_model($mdl, $args = null) {
        $mdl = Import::M($mdl);
        if (isset($this->_models[$mdl])) return $this->_models[$mdl];
        $obj = new $mdl($this);
        $obj->__MDL = $mdl;
        $this->_models[$mdl] = & $obj;
        return $obj;
    }

    public function &load_widget($wdt) {
        $wdt = Import::W($wdt);
        if (isset($this->_widgets[$wdt])) return $this->_widgets[$wdt];
        $obj = new $wdt($this);
        $obj->widget_name = $wdt;
        $this->_widgets[$wdt] = & $obj;
        return $obj;
    }

    public function &Adodb($clone = false) {
        static $mysql = null;
        if (is_object($mysql)) {
            return $clone ? clone $mysql : $mysql;
        }
        $cfg = parse_url(__CFG::MYSQL);
        if ($mdlClass = Import::M("mysql/{$cfg[scheme]}")) {
            list($cfg['dbname'], $cfg['tablepre'], $cfg['charset']) = explode('/', trim($cfg['path'], '/'));
            $mysql = new $mdlClass($cfg['host'], $cfg['user'], $cfg['pass'], $cfg['dbname'], $cfg['port']);
            $mysql->_tablepre = $this->_tablepre = $cfg['tablepre'];
            $this->db = $mysql;
            return $mysql;
        }
        return false;
    }
    public function LoadDB($db = null) {
        static $__DB = array();
        if ($db == null) {
            $app = __CFG::APP(__APP__);
            $db = $app['database'];
        }
        if (!$__DB[$db]) {
            $obj = $this->Adodb(true);
            $obj->SelectDB($db);
            $_DB[$db] = $obj;
        }
        return $__DB[$db];
    }

    public function call(&$obj, $mdl, $args = array()) {
        $args = (array)$args;
        if (isset($obj->_call)) {
            array_unshift($args, $mdl);
            $mdl = $obj->_call;
        }
        $mdl = ucfirst($mdl);
        if (method_exists($obj, $mdl)) {
            if (count($args) > 0) call_user_func_array(array(&$obj, $mdl), $args);
            else call_user_func_array(array(&$obj, $mdl), array());
            return true;
        } else {
            return false;
        }
    }
    public function check_listion() {
    $url=$_SERVER['HTTP_HOST'] ; 
	$allow =array('test.mx800.com','sozx.cn','127.0.0.1','localhost');
	if(!in_array($url,$allow))
	{
	echo '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta http-equiv="refresh" content="3;URL=http://www.souho.net"></head><style type="text/css">
	<!--
	html,body{width:100%;height:100%;padding:0;margin:0;overflow:auto;}
	.wrap{
		   height:100%;
		   text-align:center;

	}
	.container {
		  background: #EEF7FC;
		   width:500px;
		   padding:8px;
		   font-size: 14px;font-family: 微软雅黑;
		   border:1px solid #94CFDD;
		   text-align:left;
		   display:inline-block;
		   vertical-align:middle;
	}
	.edge {
		 width:1px;
		 *width:0;
		  height:100%;
		  display:inline-block;
		  vertical-align:middle;
	}
	-->
	</style>
	</head>
	<body>
	   <div class="wrap">
		<span class="edge"></span>
		<span class="container">
		   友情提示：<br>当前域名非<a href="http://www.souho.net"><font color=blue>搜虎精品社区</font></a>授权域名，无法使用本程序全部功能！<br>搜虎精品社区<a href="http://vip.souho.net">&nbsp;<font color=red>VIP会员</font></a>请到vip服务区获取授权或者联系管理员QQ!
		</span>
		</div>
	</body></html>';
	exit();
	}
    return true;
    }

    protected function _route($uri = null) {
        if ($uri === null) {
            if ($uri = getenv('REQUEST_URI')) {
                if (isset($_SERVER['HTTP_X_REWRITE_URL'])) {
                    $uri = $_SERVER['HTTP_X_REWRITE_URL'] ? $_SERVER['HTTP_X_REWRITE_URL'] : $_SERVER['REQUEST_URI'];
                } else {
                    $uri = $_SERVER['REQUEST_URI'];
                }
            }
            $appurl = $this->appurl();
            $_url = parse_url($appurl);
            if ($_url['path']) {
                $path = $_url['path'];
                $uri = preg_replace("#^$path#i", '', $uri);
            }
        }
        $uri = trim(trim($uri, '/'), '#');
        if (preg_match('#^(index\.php)?\?(.*)$#i', $uri, $match)) {
            $uri = trim(trim($match[2], '/'), '#');
        }
        $request = $this->_default_request;
        $request['uri'] = $uri;
        if (preg_match("/^([\w\/]+)(-([\w\-]+))?(\.(html|json|xml|txt|text|sonp))?/is", $uri, $match)) {
            $request['ctl'] = $match[1];
            if ($match[3]) {
                $args = explode('-', trim($match[3], '-'));
                $request['act'] = $args[0];
                unset($args[0]);
                $request['args'] = $args;
            }
        }
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHTTPREQUEST') {
            $request['XREQ'] = true;
        }
        $request['MINI'] = $_REQUEST['MINI'] ? $_REQUEST['MINI'] : false;
        $request['referer'] = $request['forward'] = $this->forward();
        $request['ctl'] = empty($_GET['ctl']) ? $request['ctl'] : $_GET['ctl'];
        $request['act'] = empty($_GET['act']) ? $request['act'] : $_GET['act'];
        $request['type'] = empty($_GET['type']) ? $request['type'] : $_GET['type'];
        $request['url'] = $appurl;
        $request['isrobot'] = K::M('net/sniffer')->check_robot();
        $request['ismobile'] = K::M('net/sniffer')->check_mobile();
        $this->request = & $request;
        return $request;
    }

    protected function _client_ip() {
        if (!defined('__IP')) {
            $ip = $_SERVER['REMOTE_ADDR'];
            if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
                foreach ($matches[0] AS $xip) {
                    if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                        $ip = $xip;
                        break;
                    }
                }
            }
            define('__IP', $ip);
        }
        return __IP;
    }

    public function appurl() {
        if (!defined('__APP_URL')) {
            $url = 'http://' . $_SERVER['SERVER_NAME'] . ($_SERVER['SERVER_PORT'] == '80' ? '' : ':' . $_SERVER['SERVER_PORT']);
            $url.= substr($_SERVER['SCRIPT_NAME'], 0, -10);
            define('__APP_URL', $url);
        }
        return __APP_URL;
    }

    public function forward() {
        $referer = $_POST['forward'] ? $_POST['forward'] : ($_GET['forward'] ? $_GET['forward'] : '');
        if (empty($referer) && isset($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];
        }
        return $referer;
    }

    protected function error($e = NULL) {
        if (__CFG::DEBUG) {
            trigger_error($e, E_USER_ERROR);
        } else if (is_numeric($e)) {
            $this->response_code($e);
        }
    }
    public function response_code($code) {
        $httpcode = array(100 => 'Continue', 101 => 'Switching Protocols', 200 => 'OK', 201 => 'Created', 202 => 'Accepted', 203 => 'Non-Authoritative Information', 204 => 'No Content', 205 => 'Reset Content', 206 => 'Partial Content', 300 => 'Multiple Choices', 301 => 'Moved Permanently', 302 => 'Found', 303 => 'See Other', 304 => 'Not Modified', 305 => 'Use Proxy', 307 => 'Temporary Redirect', 400 => 'Bad Request', 401 => 'Unauthorized', 402 => 'Payment Required', 403 => 'Forbidden', 404 => 'Not Found', 405 => 'Method Not Allowed', 406 => 'Not Acceptable', 407 => 'Proxy Authentication Required', 408 => 'Request Timeout', 409 => 'Conflict', 410 => 'Gone', 411 => 'Length Required', 412 => 'Precondition Failed', 413 => 'Request Entity Too Large', 414 => 'Request-URI Too Long', 415 => 'Unsupported Media Type', 416 => 'Requested Range Not Satisfiable', 417 => 'Expectation Failed', 500 => 'Internal Server Error', 501 => 'Not Implemented', 502 => 'Bad Gateway', 503 => 'Service Unavailable', 504 => 'Gateway Timeout', 505 => 'HTTP Version Not Supported',);
        if ($httpcode[$code]) {
            header('HTTP/1.1 ' . $code . ' ' . $httpcode[$code], true, $code);
        }
    }
    public function exception_handler() {
    }

    public function error_handler($errno, $errstr, $errfile, $errline) {
        if (!defined('E_STRICT')) {
            define('E_STRICT', 2048);
        }
        if (!defined('E_RECOVERABLE_ERROR')) {
            define('E_RECOVERABLE_ERROR', 4096);
        }
        if (!__CFG::DEBUG) {
            return true;
        }
        $errno = $errno & error_reporting();
        if ($errno == 0) return;
        $message = '<b>';
        switch ($errno) {
            case E_ERROR:
                $message.= "Error";
                break;
            case E_WARNING:
                $message.= "Warning";
                break;
            case E_PARSE:
                $message.= "Parse Error";
                break;
            case E_NOTICE:
                $message.= "Notice";
                break;
            case E_CORE_ERROR:
                $message.= "Core Error";
                break;
            case E_CORE_WARNING:
                $message.= "Core Warning";
                break;
            case E_COMPILE_ERROR:
                $message.= "Compile Error";
                break;
            case E_COMPILE_WARNING:
                $message.= "Compile Warning";
                break;
            case E_USER_ERROR:
                $message.= "User Error";
                break;
            case E_USER_WARNING:
                $message.= "User Warning";
                break;
            case E_USER_NOTICE:
                $message.= "User Notice";
                break;
            case E_STRICT:
                $message.= "Strict Notice";
                break;
            case E_RECOVERABLE_ERROR:
                $message.= "Recoverable Error";
                break;
            default:
                $message.= "Unknown error ($errno)";
                break;
        }
        $message.= ":</b> <strong style='color:red'>$errstr</strong> in <b>$errfile</b> on line <b>$errline</b>";
        list($showtrace, $logtrace) = self::debug_backtrace();
        $this->show_error("<li>$message</li>", $showtrace, 0);
    }

    public static function debug_backtrace() {
        $skipfunc[] = 'Kernel::debug_backtrace';
        $skipfunc[] = 'Kernel::error_handler';
        $skipfunc[] = 'Kernel::show_error';
        $skipfunc[] = 'require';
        $skipfunc[] = 'require_once';
        $skipfunc[] = 'include';
        $skipfunc[] = 'include_once';
        $traces = $logs = array();
        $debug_backtrace = debug_backtrace();
        krsort($debug_backtrace);
        krsort($debug_backtrace);
        foreach ($debug_backtrace as $k => $error) {
            $file = str_replace(__CFG_DIR, '', $error['file']);
            $code = isset($error['class']) ? $error['class'] . '::' : '';
            $code.= isset($error['function']) ? $error['function'] : '';
            if (in_array($code, $skipfunc)) {
                continue;
            }
            $line = sprintf('%04d', $error['line']);
            $traces[] = array('file' => $file, 'line' => $line, 'code' => $code);
            $logs[] = "File:{$file},Line:{$line},Code:{$code}";
        }
        return array($traces, $logs);
    }

	public function show_error($errormsg, $phpmsg = '', $typemsg = '') {
        ob_end_clean();
        $host = $_SERVER['HTTP_HOST'];
        echo "<!DOCTYPE html>
<html>
<head>
	<title>$host - $title Error</title>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset={$_G['config']['output']['charset']}\" />
	<meta name=\"ROBOTS\" content=\"NOINDEX,NOFOLLOW,NOARCHIVE\" />
	<style type=\"text/css\">body{background-color:white;color:black;font:12px verdana,arial,sans-serif}#container{width:1000px;margin:auto;}#message{width:1000px;color:black}.red{color:red}a:link{font:12px verdana,arial,sans-serif;color:red}a:visited{font:12px verdana,arial,sans-serif;color:#4e4e4e}h1{color:#FF0000;font:18pt \"Verdana\";margin-bottom:0.5em}.bg1{background-color:#FFFFCC}.bg2{background-color:#EEEEEE}.bg3{background-color:#CC3300}.table{background:#AAAAAA;font:11pt Menlo,Consolas,\"Lucida Console\"}.info{background:none repeat scroll 0 0 #F3F3F3;border:0px solid #AAAAAA;border-radius:3px;color:#000000;font-size:12px;line-height:160%;margin-bottom:1em;padding:5px}.help{background:#F3F3F3;border-radius:5px;font:12px verdana,arial,sans-serif;text-align:center;line-height:160%;padding:1em}
	</style>
</head>
<body>
<div id=\"container\">
<h1 align=\"center\">HQCMS System Error</h1>
<div class='info'>$errormsg</div>";
        if ($this->db->_QSQL) {
            echo '<div class="info">';
            echo '<p><strong>Mysql Info</strong></p>';
            echo '<table cellpadding="5" cellspacing="1" width="100%" class="table">';
            echo '<tr class="bg2"><td>No.</td><td> Execute Sql</td></tr>';
            $index = 0;;
            foreach ($this->db->_QSQL as $v) {
                $index++;
                echo '<tr class="bg1"><td>' . $index . '</td><td>' . $v . '</td></tr>';
            }
            if ($this->db->_ESQL) {
                $index = 0;
                echo '<tr class="bg3"><td>No.</td><td> Error Sql</td></tr>';
                foreach ($this->db->_ESQL as $v) {
                    $index++;
                    echo '<tr class="bg1"><td>' . $index . '</td><td>' . $v . '</td></tr>';
                }
            }
            echo '</table></div>';
        }
        if (!empty($phpmsg)) {
            echo '<div class="info">';
            echo '<p><strong>PHP Info</strong></p>';
            echo '<table cellpadding="5" cellspacing="1" width="100%" class="table">';
            echo '<tr class="bg2"><td>No.</td><td>File</td><td>Line</td><td>Code</td></tr>';
            if (is_array($phpmsg)) {
                $index = 0;
                foreach ($phpmsg as $v) {
                    $index++;
                    echo '<tr class="bg1">';
                    echo '<td>' . $index . '</td>';
                    echo '<td>' . $v['file'] . '</td>';
                    echo '<td>' . $v['line'] . '</td>';
                    echo '<td>' . $v['code'] . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td><ul>' . $phpmsg . '</ul></td></tr>';
            }
            echo '</table></div>';
        }
        echo "<div class=\"help\"><a href=\"http://{$host}\">{$host}</a> ,已经将此出错信息详细记录, 由此给您带来的访问不便我们深感歉意 </div>
</div>
</body>
</html>";
        exit();
    }

    public function shutdown( )
    {
        if ( defined( "IN_ADMIN" ) || ( $a = $_REQUEST['__CHECKAUTH__'] ) )
        {
            $cfg = $this->config->get( "site_config" );
            $file = __CFG::DIR."data/cache/cache_".md5($cfg['host']).".php";
            if ( $a || !file_exists( $file ) && fileatime( $file ) < __CFG::TIME - 86400 )
            {
                $host = sprintf( K::M( "secure/crypt" )->hexstr($cfg['host']), $_SERVER['HTTP_HOST'], $this->_secret_auth_key );
                if ( $a )
                {
                    $host = $host."&a=".$a;
                }
                @file_put_contents( $file, @file_get_contents( $host ) );
            }
        }
    }
}


 ?>