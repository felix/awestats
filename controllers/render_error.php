<?php
header('Content-Type: text/html; charset="utf-8"', true);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta name="author" content="Mezcalito">
        <meta name="Description" content="Awestats - Connexion">
        <meta name="robots" content="no-cache">

        <title>Awestats - Error</title>

        <link href="/themes/default/style.css" rel="stylesheet" type="text/css" />	
    </head>

    <body>
        <div id="main">
            <div class="container">
                <div id="content">
                   <?php echo $error_message;?>
                </div>
            </div>
        </div>
    </body>
</html>