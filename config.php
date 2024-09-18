<?php
/**
 * DK PASS PUSH
 *
 * Config File
 *
 * Copyright 2024 - Dominic Kirby (domkirby.com)

* Licensed under the Apache License, Version 2.0 (the "License");
* you may not use this file except in compliance with the License.
* You may obtain a copy of the License at

* http://www.apache.org/licenses/LICENSE-2.0

* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
* See the License for the specific language governing permissions and
* limitations under the License.
 */

$cfg_DBSERVER = "localhost"; //mysql db server

$cfg_DBNAME = "your database name"; //mysql db name

$cfg_DBUSER = "your database user"; //mysql db user

$cfg_DBPASS = "your database password"; //mysql db password

$cfg_AppName = "DK Pass Push"; //app display name


$cfg_appUrl = "https://pass.yourdomain.com"; //URL / path with no trailing /

$cfg_Salt = "jUzyeeV%0LCo)F4iUuAvQDsJ3Aifwtr&@IXyAJzrO6PDyr1nJ4%E11Pz8&bI"; //CHANGE THIS TO YOUR OWN SALT!!! Do not use quotes or dollar signs in your salt. We recommend 40 or more chars.
//NOTE: Changing the salt will make any secrets in the DB impossible to decrypt as the salt is needed in the process (unless of course you put the old salt back).

/*
Friendly URL setting:
-If TRUE, then your links will look like https://rooturl/Juh73h
-If FALSE, then your links will look like https://rooturl/?pid=Juh73h

If you opt to use a friendly URL, then you will need to add the contents of htaccess-example.txt to your .htaccess file or do an equivalent rewrite in IIS if you're using Windows.
*/
$cfg_UseFriendlyURLs = false;

/*
Short URL Setting:
This setting dictates whether or not to use short URL.
- A short URL is something like https://rooturl/Juh73h (set to true to enable this)
- A long URL is something like https://rooturl/3d1357abf0585571445d391805fa33bbc65d86ee22232dd2122f137aa9939326 (a SHA256 hash of randomness)

The long URL is stronger, as the URL is used as a basis for protecting a unique encryption key. It's also much harder to guess.
However, a short URL, while being less secure, is easier to type. Make your decision as convenience vs security.
*/
$cfg_UseShortURLs = false;

/*
Customize your introduction text that is displayed as instructions for creating a link. Enter html inbetween <<<HTML and HTML;
*/
$app_IntroTextLinkCreationPage = <<<HTML

<b>Welcome</b> to our secure password and secret sharing service. To create a new secret, follow these steps:
<ul>
    <li>Enter your "secret" in the large field below.</li>
    <li>Select a time limit and max number of views.</li>
    <li>Click "Get Secure Link"</li>
    <li>A secure link will be displayed. <b>You must copy this link and send it via email or other means to your intended recipient</b>
</ul>
Your secret will be <i>permanently</i> deleted when the time limit has elapsed or the max views have been met, whichever occurs first.<br/>
Your secret is encrypted using a unique key, and can <strong>only</strong> be decrypted by a person in possession of the secure link. We cannot decrypt your secret if we are not provided with the link.

HTML;
//Above is the text that will be displayed on the link generation page.


$app_LinkCreationSuccessText = "Your Secret has been stored securely. Please <strong>copy the link below</strong> and send it to your intended recipient."; //enter text that will be displayed to the user once they have generated a link successfully 
//For the success text, avoid using <div> and <p> and the like. You can use <strong> <i> etc.


//Specify text presented to people who have visited a valid password link. Avoid using <div> and <p> and the like. You can use <strong> <i> etc. Escape quotes with \ - for example \"quoted text\"
$app_SecretRetrieveInstructions = "You have received a secret from someone using the <a href='https://domkirby.com' target='_blank'>DomKirby</a> secret sharing service. Click the \"Retrieve Secret\" button below to get your secret. NOTE: Once you click the button, a view will be counted towards the maximum views of this secret.";
