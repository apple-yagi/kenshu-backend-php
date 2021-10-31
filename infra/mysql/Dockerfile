FROM mysql:5.7

ENV TZ='Asia/Tokyo'

COPY my.cnf /etc/mysql/conf.d/my.cnf
COPY entrypoint /docker-entrypoint-initdb.d