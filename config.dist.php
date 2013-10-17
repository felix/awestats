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

// stats data config
define('CONFIG_STATS_PATH', '/var/lib/awstats/');

// core config parameters
define('CONFIG_DEFAULT_TITLE', 'Example Organisation');
define('CONFIG_DEFAULT_LANGUAGE', 'en-gb');
define('CONFIG_DEFAULT_VIEW', 'thismonth.all');
define('CONFIG_CHANGE_SITE', true);
define('CONFIG_UPDATE_SITE', true);
define('CONFIG_SESSION_LIFETIME', 600);

// db settings
define('BASE_URL', 'awestats.example');
define('DB_USER', 'example');
define('DB_PASSWORD', 'xxxxx');
define('DB_NAME', 'awestats');

// Ensure reporting is setup correctly
define("MYSQL_CONN_ERROR", "Unable to connect to database.");
mysqli_report(MYSQLI_REPORT_STRICT);

?>
