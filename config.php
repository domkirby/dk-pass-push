<?php
/**
 * DK PASS PUSH
 *
 * Config File
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

$cfg_DBSERVER = "localhost"; //mysql db server

$cfg_DBNAME = ""; //mysql db name

$cfg_DBUSER = ""; //mysql db user

$cfg_DBPASS = ""; //mysql db password

$cfg_AppName = "DK PassPush"; //app display name


$cfg_appUrl = "https://pass.domkirby.com"; //URL / path with no trailing /

$app_IntroTextLinkCreationPage = "You can use our secure password sharing system to securely exchange passwords or other sensitive information. Enter your secret in the first field, and specify time and view limits in the following fields. The information will be removed from the server after specified time has passed or the link has been viewed the specified number of times. Whichever comes first.";
//Above is the text that will be displayed on the link generation page.

$cfg_RecaptchaPublic = ""; //aka site key

$cfg_RecaptchaSecret = "";

$cfg_Salt = "aAW9DptAV@PkhQ61%AmwY!jv13Cn(O(R(Kr0Hq#(xlv5)pYnrSKy4vu7$2l6RPRXlp95KpbC7cO7GMXY1Q(Q%GIMD$0r(qAn!y)j@w9C9ik&OjbA8w8Sh7MAVZgMjD"; //CHANGE THIS TO YOUR OWN SALT!!! Do not use quotes in your salt.
//NOTE: Changing the salt will make any secrets in the DB impossible to decrypt as the salt is needed in the process (unless of course you put the old salt back).

