<?php
var_dump($_SERVER['REQUEST_METHOD']);









/*
nginx


//location / {
//                try_files $uri $uri/ /index.php?$args;
//        }




array(34) {
  "USER"=> "www"
  "HOME"=> "/home/www"
  "HTTP_ACCEPT_LANGUAGE"=> "zh-CN,zh;q=0.8"
  "HTTP_ACCEPT_ENCODING"=> "gzip, deflate"
  "HTTP_ACCEPT"=> "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,\*\/*;q=0.8"
  "HTTP_USER_AGENT"=> "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.104 Safari/537.36"
  "HTTP_UPGRADE_INSECURE_REQUESTS"=>1
  "HTTP_CONNECTION"=> keep-alive"
  "HTTP_HOST"=> "test.route.com"
  "REDIRECT_STATUS"=> "200"
  "PATH_INFO"=> ""
  "SERVER_NAME"=> "test.route.com"
  "SERVER_PORT"=> "80"
  "SERVER_ADDR"=> "192.168.33.110"
  "REMOTE_PORT"=> "55368"
  "REMOTE_ADDR"=>"192.168.33.1"
  "SERVER_SOFTWARE"=> "nginx/1.10.0"
  "GATEWAY_INTERFACE"=> "CGI/1.1"
  "REQUEST_SCHEME"=> "http"
  "SERVER_PROTOCOL"=> "HTTP/1.1"
  "DOCUMENT_ROOT"=> "/home/wwwroot/test.route.com"
  "DOCUMENT_URI"=> "/index.php"
  "REQUEST_URI"=> "/test/admin/fun?id=12&dsa=12"
  "SCRIPT_NAME"=> "/index.php"
  "CONTENT_LENGTH"=>  ""
  "CONTENT_TYPE"=>  ""
  "REQUEST_METHOD"=> "GET"
  "QUERY_STRING"=> ""
  "SCRIPT_FILENAME"=> "/home/wwwroot/test.route.com/index.php"
  "FCGI_ROLE"=> "RESPONDER"
  "PHP_SELF"=> ""
  "REQUEST_TIME_FLOAT"=> float(1517807960.8679)
  "REQUEST_TIME"=> int(1517807960)
}
 */



