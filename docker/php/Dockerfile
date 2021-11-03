FROM yiisoftware/yii2-php:7.4-apache

RUN apt-get update && apt-get install -y git wget zlib1g-dev xlsx2csv unixodbc unixodbc-dev freetds-dev freetds-bin tdsodbc libxml2-dev && docker-php-ext-install zip pdo pdo_mysql soap
RUN ln -s /usr/lib/x86_64-linux-gnu/libsybdb.a /usr/lib/ && docker-php-ext-install pdo_dblib

RUN usermod -u 1000 www-data