<?php
/**
 * @author ShiO
 */
$url = 'www.test.com/index.php?a=Index&m=index';
$requestAction = 'IndexAction';
$requestMethod = 'index';
error_reporting( E_ALL );
// 创建一个实际路径
define( 'ROOT_PATH', substr( dirname( __FILE__ ), 0) );
// 加载系统配置文件
require ROOT_PATH . '/configs/main.conf.php';
require ROOT_PATH .  '/configs/message.conf.php';
// 错误级别
error_reporting( ERROR_REPORT );

// 自动加载方法
function __autoload( $_className ) {
    if ( substr( $_className, - 6 ) == 'Action' ) { // 如果后缀为action，加载action文件
        require ROOT_PATH . '/action/' . $_className . '.class.php';
    } elseif ( substr( $_className, - 5 ) == 'Model' ) { // 如果后缀为model，加载model文件
        require ROOT_PATH . '/model/' . $_className . '.class.php';
    } elseif (file_exists( ROOT_PATH . '/system/IOC/' . $_className . '.class.php' )){
        require ROOT_PATH.'/system/IOC/'.$_className.'.class.php';
    } elseif(file_exists( ROOT_PATH . '/system/' . $_className . '.class.php')){
        require ROOT_PATH.'/system/'.$_className.'.class.php';
    } elseif (file_exists( ROOT_PATH . '/exception/' . $_className . '.class.php' )){
        require ROOT_PATH.'/exception/'.$_className.'.class.php';
    }
}

// TODO::解析URL工厂
//Factory::setAction()->run();

$serI = new ControllerStrategy($requestAction,$requestMethod);
$serviceName = $serI->init();
if($serviceName == 'request'){
    $service = new Request();
    $serI->bindParam($service);
}
$serI->execute();
