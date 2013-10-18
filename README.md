AWEstats
========

Description
-----------

AWEstats is a fork of JAWstats, a fancy frontend to AWstats.
It use RaphaelJS a vectoriel javascript library for building graphics and
Bootstrap for its web UI. It now have user session and multisite
support.

Installation
------------

Follow instructions in `documentation/INSTALL.md`.

Todo
----

1. Sanitize and restructure this "from scratch" PHP code using a lightweight
   framework like Silex or something like this.
2. Rewrite the code to a standard per-page-loading navigation. Current
   full ajax navigation implementation is buggy and difficult to maintain.
3. Implement an administration panel to manage users and websites.

Backends implementation
-----------------------

For the moment, only a MySQL backend is implemented for session and user data
storage but code is ready to support other backends. So don't hesitate to
implement other backends to suit your needs.

For examples:

* Take a look on `classes/UserBackendInterface.php`, `classes/UserBackendMysql.php` for user data storage backend.
* Take a look on `classes/session/PHPMysqlSessionBackend.php` for session backend.

Authors and contributions history
---------------------------------

* 2013 - Thomas Pierson (through Mezcalito Co.): Integration of Bootstrap for the
  web UI and implement users sessions support with a first Mysql backend.
  Refactoring code structure a bit.
* 2010 - Felix Hanley: Fork of JAWstats and integration of RaphaelJS for
  graphics instead of flash.
* 2009 - Jon Combe: Initial implementation of JAWstats.

Links
-----

* [AWEstats Github Mezcalito repository](https://github.com/mezcalito/awestats)
* [AWEstats Github Felix Hanley repository](https://github.com/felix/awestats)
* [JAWstats](http://www.jawstats.com)

License
-------

This software is a free software released under the MIT License.

Licenses for third party components:

* Bootstrap: APACHE 2.0 License
* PHP Spriebsch\Session classes: BSD License
* RaphaelJS: MIT License
* Jquery: MIT License

