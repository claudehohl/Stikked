Stikked troubleshooting guide
-----------------------------

First, be sure to double-check whether you meet the [prerequisites](//github.com/claudehohl/Stikked#prerequisites).

### Apache

#### 404 Not Found after creating a Paste

Rewrite rules must be enabled in httpd.conf.

Enable it by executing the following command:

```a2enmod rewrite```

### Nginx

#### 502 Bad Gateway

PHP FastCGI must be running. Here's my /etc/init.d/php-fcgi config:

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

#### 503 - Service Not Available

PHP FastCGI must be running. See the php-fcgi section under Nginx.

#### Lighttpd + mod_rewrite requires $config['uri_protocol'] = 'QUERY_STRING'

If you're using Lighttpd and mod_rewrite, you need to set $config['uri_protocol'] = 'QUERY_STRING' in htdocs/application/config/config.php

### Cherokee

### PHP

#### The QR file isn't created and the image isn't showed

You need to have the GD extension for PHP installed and enabled so that the QR codes are rendered.

Still have a problem?
---------------------

Report an issue [at GitHub](//github.com/claudehohl/Stikked/issues), and we will add your problem to this guide.
