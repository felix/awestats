<?php

/**
 * Copyright (c) 2013 Thomas Pierson <thomas@mezcalito.fr>
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */
 
class UserBackendMysql implements UserBackendInterface
{

	protected $mysqli;

    public function __construct($db_user, $db_password, $db_name) {
        try {
            $this->mysqli = new \mysqli("localhost", $db_user, $db_password, $db_name);
        } catch (\mysqli_sql_exception $e) {
           throw $e;
        }
    }
	
    public function exist($login, $password = null) {
    	try {
            $login = $this->mysqli->real_escape_string($login);
            if(isset($password)) {
                $password = $this->mysqli->real_escape_string(md5($password));
                $result = $this->mysqli->query("SELECT login, name FROM `users` WHERE `login` = '{$login}' AND `password`= '{$password}'");
            } else {
                $result = $this->mysqli->query("SELECT login, name FROM `users` WHERE `login` = '{$login}'");
            }
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
        $row = $result->fetch_assoc();
        if(!empty($row)) {
            return TRUE;
		}else {
			return FALSE;
		}
    }

    public function getName($login) {
    	try {
            $login = $this->mysqli->real_escape_string($login);
            $result = $this->mysqli->query("SELECT login, name FROM `users` WHERE `login` = '{$login}'");
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
        $row = $result->fetch_assoc();
        if(!empty($row)) {
        	return $row['name'];
        }else {
        	return '';
        }
    }
	
	
    public function getSites($login) {
    	$sites = array();
    	try {
            $login = $this->mysqli->real_escape_string($login);
            $result = $this->mysqli->query("SELECT login, name FROM `users` WHERE `login` = '{$login}'");
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
        $row = $result->fetch_assoc();
        if(!empty($row)) {
            $login = $row['login'];
            $name = $row['name'];
            try {
                $login = $this->mysqli->real_escape_string($login);
                $result = $this->mysqli->query("SELECT `url` FROM `websites` WHERE `user_login` = '{$login}'");
                while ($row = $result->fetch_assoc()) {
                    $sites[] = $row['url'];
                }
            } catch (mysqli_sql_exception $e) {
                throw $e;
            }
        }
        return $sites;
    }


}