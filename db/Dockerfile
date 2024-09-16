FROM mysql:8.0.28

RUN { \
        echo '[mysqld]'; \
        echo 'character-set-server=utf8mb4'; \
        echo 'collation-server=utf8mb4_general_ci'; \
        echo 'bind-address=0.0.0.0'; \
        echo '[client]'; \
        echo 'default-character-set=utf8mb4'; \
    } > /etc/mysql/conf.d/charset.cnf

RUN { \
        echo '[client]'; \
        echo 'user = laravel'; \
        echo 'password = secret'; \
        echo 'host = %'; \
    } > /root/.mylogin.cnf && \
    chmod 600 /root/.mylogin.cnf