/*
apache

//RewriteEngine on
//RewriteCond %{REQUEST_FILENAME} !-d
//RewriteCond %{REQUEST_FILENAME} !-f
//RewriteRule ^(.*)$ /index.php


array(50) {
  "REDIRECT_MIBDIRS"=> string(24) "D:/xampp/php/extras/mibs"
  "REDIRECT_MYSQL_HOME"=> string(16) "\xampp\mysql\bin"
  "REDIRECT_OPENSSL_CONF"=> string(31) "D:/xampp/apache/bin/openssl.cnf"
  "REDIRECT_PHP_PEAR_SYSCONF_DIR"=> string(10) "\xampp\php"
  "REDIRECT_PHPRC"=> string(10) "\xampp\php"
  "REDIRECT_TMP"=> string(10) "\xampp\tmp"
  "REDIRECT_STATUS"=> string(3) "200"
  "MIBDIRS"=> string(24) "D:/xampp/php/extras/mibs"
  "MYSQL_HOME"=> string(16) "\xampp\mysql\bin"
  "OPENSSL_CONF"=> string(31) "D:/xampp/apache/bin/openssl.cnf"
  "PHP_PEAR_SYSCONF_DIR"=> string(10) "\xampp\php"
  "PHPRC"=> string(10) "\xampp\php"
  "TMP"=> string(10) "\xampp\tmp"
  "HTTP_ACCEPT"=> string(37) "text/html, application/xhtml+xml, *\/*"
  "HTTP_ACCEPT_LANGUAGE"=> string(5) "en-US"
  "HTTP_USER_AGENT"=> string(68) "Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko"
  "HTTP_ACCEPT_ENCODING"=> string(13) "gzip, deflate"
  "HTTP_HOST"=> string(17) "test.route.com:81"
  "HTTP_DNT"=> string(1) "1"
  "HTTP_CONNECTION"=> string(10) "Keep-Alive"
  "HTTP_COOKIE"=> string(68) "bf_session=ab23e28a67ea958624e1bc83f0615bdec7a9f35d; Profiler=closed"
  "PATH"=> string(1092) "C:\Program Files (x86)\Common Files\NetSarang;C:\Program Files (x86)\NVIDIA Corporation\PhysX\Common;C:\Program Files (x86)\Intel\iCLS Client\;C:\Program Files\Intel\iCLS Client\;C:\Windows\system32;C:\Windows;C:\Windows\System32\Wbem;C:\Windows\System32\WindowsPowerShell\v1.0\;C:\Program Files (x86)\Intel\OpenCL SDK\3.0\bin\x86;C:\Program Files (x86)\Intel\OpenCL SDK\3.0\bin\x64;C:\Program Files\Intel\Intel(R) Management Engine Components\DAL;C:\Program Files\Intel\Intel(R) Management Engine Components\IPT;C:\Program Files (x86)\Intel\Intel(R) Management Engine Components\DAL;C:\Program Files (x86)\Intel\Intel(R) Management Engine Components\IPT;C:\Program Files (x86)\Yuguo;D:\wamp\bin\php\php5.5.12;C:\ProgramData\ComposerSetup\bin;D:\wamp\www\style\nodejs\;C:\Program Files\TortoiseGit\bin;C:\Program Files\TortoiseSVN\bin;C:\HashiCorp\Vagrant\bin;d:\Program Files (x86)\SSH Communications Security\SSH Secure Shell;C:\Users\HASEE\AppData\Roaming\Composer\vendor\bin;C:\Users\HASEE\AppData\Roaming\npm;C:\Program Files\Oracle\VirtualBox\VirtualBox.exe;D:\sublime\ctags58\ctags.exe"
  "SystemRoot"=> string(10) "C:\Windows"
  "COMSPEC"=> string(27) "C:\Windows\system32\cmd.exe"
  "PATHEXT"=> string(53) ".COM;.EXE;.BAT;.CMD;.VBS;.VBE;.JS;.JSE;.WSF;.WSH;.MSC"
  "WINDIR"=> string(10) "C:\Windows"
  "SERVER_SIGNATURE"=> string(100) "Apache/2.4.23 (Win32) OpenSSL/1.0.2h PHP/5.6.28 Server at test.route.com Port 81"
  "SERVER_SOFTWARE"=> string(47) "Apache/2.4.23 (Win32) OpenSSL/1.0.2h PHP/5.6.28"
  "SERVER_NAME"=> string(14) "test.route.com"
  "SERVER_ADDR"=> string(9) "127.0.0.1"
  "SERVER_PORT"=> string(2) "81"
  "REMOTE_ADDR"=> string(9) "127.0.0.1"
  "DOCUMENT_ROOT"=> string(22) "D:/www/test.route.com/"
  "REQUEST_SCHEME"=> string(4) "http"
  "CONTEXT_PREFIX"=> string(0) ""
  "CONTEXT_DOCUMENT_ROOT"=> string(22) "D:/www/test.route.com/"
  "SERVER_ADMIN"=> string(20) "postmaster@localhost"
  "SCRIPT_FILENAME"=> string(31) "D:/www/test.route.com/index.php"
  "REMOTE_PORT"=> string(5) "53033"
  "REDIRECT_URL"=> string(15) "/test/admin/fun"
  "REDIRECT_QUERY_STRING"=> string(12) "id=12&dsa=12"
  "GATEWAY_INTERFACE"=> string(7) "CGI/1.1"
  "SERVER_PROTOCOL"=> string(8) "HTTP/1.1"
  "REQUEST_METHOD"=> string(3) "GET"
  "QUERY_STRING"=> string(12) "id=12&dsa=12"
  "REQUEST_URI"=> string(28) "/test/admin/fun?id=12&dsa=12"
  "SCRIPT_NAME"=> string(10) "/index.php"
  "PHP_SELF"=> string(10) "/index.php"
  "REQUEST_TIME_FLOAT"=> float(1517809646.046)
  "REQUEST_TIME"=> int(1517809646)
}

 */