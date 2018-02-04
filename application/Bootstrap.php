<?php
use Yaf\Application;
use Yaf\Bootstrap_Abstract;
use Yaf\Dispatcher;
use Yaf\Loader;
use Yaf\Registry;
use Yaf\Route_Interface;
/**
 * @name Bootstrap
 * @author vagrant
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends Bootstrap_Abstract {

    public function _initAutoload()
    {
        // 注册 Composer
        Loader::import(APPLICATION_PATH . "/vendor/autoload.php");
    }

    public function _initConfig() {
		//把配置保存起来
		$arrConfig = Application::app()->getConfig();
		Registry::set('config', $arrConfig);
	}

	public function _initPlugin(Dispatcher $dispatcher) {
		//注册一个插件
		$objSamplePlugin = new SamplePlugin();
		$dispatcher->registerPlugin($objSamplePlugin);
	}

	public function _initRoute(Dispatcher $dispatcher) {
		//在这里注册自己的路由协议,默认使用简单路由
        //创建一个路由协议实例
//        $router = $dispatcher::getInstance()->getRouter();
////        $route = new Route_Interface('user/reg/:username',
////        ['controller'=>'user','action' => 'reg']);
////        //使用路由器装载路由协议
////        $router->addRoute('user_reg', $route);
//
//        $route  = new \Yaf\Route\Rewrite(
//            "reg/:username",
//            [
//                'controller'=>'user',
//                'action' => 'reg'
//            ]
//        );
//        $router->addRoute('userReg', $route);
	}
	
	public function _initView(Dispatcher $dispatcher) {
		//在这里注册自己的view控制器，例如smarty,firekylin
	}
}
