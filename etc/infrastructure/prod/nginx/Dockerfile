FROM nginx:1.11-alpine

RUN apk --update add curl \
    && rm -rf /var/cache/apk/*

COPY nginx/ddd.conf /etc/nginx/conf.d/default.conf
COPY app/web /app/web

RUN rm -rf /app/web/app_dev.php

HEALTHCHECK --interval=5m --timeout=3s \
  CMD curl -f http://localhost/monitor/ping || exit 1
