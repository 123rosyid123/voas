FROM php:8.3.0-fpm-alpine

RUN apk add --no-cache nginx wget

RUN mkdir -p /run/nginx

COPY docker/nginx.conf /etc/nginx/nginx.conf

RUN mkdir -p /app
COPY . /app
COPY ./src /app


# # #
# Install build dependencies
# # #
ENV build_deps \
    autoconf \
    zlib-dev

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apk upgrade --update-cache --available && apk update && \
    apk add --virtual .build-dependencies $build_deps

RUN apk add --no-cache \
        $PHPIZE_DEPS
# # #
# Install persistent dependencies
# # #
ENV persistent_deps \
    g++ \
    gcc \
    linux-headers \
    make \
    zlib

RUN apk add --update --virtual .persistent-dependencies $persistent_deps

# # #
# Install grpc extension
# # #
RUN pecl install grpc && \
    docker-php-ext-enable grpc

# # #
# remove build deps
# # #
RUN apk del -f .build-dependencies

RUN sh -c "wget http://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer"
RUN cd /app && \
    /usr/local/bin/composer install --no-dev

RUN chown -R www-data: /app

CMD sh /app/docker/startup.sh
