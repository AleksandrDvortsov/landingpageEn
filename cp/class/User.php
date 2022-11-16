<?php

class User
{
    private $_db;
    private $_Cpu;
    private $_errors;

    public function __construct()
    {
        global $db,$Cpu;
        $this->_db = $db;
        $this->_errors = array();
        $this->_Cpu = $Cpu;
    }

    // проверка какой группе принадлежит авторизированный пользователь
    public function access_control( $group_id )
    {
        if( $this->check_cp_authorization() && is_array($group_id) && count($group_id)>0 )
        {
            $this->_db->where('usergroup', $group_id, 'IN');
            $this->_db->where('active', 1);
            $this->_db->where('login', $_SESSION['cp_login'] );
            $this->_db->where('password',$_SESSION['cp_password']);
            $this->_db->where('login_crypt', $_SESSION['cp_login_crypt']);
            $user = $this->_db->getOne ('cp_users');
            if ( $this->_db->count !=0 )
            {
                return true;
            }
            else
                return false;
        }
        else
        {
            return false;
        }
    }


    public function getId()
    {
        $user = $this->_db
            ->where('login', $_SESSION['cp_login'] )
            ->where('password',$_SESSION['cp_password'])
            ->getOne ('cp_users', "id");
        if($user)
        {
            return $user['id'];
        }
        else
        {
            return false;
        }
    }

    public function getUser($id)
    {
        $user = $this->_db
            ->where('id', $id)
            ->getOne('cp_users');
        if($user)
        {
            return $user;
        }
        else
        {
            return false;
        }
    }

    public function getCpUserStatus($id)
    {
        $user_info = $this->_db
            ->where('id', $id)
            ->getOne('cp_users');

        $user_status = $this->_db
            ->where("id", $user_info['usergroup'])
            ->getOne('user_group', "*");

        if($user_status)
        {
            return $user_status;
        }
        else
        {
            return false;
        }
    }


    public function generate_token()
    {
        $_SESSION['token'] = md5(uniqid(mt_rand(),true));
        return $_SESSION['token'];
    }

