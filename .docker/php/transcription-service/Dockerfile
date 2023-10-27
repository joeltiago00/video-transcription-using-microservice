#Base Image
FROM php:8.2.0-apache AS APP_SERVER

ENV TZ=America/Sao_Paulo

#Set workdir
WORKDIR /var/www/html/

#Copy specific env files to the destination
COPY .ci/transcription-service/php.ini $PHP_INI_DIR/php.ini
COPY .ci/transcription-service/xdebug.ini $PHP_INI_DIR/conf.d/

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Installing OS dependencies
RUN   apt-get update -y && \
      apt-get upgrade -y && \
      apt-get install -yq --no-install-recommends wget libyaml-dev libzip-dev libpng-dev unzip libssl-dev pkg-config git nano libcurl4-openssl-dev openssh-client npm

RUN a2enmod rewrite
RUN pecl install yaml-2.1.0 zip xdebug && \
    docker-php-ext-install gd pdo pdo_mysql && \
    docker-php-ext-enable gd yaml zip pdo pdo_mysql xdebug

# INSTALL COMPOSER
RUN cd /tmp/ && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# PHPUNIT
RUN cd /tmp/ && wget https://phar.phpunit.de/phpunit.phar && chmod +x phpunit.phar && mv phpunit.phar /usr/local/bin/phpunit

###########################################################################
# Mapping host user
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

EXPOSE 9055
