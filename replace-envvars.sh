sed -i "s/\['site_name'\].*/['site_name'] = '$SITENAME';/" /var/www/html/application/config/stikked.php
sed -i "s/\['base_url'\].*/['base_url'] = '$BASEURL';/" /var/www/html/application/config/stikked.php
sed -i "s/\['db_hostname'\].*/['db_hostname'] = '$DBHOST';/" /var/www/html/application/config/stikked.php
sed -i "s/\['db_database'\].*/['db_database'] = '$DBNAME';/" /var/www/html/application/config/stikked.php
sed -i "s/\['db_username'\].*/['db_username'] = '$DBUSER';/" /var/www/html/application/config/stikked.php
sed -i "s/\['db_password'\].*/['db_password'] = '$DBPASS';/" /var/www/html/application/config/stikked.php
sed -i "s/\['enable_captcha'\].*/['enable_captcha'] = '$CAPTHCA';/" /var/www/html/application/config/stikked.php
