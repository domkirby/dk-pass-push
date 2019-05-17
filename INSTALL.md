# DK Pass Push Install Instructions

## Requirements:

- PHP 7.1+
- MySQL

Most shared hosts should meet this requirement.

## Install Steps

We recommend installing this on its own subdomain (like pass.domkirby.com). **You must use HTTPS.**
Please consult with your server administrator or web host to meet these needs.

1. Create a MySQL database and user with full access to the database – write these down
2. Extract the ZIP file included with your download, and edit the config.php file - each variable has comments with instructions.
3. Once your config file has been updated, save it and upload the package contents to the web
    root of your subdomain. Then navigate to https://yourserver/install.php. If the file just
    says “Done” and has no errors, you should be all set. **_DELETE THE INSTALL.PHP FILE DELETE THE_**
    **_INSTALL.PHP FILE DELETE THE INSTALL.PHP FILE DELETE THE INSTALL.PHP FILE!!!!!_**


4. You now need to setup a cron job. If you are unsure how to do this, please contact your hosting
    provider. The cron should run every minute (for maximum security) and should call out a url:
    https://pass.yourserver/DeleteByTime-cron.php
5. That’s it.

## Customizing

You can customize the app easily by swapping out the logo.png and favicon.ico files in the “gui/custom” folder. If you
want to get fancier, you can do so at your own risk. This is an open source piece of software. Do what you
want with it.