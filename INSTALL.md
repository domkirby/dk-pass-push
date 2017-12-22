# DK Pass Push Install Instructions

## Requirements:

- PHP 5.6+ – 7.0+ Recommended
- MySQL
- Recaptcha keypair (google.com/recaptcha)

Most shared hosts should meet this requirement.

## Install Steps

We recommend installing this on its own subdomain (like pass.domkirby.com). **You must use HTTPS.**
Please consult with your server administrator or web host to meet these needs.

1. Create a MySQL database and user with full access to the database – write these down
2. Extract the ZIP file included with your download, and edit the config.php file:
    a. $cfg_DBSERVER = "localhost"; //mysql db server
       i. The name of your database server (is probably local host)
    b. $cfg_DBNAME = ""; //mysql db name
       i. The name of your new database
    c. $cfg_DBUSER = ""; //mysql db user
       i. The username to access the database
    d. $cfg_DBPASS = ""; //mysql db password
       i. The password to access the database
    e. $cfg_AppName = "DK PassPush"; //app display name
       i. The title that will be displayed to users
    f. $cfg_appUrl
       i. The base url of your app, such as https://pass.domkirby.com
    g. $app_IntroTextLinkCreationPage
       i. This defined the text displayed on the page when users are to create a secret
    h. $cfg_RecaptchaPublic = ""; //aka site key
       i. Your Recaptcha site key provided by Google
    i. $cfg_RecaptchaSecret = "";
       i. Your Recaptcha secret key provided by Google
    j. $cfg_Salt **THIS ONE IS IMPORTANT**
       i. This should be set to any strong and long string of random characters. It is an
          important part of the crypto process of this app, so take it seriously. You can get
          a random one made for you at https://domkirby.com/ppsalt.
3. Once your config file has been updated, save it and upload the package contents to the web
    root of your subdomain. Then navigate to https://yourserver/path/install.php. If the file just
    says “Done” and has no errors, you should be all set. **_DELETE THE INSTALL.PHP FILE DELETE THE_**
    **_INSTALL.PHP FILE DELETE THE INSTALL.PHP FILE DELETE THE INSTALL.PHP FILE!!!!!_**


4. You now need to setup a cron job. If you are unsure how to do this, please contact your hosting
    provider. The cron should run every minute (for maximum security) and should call out a url:
    https://yourserver/path-to-dkpasspush/DeleteByTime-cron.php
5. That’s it.

## Customizing

You can customize the app easily by swapping out the logo.png file in the “gui/custom” folder. If you
want to get fancier, you can do so at your own risk. This is open source piece of software. Do what you
want with it.


