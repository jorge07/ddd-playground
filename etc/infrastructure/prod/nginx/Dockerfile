FROM nginx:1.11-alpine

COPY ddd.conf /etc/nginx/conf.d/default.conf

COPY app/web /app/web

RUN rm -rf /app/web/app_dev.php
