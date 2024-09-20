# console-v4
Code for the BrickMMO console.

## Prequisites

Before you install the database and console application you will need the following technologies installed:

 - [MAMP](https://www.mamp.info/)
 - [Composer](https://getcomposer.org/)
 - [PHP](https://php.net)

> [!NOTE]  
> When installing PHP use the [Windows Installer](https://www.php.net/manual/en/install.windows.php) for a PC or [Brew](https://formulae.brew.sh/formula/php) for a Mac.

## Database

The database for the console will be used by multiple BrickMMO applications. The database is maintained using a separate repo using Laravel. Before you start the installation of this application clone the [database-v1](https://github.com/BrickMMO/database-v1) repo and setup the database using a standard Blueprint and Laravel process.

## Console Installation

The following instructions will walk you through setting up the console using MAMP.

### Console Code

Clone this repo to your project folder:

```
git clone https://github.com/BrickMMO/console-v4.git
```

### Hosts

We will install this application using MAMP in a method that does not prevent you from using MAMP for other projects. This applcation will require multiple domains and will not run properly by simply using `http://localhost:8888`. We are going to setup two testing domains `local.account.brickmmo.com` and `local.console.brickmmo.com`. Open up your `hosts` files and add the following lines:

```
127.0.0.1 local.account.brickmmo.com 
127.0.0.1 local.console.brickmmo.com
```

> [!NOTE]
> On a mac, your `hosts` file is located at `/etc/hosts`. You can edit it using the Terminal by running the `sudo nano /etc/hosts` command. On a PC, the `hosts` file is located at `C:\Windows\System32\Drivers\etc\hosts`. Open Notepad as administrator, open the `hosts` file and make the same changes.

If you open a browser and test either of these domain names you should now see the defalt MAMP web page.



### Apache

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

```
DB_HOST=localhost
DB_DATABASE=brickmmo_console
DB_USERNAME=root
DB_PASSWORD=root

ENV_ACCOUNT_DOMAIN=http://local.account.brickmmo.com:7777
ENV_CONSOLE_DOMAIN=http://local.account.brickmmo.com:7777
ENV_SALT=1234567890

ENV_DEBUG=true
ENV_REDIRECT=true
```

## Composer

## Database

## PHP Version
