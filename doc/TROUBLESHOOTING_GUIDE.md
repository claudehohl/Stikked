Stikked troubleshooting guide
-----------------------------

### Apache

#### 404 Not Found after creating a Paste

Rewrite rules must be enabled in httpd.conf.

### Nginx

#### 502 Bad Gateway

PHP FastCGI must be running. Here's my /etc/init.d/php-fgci config:

```bash
#!/bin/bash

FASTCGI_USER=www-data
FASTCGI_GROUP=www-data
ADDRESS=127.0.0.1
PORT=9000
PIDFILE=/var/run/php-fastcgi.pid
CHILDREN=6
PHP5=/usr/bin/php5-cgi

/usr/bin/spawn-fcgi -a $ADDRESS -p $PORT -P $PIDFILE -C $CHILDREN -u $FASTCGI_USER -g $FASTCGI_GROUP -f $PHP5
```

You can adapt that to your system.

### Lighttpd

### Cherokee

Still have a problem?
---------------------

Report an issue at GitHub, and we will add your problem to this guide.
