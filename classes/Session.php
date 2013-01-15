<?php

use spriebsch\session\AbstractSession;

class Session extends AbstractSession
{
    public function setUser(User $user)
    {
        $this->set('user', $user);
    }
    
    public function hasUser()
    {
        return $this->has('user');
    }
}

?>
