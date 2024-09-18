<?php

namespace PassPush;

use \Defuse\Crypto\KeyProtectedByPassword;
use \Defuse\Crypto\Key;
use \Defuse\Crypto\Crypto;

class PassPushCrypto
{
    public static function MakeKeys($salt, $shortUrlKey = false)
    {
        if($shortUrlKey) {
            $UrlKey = PassPushCrypto::generateEasyUrlString(6, false, 'lud');
        } else {
            $randomBits = bin2hex(random_bytes(32)).uniqid(); //random data with a uniqid - the uniqid makes 100% sure we won't have a duplicate, the random bytes create randomness.
            $UrlKey = hash("sha256", $randomBits); //use a sha256 hash of the madness to generate a sufficiently difficult to guess URL key, without needing to deal with URL encoding
        }        

        $Password = $UrlKey.$salt; // add salt to the url key, this will be used as the password but NOT stored in the DB (Salt is added during subsequent operations)

        $HASH = self::GetStorageHash($UrlKey, $salt);

        $protected_crypto_key = KeyProtectedByPassword::createRandomPasswordProtectedKey($Password); //make a password protected decryption key

        $encoded_crypto_key = $protected_crypto_key->saveToAsciiSafeString(); //make it friendly

        $out = [
            "UrlKey" => $UrlKey,
            "CryptoKey" => $encoded_crypto_key,
            "StorageHash" => $HASH
        ];

        return $out;
    }

    public static function MakeSecret($secret, $protected_key, $urlKey, $salt)
    {
        $protected_key = KeyProtectedByPassword::loadFromAsciiSafeString($protected_key);

        $Password = $urlKey.$salt;

        $unlocked_key = $protected_key->unlockKey($Password);

        $unlocked_key = $unlocked_key->saveToAsciiSafeString();

        $usekey = Key::loadFromAsciiSafeString($unlocked_key);

        $encrypted_secret = Crypto::encrypt($secret, $usekey);

        return $encrypted_secret;
    }

    public static function DecryptSecret($encrypted_secret, $protected_key, $urlKey, $salt)
    {
        $protected_key = KeyProtectedByPassword::loadFromAsciiSafeString($protected_key);

        $Password = $urlKey.$salt;

        $unlocked_key = $protected_key->unlockKey($Password);
        $unlocked_key = $unlocked_key->saveToAsciiSafeString();

        $usekey = Key::loadFromAsciiSafeString($unlocked_key);

        $decrypted_secret = Crypto::decrypt($encrypted_secret, $usekey);

        return $decrypted_secret;
    }

    public static function GetStorageHash($UrlKey, $salt)
    {
        //$HASH = hash('sha512', $Password);
        $HASH = hash_hmac("sha256", $UrlKey, $salt);
        return $HASH;
    }

    private static function generateEasyUrlString($length = 6, $add_dashes = false, $available_sets = 'lud')
    {
        $sets = array();
        if(strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if(strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if(strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if(strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';
        $all = '';
        $password = '';
        foreach($sets as $set)
        {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];
        $password = str_shuffle($password);
        if(!$add_dashes)
            return $password;
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while(strlen($password) > $dash_len)
        {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }

}