# Using in local for debug with xdebug
FROM oberd/php-8.0-apache
ARG targetenv

# Expose apache.
EXPOSE 80

# copy apache config files
COPY ./configurations/local-default.conf /etc/apache2/sites-enabled/000-default.conf

RUN echo "ServerName localhost" >> /etc/apache2/sites-enabled/000-default.conf

# copy apache config files
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]

# enable Headers module in Apache required for CORS support
RUN a2enmod headers
# enable rewrite module for Apache
RUN a2enmod rewrite
# enable environment module for Apache
RUN a2enmod env

RUN apt-get update -y
RUN apt-get install -y vim
RUN apachectl restart

# copy all of the source files into container
WORKDIR /var/www/html/
COPY ./ /var/www/html/
