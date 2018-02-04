<?php
/**
 * Created by PhpStorm.
 * User: kiwi
 * Date: 2018/2/4
 * Time: 下午9:58
 */

class UserModel
{
    public $errno = 0;
    public $errmsg = "";

    public $_db = null;
    public $_key = "bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=";

    public function __construct() {
        $this->_db = new PDO("mysql:host=192.168.33.10;dbname=yaf;","homestead","secret");
    }

    public function register($userName,$passwd) {
        $query = $this->_db->prepare("SELECT count(*) AS u FROM `user` WHERE `name` = :names");
        $query->execute(["names"=>$userName]);
        $count = $query->fetchAll();

        if ($count[0]["u"] != 0){
            $this ->errno = -1005;
            $this ->errmsg = "用户名已存在";
            return false;
        }

        if (strlen($passwd) < 8){

            $this->errno = -1006;
            $this->errmsg = "密码太短，请设置至少8位密码";
            return false;
        } else {
            $passwd = $this->_password_generate($passwd);
            $userInster = $this->_db->prepare("INSERT INTO  user(`name`,`passwd`) VALUES (:names,:pwd)");
            $userInster->execute(["names"=>$userName,"pwd"=>$passwd]);
            $count = $userInster->fetchAll();
            print_r($count);
            if($count > 0 ){
                return "注册成功";
            }
//            $cricle_passwd = $this->_decrypt_decrypt($passwd);
            return false;
        }

        return false;
    }

    private function _password_generate($passwd){
        $passwd = $this->_encrypt($passwd,$this->_key);

        return $passwd;
    }
    private function _decrypt_decrypt($passwd){
        $passwd = $this->_decrypt($passwd,$this->_key);

        return $passwd;
    }


    private function _encrypt($data, $key)
    {
        // Remove the base64 encoding from our key
        $encryption_key = base64_decode($key);
        // Generate an initialization vector
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
        // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
        return base64_encode($encrypted . '::' . $iv);
    }

    /**
     * 解密函數
     */
    private function _decrypt($data, $key)
    {
        // Remove the base64 encoding from our key
        $encryption_key = base64_decode($key);
        // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }

    public function insertSample($arrInfo) {
        return true;
    }
}