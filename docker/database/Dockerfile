FROM postgres:alpine

LABEL author="vladmun"
LABEL description="Tredo test database image"
LABEL version="1.0"

COPY ./docker/database/database.sql /docker-entrypoint-initdb.d/

EXPOSE 5432