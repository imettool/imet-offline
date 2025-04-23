FROM node:22-alpine

# Update
RUN apk update
RUN npm install -g npm

RUN mkdir /.npm

# Use host user (to fix file permission). Required on Linux
ARG UID
RUN chown -R ${UID} /.npm
USER ${UID}

WORKDIR /var/www/html
