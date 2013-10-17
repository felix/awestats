<?php

/**
 * Copyright (c) 2009 Jon Combe (jawstats.com)
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

header('Content-Type: text/html; charset="utf-8"', true);

// TODO: refactor in a helper or something
for ($i = 0; $i < count($GLOBALS["g_aTranslation"]); $i++) {
    if (strtolower($GLOBALS["g_aTranslation"][$i]["code"]) == CONFIG_DEFAULT_LANGUAGE) {
      $GLOBALS["g_aCurrentTranslation"] = $GLOBALS["g_aTranslation"][$i]["translations"];
    }
}
function Lang($sString) {
  if (isset($GLOBALS["g_aCurrentTranslation"][$sString]) == true) {
    return $GLOBALS["g_aCurrentTranslation"][$sString];
  } else {
    return $sString;
  }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta name="author" content="Mezcalito">
        <meta name="Description" content="Awestats - Connexion">
        <meta name="robots" content="no-cache">

        <title><?php echo CONFIG_DEFAULT_TITLE; ?> - <?php echo Lang('Login')?></title>
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
                        <fieldset><legend><?php echo Lang('Login')?></legend>
                            <div class="control-group">

                                <label class="control-label" for="email"><?php echo Lang('Identifier')?></label>
                                <div class="controls">
                                    <input type="text" name="email" value="" id="var_email"  />            </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="password"><?php echo Lang('Password')?></label>
                                <div class="controls">

                                    <input type="password" name="password" value=""  />         </div>
                            </div>
                        </fieldset>

                        <div class="form-actions">
                            <input type="submit" class="btn btn-primary" value="<?php echo Lang('Login')?>" />
                        </div>

                    </form>

                </div><!-- /.span9 -->
            </div><!-- #page -->
        </div><!-- #page-container -->
    </body>
</html>
