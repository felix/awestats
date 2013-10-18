Installation
============

1. Clone the repository into your document root directory.

2. Create the database structure using SQL file: `documentation/create.sql`.

3. Copy the config file template and fill your params:

    cp config.dist.php config.php

4. Insert new users and websites into database like this:

    INSERT INTO `users` (`login` , `name` , `password`) VALUES ('user@example.com', 'User Example', MD5( 'a good password' ));
    INSERT INTO `websites` (`url` , `user_login`) VALUES ('www.example.com', 'user@example.com');
    INSERT INTO `websites` (`url` , `user_login`) VALUES ('www.example2.com', 'user@example.com');

Or directly using your Phpmyadmin interface.

That's all folks!
