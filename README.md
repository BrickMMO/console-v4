# console-v4
Code for the BrickMMO console.

## Prequisites

Before you install the database and console application you will need the following technologies installed:

 - [MAMP](https://www.mamp.info/)
 - [Composer](https://getcomposer.org/)
 - [PHP](https://php.net)

| Note: [Windows Installation](https://www.php.net/manual/en/install.windows.php)

## Database

The database for the console will be used by multiple BrickMMO applications. The database is maintained using a separate repo using Laravel. Before you start the installation of this application clone the [database-v1](https://github.com/BrickMMO/database-v1) repo and setup the database using a standard Blueprint and Laravel process.

## Console Installation

The following instructions will walk you through setting up the console using MAMP.



## Apache

Update your /etc/hosts file to include the following:

```
127.0.0.1 local.account.brickmmo.com 
127.0.0.1 local.console.brickmmo.com
```
Add this to the `httpd.conf` file under `Listen 8888`:

```
Listen 7777
```

Add this to the `httpd.conf` Apache configuration file under VirtualHosts:

```
NameVirtualHost *:7777

<VirtualHost *:7777> 
DocumentRoot "/Users/thomasa/Desktop/BrickMMO/console-v4/public" 
ServerName local.account.brickmmo.com
</VirtualHost>

<VirtualHost *:7777>
DocumentRoot "/Users/thomasa/Desktop/BrickMMO/console-v4/public" 
ServerName local.console.brickmmo.com
</VirtualHost>
```

This is line 614 in my file.

Change the Document Root to the `public` folder in the `console-v4` project.

## ENV File

## Composer

## Database

## PHP Version
