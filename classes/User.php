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
    
	private $backend;
    private $login;
    private $name;
    private $sites = array();
    
	/**
     * Constructs the object
     *
     * @param UserBackendInterface $backend
     * @return NULL
     */
    public function __construct($login, $password = null, UserBackendInterface $backend) {
        $this->backend = $backend;
		if(!$this->backend->exist($login, $password)) {
			return false;
		}
		$this->login = $login;
		$this->name = $this->backend->getName($login, $password);
		$this->sites = $this->backend->getSites($login, $password);
	}
    
    public function isValid() {
        if(empty($this->login) || empty($this->sites)) {
            return false;
        }
        return true;
    }
    
    public function getSites() {
        return $this->sites;
    }
    
    public function getLogin() {
        return $this->login;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function serialize() {
        return serialize(array(
            'login' => $this->login,
            'name' => $this->name,
            'sites' => serialize($this->sites)
        ));
    }
    
    public function unserialize($data) {
        $data_unserialized = unserialize($data);
        $this->login = $data_unserialized['login'];
        $this->name = $data_unserialized['name'];
        $this->sites = unserialize($data_unserialized['sites']);
    }
    
}
?>
