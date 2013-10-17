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

class User implements Serializable {
    
    private $email;
    private $name;
    private $sites = array();
    
    public function __construct($email, $password = null) {
        try {
            $this->mysqli = new mysqli("localhost", DB_USER, DB_PASSWORD, DB_NAME);
            $email = $this->mysqli->real_escape_string($email);
            if(isset($password)) {
                $password = $this->mysqli->real_escape_string(md5($password));
                $result = $this->mysqli->query("SELECT email, name FROM `users` WHERE `email` = '{$email}' AND `password`= '{$password}'");
            } else {
                $result = $this->mysqli->query("SELECT email, name FROM `users` WHERE `email` = '{$email}'");
            }
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
        $row = $result->fetch_assoc();
        if(!empty($row)) {
            $this->email = $row['email'];
            $this->name = $row['name'];
            try {
                $email = $this->mysqli->real_escape_string($this->email);
                $result = $this->mysqli->query("SELECT `url` FROM `websites` WHERE `user_email` = '{$email}'");
                while ($row = $result->fetch_assoc()) {
                    $this->sites[] = $row['url'];
                }
            } catch (mysqli_sql_exception $e) {
                throw $e;
            }
        }
    }
    
    public function isValid() {
        if(empty($this->email) || empty($this->sites)) {
            return false;
        }
        return true;
    }
    
    public function getSites() {
        return $this->sites;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function serialize() {
        return serialize(array(
            'email' => $this->email,
            'name' => $this->name,
            'sites' => serialize($this->sites)
        ));
    }
    
    public function unserialize($data) {
        $data_unserialized = unserialize($data);
        $this->email = $data_unserialized['email'];
        $this->name = $data_unserialized['name'];
        $this->sites = unserialize($data_unserialized['sites']);
    }
    
}
?>
