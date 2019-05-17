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
session_start();
$correctCsrf = $_SESSION['csrf'];
require ("config.php");
require("vendor/autoload.php");
require("PassPush/PassPushCrypto.php");
require("PassPush/Database.php");
use PassPush\PassPushCrypto;
$dbActions = new \PassPush\Database();

//make friendly variables
$urlKey = $_POST['urlkey'];
$csrf = $_POST['csrf'];
//$verify=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$cfg_RecaptchaSecret}&response={$recaptcha}");
$recaptcha_verified = json_decode($verify);
header("Content-type: application/json");

//check csrf
if($correctCsrf != $csrf) {
    $out = [
        "result" => false,
        "reason" => 'CSRF VIOLATION'
    ];
    exit(json_encode($out));
} else {
    $secret = $dbActions->GetCred($urlKey, $cfg_Salt);
    $secretKey = $secret['pushKey'];
    $secretValue = $secret['pushPaylod'];
    $rawSecret = PassPushCrypto::DecryptSecret($secretValue, $secretKey, $urlKey, $cfg_Salt);

    $out = [
        "result" => true,
        "value" => $rawSecret
    ];
    exit(json_encode($out));
}
