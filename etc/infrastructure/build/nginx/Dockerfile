FROM nginx:1.11-alpine

COPY etc/infrastructure/build/nginx/ddd.conf /etc/nginx/conf.d/default.conf
COPY web /app/web

RUN mkdir -p /app/var/logs/nginx \
    && touch /app/var/logs/nginx/access.log && ln -sf /dev/stdout /app/var/logs/nginx/access.log \
    && touch /app/var/logs/nginx/error.log  && ln -sf /dev/stdout /app/var/logs/nginx/error.log
