<?php

use spriebsch\session\AbstractSession;

class Session extends AbstractSession
{
    public function setUser(User $user) {
        $this->set('user', $user);
    }
    
    /**
     * Return the object User
     * @return User
     */
    public function getUser() {
        return $this->get('user');
    }
    
    /**
     * return true if a user is recorded in the session
     * @return boolean
     */
    public function hasUser() {
        return $this->has('user');
    }
}

?>
