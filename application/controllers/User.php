<?php
/**
 * Created by PhpStorm.
 * User: kiwi
 * Date: 2018/2/4
 * Time: 下午6:42
 */
//use Yaf\UserModel;
use Yaf\Controller_Abstract;

class UserController extends Controller_Abstract
{

    public  function init(){
        $request = $this->getRequest();
    }

    public function registerAction(){

        $userName = $this->getRequest()->getPost("name",false);
        $passwd  = $this->getRequest()->getPost("password",false);

        if(!$userName || !$passwd ){
            echo json_encode([
                "errno"=>"0002",
                "errmsg"=>"用户名与密码是必传参数"
            ]);

            return false;
        }
        $model = new UserModel();

        if ($passwd = $model ->register(trim($userName),trim($passwd))){
            echo json_encode([
                "errno"=>"0",
                "errmsg"=>"",
                "data"=>[
                    "name"=>$userName,
                    "passwd"=>$passwd
                ]
            ]);

        } else {
            echo json_encode([
                "errno"=>$model->errno,
                "errmsg"=>$model->errmsg,
            ]);
        }

        return false;
    }


    public function loginAction(){
        $submit = $this->getRequest()->getQuery("submit","0");
        if( $submit != "login") {
            echo json_encode([
                "errno" => -1001,
                "errmsg" => "请通过正确渠道提交"
            ]);
            return false;
        }

        // 获取参数

        $username = $this ->getRequest()->getPost("name",false);
        $passwd = $this -> getRequest()->getPost("password",false);

        if( !$username || !$passwd) {
            echo json_encode([
                "errno" => -1002,
                "errmsg" => "用户名与密码必须传递"
            ]);
            return false;
        }

        $model = new UserModel();
        if ($uid = $model ->login(trim($username),trim($passwd))){

            session_start();
            $_SESSION["user_token"] = md5("sal".$_SERVER['REQUEST_TIME'].$uid);
            $_SESSION["user_token_time"] = $_SERVER['REQUEST_TIME'];
            $_SESSION["user_id"] = $uid;
            echo json_encode([
                "errno"=>"0",
                "errmsg"=>"",
                "data"=>[
                    "name"=>$username
                ]
            ]);
        } else {
            echo json_encode([
                "errno"=>$model->errno,
                "errmsg"=>$model->errmsg,
            ]);
        }
        return false;
    }
}