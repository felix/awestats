<?php
/**
 * Mezcalito
 *
 * @package    session
 * @author     Mezcalito
 */

namespace spriebsch\session;

/**
 * Uses built-in PHP session functionality with session data in a Mysql database
 */
class PHPMysqlSessionBackend implements SessionBackendInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $lifetime;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $domain;

    /**
     * @var bool
     */
    protected $isSecure;
    
    protected $mysqli;

    public function __construct($user, $password, $database_name) {
        
        try {
            $this->mysqli = new \mysqli("localhost", $user, $password, $database_name);
        } catch (\mysqli_sql_exception $e) {
           throw $e;
        }
    }
    
    /**
     * Starts the session
     *
     * @param string $name     Session name
     * @param string $domain   Session cookie domain
     * @param string $path     Session cookie path
     * @param int    $lifetime Session cookie lifetime
     * @param bool   $isSecure Whether session is HTTPS or HTTP
     * @return NULL
     */
    public function startSession($name, $lifetime, $path, $domain, $isSecure = FALSE)
    {
        $this->name = $name;
        $this->lifetime = $lifetime;
        $this->path = $path;
        $this->domain = $domain;
        $this->isSecure = $isSecure;

        session_set_cookie_params($lifetime, $path, $domain, $isSecure, TRUE);
        session_name($name);
        session_start();
    }
    
    public function getSessionId()
    {
        return session_id();
    }
    
    public function regenerateSessionId()
    {
        session_regenerate_id(TRUE);
    }

    public function read()
    {
        $session_id = $this->mysqli->real_escape_string($this->getSessionId());
        $res = $this->mysqli->query("SELECT `data` FROM `sessions` WHERE `session_id` = '{$session_id}'");
        $row = $res->fetch_assoc();
        $data = unserialize($row['data']);
        
        if(is_array($data)) {
            foreach ($data as &$value) {
                $value = @unserialize($value);
            }
        }
        
        return $data;
    }

    public function write(array $data)
    {
        foreach ($data as &$value) {
            if(is_object($value)) {
                $value = serialize($value);
            }
        }
        $session_id = $this->mysqli->real_escape_string($this->getSessionId());
        $data_serialized = $this->mysqli->real_escape_string(serialize($data));
        $data_old = $this->read();
        if(!empty($data_old)) {
            return $this->mysqli->query("UPDATE `sessions` SET `data`='{$data_serialized}'  WHERE `session_id` = '{$session_id}'");
        } else {
           return $this->mysqli->query("INSERT INTO `sessions` (`session_id`, `data`) VALUES ('{$session_id}','{$data_serialized}')");
        }
    }

    public function destroy()
    {
        setcookie($this->name, '', 1, $this->path, $this->domain, $this->isSecure, TRUE);
        session_destroy();
        unset($_SESSION);
    }
}
