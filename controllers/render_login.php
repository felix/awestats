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

        <title><?php echo CONFIG_DEFAULT_TITLE; ?> - Connexion</title>
        <link href="/assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div id="page-container" class="container">

            <div id="header" class="navbar navbar-fixed-top navbar-inverse">
                <div class="navbar-inner">
                    <div class="container">
                        <a class="brand" href="/index.php"><?php echo CONFIG_DEFAULT_TITLE; ?></a>
                        <ul class="nav pull-right">
                        </ul>


                    </div>
                </div>
            </div>
            <div id="page" class="row-fluid">

                <div class="span12">


                    <form action="/index.php" method="post" accept-charset="utf-8" class="form-horizontal auto-focus">
                        <fieldset><legend>Connexion</legend>
                            <div class="control-group">

                                <label class="control-label" for="email">E-mail</label>
                                <div class="controls">
                                    <input type="text" name="email" value="" id="var_email"  />            </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="password">Mot de passe</label>
                                <div class="controls">

                                    <input type="password" name="password" value=""  />         </div>
                            </div>
                        </fieldset>

                        <div class="form-actions">
                            <input type="submit" class="btn btn-primary" value="Connexion" />
                        </div>

                    </form>

                </div><!-- /.span9 -->
            </div><!-- #page -->
        </div><!-- #page-container -->
    </body>
</html>