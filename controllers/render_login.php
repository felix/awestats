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

        <title>Awestats - Connexion</title>

        <link href="/themes/default/style.css" rel="stylesheet" type="text/css" />	
    </head>

    <body>
        <div id="main">
            <div class="container">
                <div id="content">
                    <form action="/index.php" method="post" accept-charset="utf-8">
                        <fieldset><legend>Connexion</legend>
                                <label class="control-label" for="email">E-mail</label>
                                <input type="text" name="email" value="" id="var_email"  />
                                <label class="control-label" for="password">Mot de passe</label>
                                <input type="password" name="password" value=""  />        
                        </fieldset>
                        <input type="submit" class="btn btn-primary" value="Connexion" />
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>