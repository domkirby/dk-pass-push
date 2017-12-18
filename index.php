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

require("config.php");
$retrieve = isset($_GET['pid']);

if($retrieve) {
    $page = "load_secret.php";
    require("PassPush/PassPushCrypto.php");
    require("PassPush/Database.php");
    $db = new \PassPuah\Database();
    $SecretExists = $db->CheckSecretExists($_GET['pid'], $cfg_Salt);
} else {
    $page = "new_secret.php";
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Dominic Kirby / domkirby.com">
    <meta name="application-name" content="<?php echo $cfg_AppName;?>"/>
    <title><?php echo $cfg_AppName;?></title>
    <!--JS-->
    <script src="<?php echo $cfg_appUrl; ?>/gui/js/jquery-3.2.1.min.js">//jquery</script>
    <script src="<?php echo $cfg_appUrl; ?>/gui/js/popper.js">//popper</script>
    <script src="<?php echo $cfg_appUrl; ?>/gui/js/bootstrap.min.js">//bootstrap</script>
    <script src="<?php echo $cfg_appUrl; ?>/gui/js/clipboard.min.js">//clipboard</script>
    <script src="<?php echo $cfg_appUrl; ?>/gui/js/tether.min.js">//tether</script>
    <link rel="icon" href="<?php echo $cfg_appUrl; ?>/gui/custom/favicon.ico">
    <?php if($retrieve) { ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <?php }; ?>
    <!--CSS STYLES-->
    <link rel="stylesheet" href="<?php echo $cfg_appUrl; ?>/gui/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $cfg_appUrl; ?>/gui/fa/css/font-awesome.min.css">
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
