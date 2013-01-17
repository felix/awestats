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
        $user = $this->get('user');
        if($user instanceof User) {
            return $user;
        } else {
            throw new Exception('Internal error: invalid session User object');
        }
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
