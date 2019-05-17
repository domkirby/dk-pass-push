<?php
/**
 * Created by PhpStorm.
 * User: DominicKirby
 * Date: 10/9/2017
 * Time: 00:25
 * Licensed under the Apache License, Version 2.0 (the "License");
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
require("vendor/autoload.php");
require("PassPush/PassPushCrypto.php");
require("PassPush/Database.php");
use PassPush\PassPushCrypto;
$dbActions = new \PassPush\Database();

//make friendly variables
$secret = $_POST['secret'];
$views = $_POST['views'];
$time = (int)$_POST['time'];
$units = $_POST['units'];

//make time
$now = time();
$expwhen = 0;
switch($units) {
    case "minutes":
        $integer = $time * 60;
        $expwhen = $now + $integer;
        break;

    case "hours":
        $integer = $time * 60 * 60;
        $expwhen = $now + $integer;
        break;

    case "days":
        $integer = $time * 60 * 60 * 24;
        $expwhen = $now + $integer;
        break;
}

//get a new id
$newId = PassPushCrypto::MakeKeys($cfg_Salt);
//make hash variable to be used in a moment
$StorageHash = $newId["StorageHash"];
//make a url variable that will be used in a moment
$UrlKey = $newId["UrlKey"];
if($cfg_UseFriendlyURLs) {
    $theLink = $cfg_appUrl . "/$UrlKey";
} else {
    $theLink = $cfg_appUrl . "/?pid=$UrlKey";
}

//make a crypto key var
$ProtectedKey = $newId["CryptoKey"];
//encrypt the secret
$secret = PassPushCrypto::MakeSecret($secret, $ProtectedKey, $UrlKey, $cfg_Salt);

$dbActions->StoreCred($StorageHash, $ProtectedKey, $secret, $views, $expwhen, 0);

header("Content-type: application/json");

$out = [
    "result" => true,
    "link" => $theLink,
];
exit(json_encode($out));