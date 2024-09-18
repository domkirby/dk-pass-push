<?php
/**
 * DATABASE INSTALLER FILE
 *
 * RUN THIS FILE ONCE AND THEN DELETE.
 *
 * IF YOU DONT DELETE IT, THAT'S ON YOU.
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

require("PassPush/Database.php");

$create = "
CREATE TABLE `Pushes` (
  `pushId` varchar(255) NOT NULL,
  `pushKey` text NOT NULL,
  `pushPaylod` text NOT NULL,
  `MaxViews` int(3) NOT NULL,
  `CurrentViews` int(3) NOT NULL DEFAULT '0',
  `ExpTime` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$alter = "
ALTER TABLE `Pushes`
  ADD PRIMARY KEY (`pushId`);";

try {
  $db = new PassPush\Database();
  if($db->connection->connect_errno) {
    die("<strong>Error: </strong>Could not connect to MySQL. Is the config.php file filled out? Error Detail: " . $db->connection->connect_error);
  }
} catch(\Exception $e) {
  $m = $e->getMessage();
  die("Error Connecting to DB: $m <br />Is the config file copmlete?");
}

try {
    $stmt = $db->connection->prepare($create);
    $stmt->execute();
    $stmt->close();
} catch (\mysqli_sql_exception $e) {
    die($e->getMessage());
}
unset($stmt);

try {
    $stmt = $db->connection->prepare($alter);
    $stmt->execute();
    $stmt->close();
} catch (\mysqli_sql_exception $e) {
    die($e->getMessage());
}

echo "Done - delete this file or the script will not function.";