FROM php:8.1.0-apache

WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y \
    unixodbc \
    unixodbc-dev \
    freetds-dev \
    libzip-dev \
    gnupg \
    libcurl4-openssl-dev \
    curl \
    libicu-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    sudo \
    zip \
    unzip \
    libpq-dev \
    tzdata \
    git \
    git-crypt \
    wkhtmltopdf \
    musl \
    qtbase5-dev \
    fontconfig \
    libpng-dev \
    libjpeg-dev

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite headers

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN docker-php-source extract \
    && docker-php-ext-install pdo_dblib \
    && pecl install \
        sqlsrv \
        pdo_sqlsrv \
    && docker-php-ext-enable --ini-name 30-sqlsrv.ini sqlsrv \
    && docker-php-ext-enable --ini-name 35-pdo_sqlsrv.ini pdo_sqlsrv

RUN docker-php-ext-install mbstring exif pcntl sockets

RUN echo "America/Sao_Paulo" | tee /etc/timezone && \
    ln -fs /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime

RUN docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-enable intl

RUN docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-enable zip

RUN docker-php-ext-configure soap \
    && docker-php-ext-install soap \
    && docker-php-ext-enable soap

RUN docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable gd

RUN docker-php-ext-configure bcmath \
    && docker-php-ext-install bcmath \
    && docker-php-ext-enable bcmath

RUN docker-php-ext-configure pdo_odbc --with-pdo-odbc=unixodbc,/usr \
    && docker-php-ext-install pdo_odbc \
    && docker-php-ext-enable pdo_odbc

RUN docker-php-ext-configure curl \
    && docker-php-ext-install curl \
    && docker-php-ext-enable curl

RUN apt-get install -y libc-client-dev libkrb5-dev && rm -r /var/lib/apt/lists/*
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN echo 'zend_extension=xdebug' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.mode=develop,debug,coverage' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.client_host=host.docker.internal' >> /usr/local/etc/php/php.ini
RUN echo 'session.save_path = "/tmp"' >> /usr/local/etc/php/php.ini

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
RUN curl https://packages.microsoft.com/config/ubuntu/20.04/prod.list > /etc/apt/sources.list.d/mssql-release.list
RUN apt-get update && ACCEPT_EULA=Y apt-get install -y msodbcsql17

RUN docker-php-source delete

RUN chown www-data:root /var/www/html

RUN git config --system --add safe.directory '*'

RUN apt-get update && \
    apt-get install -y vim nano

###########################################################################
# Alterando configurações php.ini
###########################################################################

RUN echo "max_execution_time = 600" >> "$PHP_INI_DIR/conf.d/docker-php-execution-time"
RUN echo 'memory_limit = -1' >> "$PHP_INI_DIR/conf.d/docker-php-memlimit.ini"
RUN echo 'pcre.backtrack_limit=10000000' >> "$PHP_INI_DIR/php.ini"
RUN sed -i 's/upload_max_filesize = .*/upload_max_filesize = 100M/' "$PHP_INI_DIR/php.ini"
RUN sed -i 's/post_max_size = .*/post_max_size = 100M/' "$PHP_INI_DIR/php.ini"

###########################################################################
# Mapeando usuário host
###########################################################################

ENV PUID 1000
ENV PGID 1000
ENV NEW_USER user

RUN groupadd -g ${PGID} ${NEW_USER} && \
    useradd -l -u ${PUID} -g ${NEW_USER} -m ${NEW_USER} && \
    usermod -p "*" ${NEW_USER} -s /bin/bash

###########################################################################
# Oh My ZSH!
###########################################################################

USER root

ARG SHELL_OH_MY_ZSH=true
RUN if [ ${SHELL_OH_MY_ZSH} = true ]; then \
    apt install -y zsh \
;fi

ARG SHELL_OH_MY_ZSH_AUTOSUGESTIONS=true
ARG SHELL_OH_MY_ZSH_ALIASES=true

USER user
RUN if [ ${SHELL_OH_MY_ZSH} = true ]; then \
    sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh) --keep-zshrc" && \
    sed -i -r 's/^plugins=\(.*?\)$/plugins=(laravel5)/' /home/user/.zshrc && \
    echo '\n\
bindkey "^[OB" down-line-or-search\n\
bindkey "^[OC" forward-char\n\
bindkey "^[OD" backward-char\n\
bindkey "^[OF" end-of-line\n\
bindkey "^[OH" beginning-of-line\n\
bindkey "^[[1~" beginning-of-line\n\
bindkey "^[[3~" delete-char\n\
bindkey "^[[4~" end-of-line\n\
bindkey "^[[5~" up-line-or-history\n\
bindkey "^[[6~" down-line-or-history\n\
bindkey "^?" backward-delete-char\n' >> /home/user/.zshrc && \
  if [ ${SHELL_OH_MY_ZSH_AUTOSUGESTIONS} = true ]; then \
    sh -c "git clone https://github.com/zsh-users/zsh-autosuggestions /home/user/.oh-my-zsh/custom/plugins/zsh-autosuggestions" && \
    sed -i 's~plugins=(~plugins=(zsh-autosuggestions ~g' /home/user/.zshrc && \
    sed -i '1iZSH_AUTOSUGGEST_BUFFER_MAX_SIZE=20' /home/user/.zshrc && \
    sed -i '1iZSH_AUTOSUGGEST_STRATEGY=(history completion)' /home/user/.zshrc && \
    sed -i '1iZSH_AUTOSUGGEST_USE_ASYNC=1' /home/user/.zshrc && \
    sed -i '1iTERM=xterm-256color' /home/user/.zshrc \
  ;fi && \
  if [ ${SHELL_OH_MY_ZSH_ALIASES} = true ]; then \
    echo "" >> /home/user/.zshrc && \
    echo "# Load Custom Aliases" >> /home/user/.zshrc && \
    echo "source /home/user/aliases.sh" >> /home/user/.zshrc && \
    echo "" >> /home/user/.zshrc \
  ;fi \
;fi

USER root

###########################################################################
# ZSH User Aliases
###########################################################################

USER root

COPY ./.docker/aliases.sh /root/aliases.sh
COPY ./.docker/aliases.sh /home/user/aliases.sh

RUN if [ ${SHELL_OH_MY_ZSH} = true ]; then \
    sed -i 's/\r//' /root/aliases.sh && \
    sed -i 's/\r//' /home/user/aliases.sh && \
    chown user:user /home/user/aliases.sh && \
    echo "" >> ~/.zshrc && \
    echo "# Load Custom Aliases" >> ~/.zshrc && \
    echo "source ~/aliases.sh" >> ~/.zshrc && \
	  echo "" >> ~/.zshrc \
;fi

USER user

RUN if [ ${SHELL_OH_MY_ZSH} = true ]; then \
    echo "" >> ~/.zshrc && \
    echo "# Load Custom Aliases" >> ~/.zshrc && \
    echo "source ~/aliases.sh" >> ~/.zshrc && \
	  echo "" >> ~/.zshrc \
;fi
