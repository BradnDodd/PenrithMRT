FROM php:8.2-apache AS penrithmrt_base
ENV TOOLBOX_TARGET_DIR="/tools"
ENV COMPOSER_HOME=$TOOLBOX_TARGET_DIR/.composer
ENV PATH="$PATH:$TOOLBOX_TARGET_DIR:${COMPOSER_HOME}/vendor/bin:$TOOLBOX_TARGET_DIR/QualityAnalyzer/bin:$TOOLBOX_TARGET_DIR/DesignPatternDetector/bin:$TOOLBOX_TARGET_DIR/EasyCodingStandard/bin"

ARG UNAME=penrithadmin
ARG UID=1000
ARG GID=1000
ARG XDEBUG_ENABLED=true

RUN curl -s https://deb.nodesource.com/setup_16.x | bash \
&& apt-get update -y && apt-get install -y \
    nodejs \
    libonig-dev \
    openssl \
    unzip \
    zip \
&& curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
&& docker-php-ext-install \
    mbstring \
    pdo \
    pdo_mysql \
&& a2enmod rewrite \
&& rm -rf /var/lib/apt/lists/

COPY --chown=$UID:$GID ./.docker/000-default.conf /etc/apache2/sites-enabled/000-default.conf
COPY --chown=$UID:$GID ./.docker/php.ini /usr/local/etc/php/conf.d/php.ini

FROM penrithmrt_base AS penrithmrt

# If we want to run as non root user then create the user and group within container.
# Needed so files created inside container have correct permissions on host system
RUN if [ $UID -gt 0 ] && [ $GID -gt 0 ] ; then \
    groupadd -g $GID $UNAME && \
    useradd -m -u $UID -g $GID $UNAME && \
    usermod -aG www-data $UNAME && \
    usermod -aG root $UNAME; fi

RUN if [ "$XDEBUG_ENABLED" = "true" ] ; then pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && touch /var/log/xdebug.log \
    && chmod 666 /var/log/xdebug.log; fi

USER $UID
WORKDIR /var/www/html
COPY --chown=$UID:$GID ./.docker/entrypoint /usr/local/bin/entrypoint

ENTRYPOINT [ "/usr/local/bin/entrypoint/entrypoint.sh" ]

CMD [ "apache2-foreground" ]

FROM penrithmrt as penrithmrt_tooling
# QA Tools
COPY --chown=$UID:$GID --from=jakzal/phpqa:php8.2-alpine /tools /tools

USER root
RUN pecl install ast pcov && docker-php-ext-enable ast pcov

USER $UID
