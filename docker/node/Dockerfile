FROM imet_offline_php_image

USER root

# Install Node.js + npm
RUN apk add --no-cache nodejs npm

# Install some requirements (for some npm packages compilation)
RUN apk add --no-cache make g++ python3

# Use host user (to fix file permission). Required on Linux
ARG UID
RUN mkdir /.npm
RUN chown -R ${UID} /.npm
USER ${UID}

WORKDIR /var/www/html
