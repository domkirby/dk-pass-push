<?php
/**
 * Created by PhpStorm.
 * User: DominicKirby
 * Date: 10/8/2017
 * Time: 20:41
 */

namespace PassPuah;
use \PassPuah\PassPushCrypto;

class Database
{

    public $connection;

    public function __construct()
    {
        require __DIR__ . "/../config.php";
        //build mysqli connection

        $this->connection = new \mysqli($cfg_DBSERVER, $cfg_DBUSER, $cfg_DBPASS, $cfg_DBNAME);
    }

    public function StoreCred($StorageHash, $pushKey, $pushPayload, $MaxViews, $ExpTime, $CurrentViews = 0)
    {
        $stmt = $this->connection->prepare("INSERT INTO `Pushes`(`pushId`, `pushKey`, `pushPaylod`, `MaxViews`, `CurrentViews`, `ExpTime`) VALUES (?,?,?,?,?,?)");

        $stmt->bind_param("sssiii", $StorageHash, $pushKey, $pushPayload, $MaxViews, $CurrentViews, $ExpTime);

        $stmt->execute();

        $stmt->close();

        return true;
    }

    public function DeleteCred($StorageHash, $urlkey = false, $salt = null)
    {
        if($urlkey){
            $StorageHash = PassPushCrypto::GetStorageHash($StorageHash, $salt);
        }

        $stmt = $this->connection->prepare("DELETE FROM `Pushes` WHERE `pushId` = ?");

        $stmt->bind_param("s", $StorageHash);

        $stmt->execute();

        $stmt->close();

        return true;
    }
    public function GetCred($UrlKey, $salt)
    {
        $StorageHash = PassPushCrypto::GetStorageHash($UrlKey, $salt);

        $stmt = $this->connection->prepare("SELECT `pushId`, `pushKey`, `pushPaylod`, `MaxViews`, `CurrentViews`, `ExpTime` FROM `Pushes` WHERE `pushId` = ?");

        $stmt->bind_param("s", $StorageHash);

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();


        if($result->num_rows) {
            $assoc = $result->fetch_assoc();
            $MaxViews = $assoc["MaxViews"];
            $CurrentViews = $assoc["CurrentViews"];
            $CurrentViews = $CurrentViews + 1;
            if($CurrentViews == $MaxViews || $CurrentViews > $MaxViews) {
                $this->DeleteCred($StorageHash);
            } else {
                $this->UpdateNumViews($StorageHash, $CurrentViews);
            }
            return $assoc;
        } else {
            return false;
        }


    }
    public function UpdateNumViews($StorageHash, $Views)
    {
        $Views = $Views++;
        $stmt = $this->connection->prepare("UPDATE `Pushes` SET `CurrentViews`= ? WHERE `pushId` = ?");
        $stmt->bind_param("is", $Views, $StorageHash);
        $stmt->execute();
        $stmt->close();
    }
    public function CheckSecretExists($UrlKey,$salt)
    {
        $StorageHash = PassPushCrypto::GetStorageHash($UrlKey, $salt);

        $stmt = $this->connection->prepare("SELECT `pushId` FROM `Pushes` WHERE `pushId` = ?");

        $stmt->bind_param("s", $StorageHash);

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();

        if($result->num_rows) {
            return true;
        } else {
            return false;
        }
    }

    public function CronDelete()
    {
        $time = time();
        try {
            $stmt = $this->connection->prepare("DELETE FROM `Pushes` WHERE `ExpTime` < ?");
            $stmt->bind_param('i', $time);
            $stmt->execute();
            $stmt->close();
        } catch (\mysqli_sql_exception $e) {
            die($e->getMessage());
        }
    }


    public function InstallDb()
    {
        $stmt = $this->connection->prepare("CREATE TABLE `Pushes` ( `pushId` VARCHAR(255) NOT NULL , `pushKey` TEXT NOT NULL , `pushPaylod` TEXT NOT NULL , `MaxViews` INT(3) NOT NULL , `CurrentViews` INT(3) NOT NULL DEFAULT '0' , `ExpTime` INT(50) NOT NULL , PRIMARY KEY (`pushId`)) ENGINE = InnoDB;");
        $stmt->execute();
        $stmt->close();
    }
}