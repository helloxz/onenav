FROM alpine:3.24

WORKDIR /root
#复制启动文件
COPY *.sh /root/
# 复制zdir配置文件
COPY *.conf /root/
RUN sh install.sh
# 复制php.ini
COPY ./php.ini /etc/php83/
VOLUME /data/wwwroot/default/data
EXPOSE 80
CMD ["/usr/sbin/run.sh"]