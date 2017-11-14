## Start working

To start this app, perform the following steps:

 - Install external libraries using **composer** and **bower**

```bash
    composer install
    bower install
```

  - Change DB configuration in `etc/app-conf.php`

 - Migrate data to your database

```bash
    php deploy/setup.php -fd
```


 - Then start a server

```bash
    php -S 0.0.0.0:8000 -t public/
```

- Open 'http://localhost:8000' on your web browser

********************************************************************************

