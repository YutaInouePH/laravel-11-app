FROM nginx:1.24.0-alpine as production

RUN apk --no-cache add tzdata && \
    cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

COPY ./conf/nginx.conf /etc/nginx/nginx.conf
COPY ./conf/conf.d/default-local.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/

FROM production as local

FROM production as ec2
COPY ./conf/conf.d/default-ec2.conf /etc/nginx/conf.d/default.conf
