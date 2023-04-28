# BisinesPartner - Backend app

---

#### Required installations

- PHP 8.1+
- MySQL 8+
- Node.JS 14+

---

#### Tested on

- macOS 12+
- Linux 5.6+

---

#### Nginx config file:

```nginx
server {
  server_name api-prod.bisines-partner.ru;
  listen 80;

  root /var/www/api/public;

  add_header X-Frame-Options "SAMEORIGIN";
  add_header X-Content-Type-Options "nosniff";
  charset utf-8;
  index index.php;

  location ~ (?<no_slash>.+)/$ {
    return 307 $scheme://$host$no_slash;
  }

  location / {
    try_files $uri $uri/ /index.php?$query_string;
  }

  location = /favicon.ico {
    access_log off;
    log_not_found off;
  }
  location = /robots.txt {
    access_log off;
    log_not_found off;
  }

  error_page 404 /index.php;

  location ~ \.php$ {
    fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
    fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    include fastcgi_params;
  }
}
```
