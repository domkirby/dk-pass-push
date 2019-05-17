<?php
/**
 * DK PASS PUSH
 *
 * App Entry Point
 *
 * Copyright 2017 - Dominic Kirby (domkirby.com)

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
 */
if(file_exists("install.php")) die("Delete install.php");
 header("x-content-type-options: nosniff");
 header("x-frame-options: SAMEORIGIN");
 header("x-xss-protection: 1; mode=block");
header('X-Powered-By: https://github.com/domkirby/dk-pass-push');
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

require("config.php");
$retrieve = isset($_GET['pid']);
session_start();
if($retrieve) {
    $page = "load_secret.php";
    require("PassPush/PassPushCrypto.php");
    require("PassPush/Database.php");
    $db = new \PassPush\Database();
    $SecretExists = $db->CheckSecretExists($_GET['pid'], $cfg_Salt);
} else {
    $page = "new_secret.php";
}
?>

<!doctype html>
<html lang="en">
<head>
    <!--
________   ____  __.
\______ \ |    |/ _|
 |    |  \|      <  
 |    `   \    |  \ 
/_______  /____|__ \
        \/        \/
Powered by DKPassPush https://github.com/domkirby/dk-pass-push
    -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Dominic Kirby / domkirby.com">
    <meta name="application-name" content="<?php echo $cfg_AppName;?>"/>
    <title><?php echo $cfg_AppName;?></title>

    <link rel="icon" href="<?php echo $cfg_appUrl; ?>/gui/custom/favicon.ico">
        <!--JS-->
    <script src="<?php echo $cfg_appUrl; ?>/gui/js/jquery-3.2.1.min.js">//jquery</script>
    <script src="<?php echo $cfg_appUrl; ?>/gui/js/popper.js">//popper</script>
    <script src="<?php echo $cfg_appUrl; ?>/gui/js/bootstrap.min.js">//bootstrap</script>
    <script src="<?php echo $cfg_appUrl; ?>/gui/js/clipboard.min.js">//clipboard</script>
    <script src="<?php echo $cfg_appUrl; ?>/gui/js/tether.min.js">//tether</script>
    <script src="//cdn.quilljs.com/1.3.4/quill.min.js">//quill</script>
    <!--CSS STYLES-->
    <link rel="stylesheet" href="<?php echo $cfg_appUrl; ?>/gui/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $cfg_appUrl; ?>/gui/fa/css/font-awesome.min.css">
    <link href="//cdn.quilljs.com/1.3.4/quill.snow.css" rel="stylesheet">
    <style type="text/css">
        body {
            padding-top: 30px;
            padding-bottom: 30px;
        }

        .input-group-btn:last-child > .form-control {
            margin-left: -1px;
            width: auto;
        }

        .input-group {
            margin-bottom: 13px;
        }
    </style>
</head>
<body>
<nav>
    <div class="container">
        <ul class="nav navbar-nav">
        </ul>
    </div>
</nav>
<!--Start Dynamic Content-->
<?php require($page);?>
<!--End Dynamic Content-->



</body>
</html>
