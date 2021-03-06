<?php
/**
 * Created by PhpStorm.
 * User: DominicKirby
 * Date: 10/9/2017
 * Time: 16:40
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
require "config.php";
require("PassPush/Database.php");
require("PassPush/PassPushCrypto.php");
$db = new \PassPush\Database();
session_start();

$UrlKey = $_GET['pid'];

$db->DeleteCred($UrlKey, true, $cfg_Salt);

header("Location: ".$cfg_appUrl);