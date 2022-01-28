FROM mysql/mysql-server:5.7.28

ENV TZ='Asia/Tokyo'

COPY my.cnf /etc/mysql/conf.d/my.cnf
COPY entrypoint /docker-entrypoint-initdb.d
