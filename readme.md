![Logo](images/system/index.png)

# COMP0178 Database Fundamentals Group 22 Assignment

Starter code from [Moodle page](https://moodle.ucl.ac.uk/course/view.php?id=30098) with an ER Diagram created in https://app.diagrams.net 

This code uses [PHPMailer](https://github.com/PHPMailer/PHPMailer).

## ER Diagram

To edit the ER diagram, go to `File` > `Open from` > `Device` > Find .drawio file in navigator. Then save to device and push to repo

## Running WAMP with PostgreSQL

1. Install [Wampserver](https://www.wampserver.com/en/) (you need Windows...)
2. Install [PostgreSQL](https://www.enterprisedb.com/downloads/postgres-postgresql-downloads) **version 14.5** (this is *not the latest release*!)
3. Download [phpPgAdmin](https://github.com/phppgadmin/phppgadmin/releases/tag/REL_7-13-0)
4. Extract `phpPgAdmin-7.13.0.zip` in `C:\wamp64\apps`, so the path will be `C:\wamp\apps\phpPgAdmin-7.13.0`. (If you installed Wamp somewhere else, correct the file paths.)
5. Create a file called `phppgadmin.conf` in `C:\wamp64\alias`. And copy-paste the following (Similarly to above, if you installed Wamp somewhere else, correct the file paths):

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
7. Find `$conf['servers'][0]['host'] = '';`, then change to `$conf['servers'][0]['host'] = 'localhost';`
8. Find `$conf['extra_login_security'] = true;`, then change `true` to `false`
9. Start Wampserver.
10. Left click on the Wampserver tray icon. Navigate to PHP > PHP extension. Then enable `pgsql` and `pdo_pgsql` extensions. (You may get an error. I just ignored it)
11. Go to http://localhost/phppgadmin/ and try to login.

Default Login credentials are

+ Username = "postgres"
+ Password = "root"

but it might be different if you chose a different password during PostgreSQL installation.

Edited from https://stackoverflow.com/questions/14621181/integration-of-postgresql-on-wamp

## Setup

1. Go to `C:\wamp64\www`
2. Clone this github repository into a new folder. If you have git bash you can use `cd C:\wamp64\www` and `git clone https://github.com/wenzhaojia2000/auction.git auction`

In the `Build Database` directory, run the following scripts in postgresql in order:

1. `create_database.pgsql`
2. `create_tables.pgsql`
3. `create_admin.pgsql` (**Recommended to change the password in this file to something else!**)
4. `insert_values_to_category.pgsql`
5. `insert_mock_data_users.pgsql`
6. `insert_mock_data_items.pgsql`

Then, create a file named `adminpassword.txt` in the root folder consisting of the password you created in `create_admin.pgsql`. (This file is ignored by `.gitignore`.)

3. Run Wampserver if you haven't already
4. Go to http://localhost/auction/index.php

### How to run a PHP script every minute

1. Open `C:\wamp64\bin\php\php7.4.26\php.ini` (Or the equivalent if you installed WAMP somewhere else/use a different version of PHP)
2. Uncomment `extension=pdo_pgsql` and `extension=pgsql` (around line ~944) by removing the semicolon
3. Open Application Stack Builder and install PgAgent.
4. Open PgAdmin 4 and see if there is a "PgAgent Jobs" section under "PostgreSQL 14". If not, go to Databases > postgres and right click "postgres", select "Query tool". Type "`CREATE EXTENSION pgagent;`" and execute. You may have to restart your computer.
5. Right click "PgAgent Jobs" and click "Create > PgAgent job". Add a suitable name (eg. "Closes auctions").
6. Go to "Steps" and click "Add row" (The plus button on the right). Then "Edit row" (The pencil icon on the left). Add a suitable name (eg. "Runs close auction PHP script"). Then click "Batch" under "Type". Click the "Code" tab. Type in (change if you installed WAMP somewhere else):

```
cd C:\wamp64\www\auction\service
"C:\wamp64\bin\php\php7.4.26\php.exe" -f close_auctions.php
```

7. Go to "Schedule", add row, edit row, add a suitable name (eg. "Every minute"). Click the repeat button. Under "Minutes", select "Select All". Leave all the other fields blank. Save. Now PgAgent should execute `close_auctions.php` every minute.
