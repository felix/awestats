<?php

class User implements Serializable {
    
    private $email;
    private $name;
    private $sites = array();
    
    public function __construct($email = null, $password = null) {
        try {
            $this->mysqli = new mysqli("localhost", DB_USER, DB_PASSWORD, DB_NAME);
            $email = mysqli_escape_string($email);
            $password = mysqli_escape_string($password);
            $res = $this->mysqli->query("SELECT email, name FROM `users` WHERE `email` = '{$email}' AND `password`= '{$password}'");
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
        $row = $res->fetch_row();
        if(!empty($row[0])) {
            $this->email = $row[0]['email'];
            $this->name = $row[0]['name'];
            try {
                $email = mysqli_escape_string($this->email);
                $password = mysqli_escape_string($this->name);
                $res = $this->mysqli->query("SELECT `url` FROM `websites` WHERE `user_email` = '{$email}'");
                $rows = $res->fetch_row();
                foreach ($rows as $row) {
                    $this->sites[] = $row['url'];
                }
            } catch (mysqli_sql_exception $e) {
                throw $e;
            }
        }
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
            'password' => $this->password,
            'sites' => serialize($this->sites)
        ));
    }
    
    public function unserialize($data) {
        $this->data = unserialize($data);
        $this->id = $data['email'];
        $this->name = $data['name'];
        $this->password = $data['password'];
        $this->sites = unserialize($data['sites']);
    }
    
}
?>
