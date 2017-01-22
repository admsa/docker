FROM php:5.6.24-fpm

ARG INSTALL_GD=false
RUN if [ ${INSTALL_GD} = true ]; then \
	apt-get update && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng12-dev && \
	docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && \
	docker-php-ext-install gd \
;fi

ARG INSTALL_PDO=false
RUN if [ ${INSTALL_PDO} = true ]; then \
	docker-php-ext-install pdo_mysql \
;fi

RUN usermod -u 1000 www-data
#WORKDIR /var/www/html
#CMD ["php-fpm"]
#EXPOSE 9000

