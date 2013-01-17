<?php

// core config parameters
define('CONFIG_DEFAULT_LANGUAGE', 'en-gb');
define('CONFIG_DEFAULT_VIEW', 'thismonth.all');
define('CONFIG_CHANGE_SITE', true);
define('CONFIG_UPDATE_SITE', true);

// db settings
define('BASE_URL', 'awestats.example');
define('DB_USER', 'example');
define('DB_PASSWORD', 'xxxxx');
define('DB_NAME', 'awestats');

// Ensure reporting is setup correctly
define("MYSQL_CONN_ERROR", "Unable to connect to database.");
mysqli_report(MYSQLI_REPORT_STRICT);

?>
