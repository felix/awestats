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
