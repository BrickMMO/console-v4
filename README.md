# console-v4
Code for the BrickMMO console.

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
