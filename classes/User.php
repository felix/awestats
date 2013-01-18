<?php

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
