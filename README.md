
*Apache Require: mod_status*

<IfModule mod_status.c>
	ExtendedStatus On
	<Location /server-status>
	    SetHandler server-status
	    Order deny,allow
	    Deny from all
	    Allow from 127.0.0.1
	</Location>
</IfModule>


1) Write in domains.conf domains sites that you want monitoring

2) insert in file: api.ipinfodb.com.key
   your api.ipinfodb.com API KEY

*TODOS
	using: http://dev.maxmind.com/geoip/legacy/geolite/
