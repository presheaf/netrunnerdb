FROM httpd:2.4
RUN apt-get update
ENV TZ=Europe/Oslo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN DEBIAN_FRONTEND=noninteractive apt-get install -y git-core curl php7.4 php7.4-intl php7.4-mysql php7.4-curl php7.4-zip php7.4-xml

RUN apt-get install -y default-mysql-server

WORKDIR /netrunnerdb
COPY . .

# i don't think the latter is needed
COPY parameters.yml /netrunnerdb/app/config/
# COPY parameters.yml /netrunnerdb/

COPY 000-default.conf /etc/apache2/sites-available/
COPY apache2.conf /etc/apache2/

RUN mkdir -p /netrunnerdb/var/cache/prod/

# does this chown enough?
RUN chown -R www-data /netrunnerdb/var



EXPOSE 80

# but this has to happen after the nrdb_db is up... 
CMD ["apache2ctl", "-D", "FOREGROUND"]

