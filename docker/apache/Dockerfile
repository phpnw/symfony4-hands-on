FROM centos:latest
MAINTAINER The CentOS Project <cloud-ops@centos.org>
LABEL Vendor="CentOS" \
      License=GPLv2 \
      Version=2.4.6-40

RUN yum -y --setopt=tsflags=nodocs update \
    && yum -y --setopt=tsflags=nodocs install httpd mod_ssl \
    && yum clean all

EXPOSE 80
EXPOSE 443

# Simple startup script to avoid some issues observed with container restart
ADD ./docker/apache/run-httpd.sh /run-httpd.sh
RUN chmod -v +x /run-httpd.sh

RUN echo "IncludeOptional /etc/httpd/sites.d/*.conf" >> /etc/httpd/conf/httpd.conf

RUN mkdir -p /var/www/sites/phpnw.dev

CMD ["/run-httpd.sh"]
