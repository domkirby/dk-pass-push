# DK PassPush

This is a free pushing program similar to https://pwpush.com/. It generates a secure, ephemeral link that you can send to another person to retrieve the data. The data is deleted after a certain number of views, or a certain amount of time. Whichever occurs first.

This application can be whitelabeled to your brand - very handy for MSPs or other providers who commonly need to exchange secure data.

## Installing

Installation instructions are available in the included PDF file


## Security

This app uses the [defuse/php-encryption](https://github.com/defuse/php-encryption) library to encrypt data. Each secret has it's own key, which is protected by a password. The password is the url key (the query string submitted to find the record) plus a salt that is defined in the configuration file. This makes for a very secure password to protect a very strong key. This "password" is stored in a hashed (sha256) format. We chose SHA256 so that the hashes are consistent (password_hash uses unique salts). We cannot use unique salts as we need to be able to search for the record based on the query string in the URL.

## Reporting Bugs or Security Issues

If you find an issue with this code, feel free to fork it and fix it, or submit an issue.