    private function check_for_update_cp_keys()
    {
        $secret_keys_info = $this->_db
            ->where('id', 1)
            ->getOne('cp_keys');
        if($secret_keys_info)
        {
            if( $secret_keys_info['updated_at'] === NULL )
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public function check_cp_authorization()
    {
        if
        (
            isset($_SESSION['cp_login'],$_SESSION['cp_password'],$_SESSION['cp_login_crypt'])
            &&
            trim($_SESSION['cp_login'])!="" && trim($_SESSION['cp_password'])!="" && trim($_SESSION['cp_login_crypt'])!=""
        )
        {
            $user = $this->_db
                ->where('login', $_SESSION['cp_login'] )
                ->where('password', $_SESSION['cp_password'])
                ->where('login_crypt', $_SESSION['cp_login_crypt'])
                ->getOne ('cp_users');

            if ( $user )
            {
                if($user['active']==1)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    private function GenerateSecretKey($length = 32)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function encrypt($string)
    {
        $output = '';
        $encrypt_method = "AES-256-CBC";

        //Extragem datele keylor secrete
        $secret_key_info = $this->_db
            ->where('id', 1)
            ->getOne('cp_keys');


        if($secret_key_info)
        {
            $secret_key = $secret_key_info['secret_key'];
            $secret_iv = $secret_key_info['secret_iv'];

            if( strlen($secret_key) == 32 && strlen($secret_iv) == 32 )
            {
                // hash
                $key = hash('sha256', $secret_key);
                // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
                $iv = substr(hash('sha256', $secret_iv), 0, 16);
                $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
                $output = base64_encode($output);
            }
        }

        return $output;
    }


    public function hide_dates($action, $string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";

        //Extragem datele keylor secrete
        $secret_key_info = $this->_db
            ->where('id', 1)
            ->getOne('cp_keys');

        if($secret_key_info)
        {
            $secret_key = $secret_key_info['secret_key'];
            $secret_iv = $secret_key_info['secret_iv'];

            if( strlen($secret_key) == 32 && strlen($secret_iv) == 32 )
            {
                // hash
                $key = hash('sha256', $secret_key);
                // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
                $iv = substr(hash('sha256', $secret_iv), 0, 16);
                if ($action == 'encrypt')
                {
                    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
                    $output = base64_encode($output);
                }
                else if ($action == 'decrypt')
                {
                    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
                }
            }
        }

        return $output;
    }


    public function cp_check_and_login($post_username,$post_password,$post_keystring,$post_token)
    {
        $username = $this->_db->escape ($post_username);
        $password = $this->_db->escape ($post_password);

        if(  isset($_SESSION['captcha']['code']) && trim($_SESSION['captcha']['code'])!="" &&  $_SESSION['captcha']['code'] == $post_keystring )
        {
            if ( isset($_SESSION['token']) && trim($_SESSION['token'])!="" && $_SESSION['token'] == $post_token )
            {

                unset($_SESSION['captcha']['code']);

                $ecrypted_pass = $this->encrypt($password);

                $user = $this->_db
                    ->where ('login', $username )
                    ->where ('password', $ecrypted_pass )
                    ->getOne ('cp_users');

                if ($user)
                {
                    if($user['active']==1)
                    {
                        if($this->check_for_update_cp_keys())
                        {
                            // daca key-le secrete sunt standarte, atunci le innoim
                            $secret_key = $this->GenerateSecretKey();
                            $secret_iv = $this->GenerateSecretKey();
                            $update_secret_keys_data_info = Array (
                                'secret_key' => $secret_key,
                                'secret_iv' => $secret_iv
                            );

                            $update_secret_keys_data_info = $this->_db
                                ->where ('id', 1)
                                ->update ('cp_keys', $update_secret_keys_data_info, 1);
                            if ($update_secret_keys_data_info)
                            {
                                $new_encrypted_password = $this->encrypt($password);
                                if($new_encrypted_password != '')
                                {
                                    //innoim cryptarea parolei
                                    $update_user_encrypt_password_data_info = Array (
                                        'password' => $new_encrypted_password
                                    );
                                    $update_user_encrypt_password_data = $this->_db
                                        ->where ('id', $user['id'])
                                        ->update ('cp_users', $update_user_encrypt_password_data_info, 1);
                                    if($update_user_encrypt_password_data)
                                    {
                                        $user['password'] = $new_encrypted_password;
                                    }
                                }
                                else
                                {
                                    $this->_errors[] = "Au aparut errori la generarea parolei cu cripare noua";
                                    return false;
                                }
                            }
                            else
                            {
                                $this->_errors[] = "Au aparut errori la innoirea key-lor secrete";
                                return false;
                            }
                        }

                        // update login_crypt
                        $new_login_crypt = $this->encrypt($user['login'].md5(uniqid(mt_rand(),true)));
                        $update_login_crypt_data_info = Array (
                            'login_crypt' => $new_login_crypt
                        );
                        $update_login_crypt_data = $this->_db
                            ->where ('id', $user['id'])
                            ->update ('cp_users', $update_login_crypt_data_info, 1);
                        if ($update_login_crypt_data)
                        {
                            $_SESSION['cp_login'] = $user['login'];
                            $_SESSION['cp_password'] = $user['password'];
                            $_SESSION['cp_login_crypt'] = $new_login_crypt;
                            header("location: ".$this->_Cpu->getURL(1));
                        }
                        else
                        {
                            $this->_errors[] = "Ошибка обновление данных, пожалуйста свяжитесь с администратором!";
                            return false;
                        }

                    }
                    else
                    {
                        $this->_errors[] = "Пользователь заблокирован!";
                        return false;
                    }
                }
                else
                {
                    $this->_errors[] = "Неверные данные, пожалуйста повторите авторизацию!";
                    return false;
                }


            }
            else
            {
                $this->_errors[] = "Ошибка обработки данных, пожалуйста повторите авторизацию!";
                return false;
            }

        }
        else
        {
            $this->_errors[]= "Вы ввели неверную каптчу!";
            return false;
        }
    }

    public function check_cp_user_in_db($username,$password)
    {
        $user_info = $this->_db
            ->where ('cp_login', $username )
            ->where ('password',$password)
            ->getOne ('cp_users');
        if ( count($user_info) !=0 )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function content_editor($type, $code)
    {
        $access = array(1,2);
        if($this->check_cp_authorization())
        {
            if($this->access_control($access))
            {
                if(!strcmp ( $type , 'dictionary'))
                {
                    return "<img data-word_change_code=".$code." class='editor_access_block' width='24' height='24' src='/css/images/admin_editor.png'>";
                }
            }
        }
    }

    public function showErrors()
    {
        return $this->_errors;
    }


}