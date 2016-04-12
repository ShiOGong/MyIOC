<?php

/**
 * 控制器请求工厂，负责获取请求下a标签的控制器请求，并实例化对应文件
 */
class Factory {
	static private $_obj = null;

	// 负责分发a请求
	public static function setAction() {
		// 单入口
		$_a = self::getA();

		// 如果Action文件不存在，报错
		if ( ! file_exists( ROOT_PATH . '/action/' . $_a . 'Action.class.php' ) ) {
			exit( '不存在名为' . $_a . '的Action文件' );
		}

		// 为了保持用户友好，会重新定向到IndexAction
		/*
		if( ! file_exists(ROOT_PATH.'/action/'.$_a.'Action.class.php') ) {
			$_a = 'Index';
		}
		*/

		eval( 'self::$_obj = new ' . ucfirst( $_a ) . 'Action();' ); // 利用eval函数的特性，执行url中的请求action，将实例化后的action放入变量中
		return self::$_obj; // 直接返回action对象

		// 函数说明：eval(String str)    执行将字符串当作php命令执行，安全度不高，容易被利用
	}

	public static function setModel() {
		// 单入口
		$_a = self::getA();

		// 如果model文件存在，实例化model文件
		if ( file_exists( ROOT_PATH . '/model/' . $_a . 'Model.class.php' ) ) {
			eval( 'self::$_obj = new ' . ucfirst( $_a ) . 'Model();' ); // 利用eval函数的特性，执行url(a请求)中的请求action，将实例化后的action放入变量中
			return self::$_obj; // 直接返回model对象
		}
	}

	public static function setCheck() {
		// 单入口
		$_a = self::getA();

		// 如果check文件存在，实例化check文件
		if ( file_exists( ROOT_PATH . '/check/' . $_a . 'Check.class.php' ) ) {
			eval( 'self::$_obj = new ' . ucfirst( $_a ) . 'Check();' ); // 利用eval函数的特性，执行url(a请求)中的请求check，将实例化后的check放入变量中
			return self::$_obj; // 直接返回check对象
		}
	}

	// 得到url中的a请求
	public static function getA() {
		if ( isset( $_GET['a'] ) && ! empty( $_GET['a'] ) ) {
			return $_GET['a'];
		}
		return 'Index';
	}
}

