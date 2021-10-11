ARG PHP_IMAGE_NAME
FROM ${PHP_IMAGE_NAME}

# Install Node.Js
RUN apk add --no-cache nodejs npm

WORKDIR /var/www/html

ENTRYPOINT ["npm"]
