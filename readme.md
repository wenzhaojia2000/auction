# Auction

Starter code from Moodle page with an ER Diagram created in https://app.diagrams.net 

## ER Diagram

To edit the ER diagram, go to `File` > `Open from` > `Device` > Find .drawio file in navigator. Then save to device and push to repo

## Running WAMP with PostgreSQL

1. Install [Wampserver](https://www.wampserver.com/en/)
2. Install [PostgreSQL](https://www.enterprisedb.com/downloads/postgres-postgresql-downloads) **version 14.5** (this is *not the latest release*!)
3. Download [phpPgAdmin](https://github.com/phppgadmin/phppgadmin/releases/tag/REL_7-13-0)
4. Extract `phpPgAdmin-7.13.0.zip` in `C:\wamp64\apps`, so the path will be `C:\wamp\apps\phpPgAdmin-7.13.0`. (If you installed Wamp somewhere else, correct the file paths.)
5. Create a file called `phppgadmin.conf` in C:\wamp64\alias. And copy-paste the following (Similarly to above, if you installed Wamp somewhere else, correct the file paths):

```
Alias /phppgadmin "C:/wamp64/apps/phpPgAdmin-7.13.0/" 

<Directory "C:/wamp64/apps/phpPgAdmin-7.13.0/">
    Require local
    Options Indexes FollowSymLinks MultiViews
    AllowOverride all
        Order Deny,Allow
  Allow from all
</Directory>
```
6. Open `C:\wamp64\apps\phpPgAdmin-7.13.0\conf\config.inc.php`.
7. find `$conf['servers'][0]['host'] = '';`, then change to `$conf['servers'][0]['host'] = 'localhost';`
8. find `$conf['extra_login_security'] = true;`, then change `true` to `false`
9. Start Wampserver.
10. Left click on the Wampserver tray icon. Navigate to PHP > PHP extension. Then enable `pgsql` and `pdo_pgsql` extensions. (You may get an error. I just ignored it)
11. Go to http://localhost/phppgadmin/ and try to login.

Default Login credentials are

+ Username = "postgres"
+ Password = "root"

but it might be different if you chose a different password during PostgreSQL installation.

Edited from https://stackoverflow.com/questions/14621181/integration-of-postgresql-on-wamp
