<?php

namespace Framework\Models;

use Framework\Libs\Config;
use Framework\Libs\Session;
use Framework\Libs\Password;
use Framework\Libs\Hash;
use Framework\Libs\Cookie;
use Framework\Core\DB;

class User {

    private $user_table = 'cms_users';
    private $group_table = 'cms_groups';
    private $session_table = 'cms_users_session';

    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn;

    public function __construct(DB $db, $user = null) {
        $this->_db = $db;
        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');
        if (!$user) {
            if (Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);

                if ($this->find($user)) {
                    $this->_isLoggedIn = true;
                } else {
                    $this->logout();
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function update($fields = array(), $id = null) {
        if (!$id && $this->isLoggedIn()) {
            $id = $this->data()->id;
        }
        if (!$this->_db->update($this->user_table, $id, $fields)) {
            throw new Exception('There was a problem updating.');
        }
    }

    public function create($fields) {
        if (!$this->_db->insert($this->user_table, $fields)) {
            throw new Exception('<p>An error occured. Try again or <a href="contact">contact us<a> if you keep getting this message.</p>');
        }
    }

    public function find($user = null) {
        if ($user) {
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get(array('*'), $this->user_table, array(array($field, '=', $user)));
            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function login($username = null, $password = null, $remember = false) {
        if (!$username && !$password && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->id);
            $this->_isLoggedIn = true;
        } else {
            $user = $this->find($username);
            if ($user) {
                if (Password::my_password_needs_rehash($this->data()->password)) {
                    $new_hashed_password = Password::my_password_hash($this->data()->password, array('Salt' => Hash::salt(32), 'Cost' => 10));
                    $this->_db->update($this->user_table, $this->data()->id, array('password' => $new_hashed_password));
                    $this->data()->password = $new_hashed_password;
                }
                if (Password::my_password_verify($password, $this->data()->password)) {
                    Session::put($this->_sessionName, $this->data()->id);
                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get(array('*'), $this->session_table, array(array('user_id', '=', $this->data()->id)));
                        if (!$hashCheck->count()) {
                            $this->_db->insert($this->session_table, array(
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ));
                        } else {
                            $hashCheck = $hashCheck->first()->hash;
                        }
                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }
                    $this->_isLoggedIn = true;
                    return true;
                }
            }
        }
        return false;
    }

    public function hasPermission($key) {
        $group = $this->_db->get(array('*'), $this->group_table, array(array('id', '=', $this->data()->group)));
        if ($group->count()) {
            $permissions = json_decode($group->first()->permissions, true);
            if ($permissions[$key] == true) {
                return true;
            }
        }
        return false;
    }

    public function exists() {
        return (!empty($this->_data)) ? true : false;
    }

    public function logout() {
        $this->_db->delete($this->session_table, array(array('user_id', '=', $this->data()->id)));
        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }

    public function data() {
        return $this->_data;
    }

    public function isLoggedIn() {
        return $this->_isLoggedIn;
    }

}
