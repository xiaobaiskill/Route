APACHE
==============
注意
----
* AllowOverride All      #请在httpd_vhost.conf. 文件中将该配置开启,才可以在外部使用.htaccess文件

语法
-----
* [flag] 标签学习
	* R 重定向标签 重定向到一个新的链接
	* C 链接下一条规则。 与下一条规则成为一个主体,如果这一条不匹配,则下一条不进入
	* L 结尾规则,立即停止重写操作,并不再应用其他重写规则. 不再匹配下面的规则
	* NE 不对url的特殊字符进行hexcode转码
	* NC 对匹配的URL 不区分大小写
	* G 请求的网页已失效 apache服务器会返回401
	* SQA 用于在URL 中截取查询字符串


* [RewriteBase] URL-path
	* 设置目录及重写的基准URL


* [RewriteCond]  条件判断
	* RewriteCond TestString CondPattern [flag]
	* %{HTTP_HOST}    获取server中的HTTP_HOST
	* %1~9 仅匹配上一个RewriteCond 里面 1~9 括号里面的内容
	* condPattern 可以判断是否是文件或者目录
	* [flag]
	* OR 或操作   不添加则是并操作


* [RewriteMap]
	* RewriteMap MapName MapType:MapSource
	* MapName  命名可RewriteRule 调用
	* MapType map文件的类型 有txt 、rnd
	* MapSource map文件路径
	* 需要在httpd_vhost.conf 文件中配置 ，在 rewrite 里面使用
	* 在<Directory> 外面配置
	* 例如：
		* RewriteMap pages txt:D:/www/www.test1.com/Route/pages.txt
		``
		  page test
		  page1 test1
		``
		* RewriteMap servers rnd:D:/www/www.test1.com/Route/rnd.txt
		``
		  URL1 S1|S2|S3
		  URL2 S4|S5
		``  

	* 格式
	` ${MapName:LookupKey|DefaultValue} 没有LookupKey 则 默认DefaultValue `


操作
----
*  RewriteEngine On    #开启rewrite规则重写


* [flag]
```
	# RewriteRule ^(.*)\.htm$ /$1.php    [R=302]    //临时重定向 建议少用 能不用则不用

	#RewriteRule ^(.*)\.htm /$1.html [C]
	#RewriteRule ^(.*)\.html /$1.php	

	#RewriteRule ^(.*) test/first.php?url=$1 [L]
	#RewriteRule ^(.*) test/second.php?url=$1

	#RewriteRule ^(.*)\.htm /index.html#$1 [R,NE]
	 
	#RewriteRule ^tmp\/(.*)\.htm /test/$1\.php [NC]   #对于^tmp\/(.*)\.htm  不区分大小写

	#RewriteRule ^jmz/.*$ - [G]

	#RewriteRule ^first/(.*)$ /test/first.php?url=$1 [QSA,R]       
	##first/index.php?req=jmz    ===>   /test/first.php?url=index.php&req=jmz 
```




* [RewriteBase]
```
	#RewriteBase /test/
	#RewriteRule ^test\.htm test.php  
	##test.htm  ===> /test/test.php
	#RewriteRule ^(.*)\.htm $1.php?url=jmz
	##first.htm ===> /test/first.php?url=jmz
```





* [RewriteCond] 
```
	#RewriteBase /test/

	#RewriteCond $1 "test"                      			
	##这里的$1是Rewriterule 里面的，意思就是如果想要匹配RewriteRule就需（.*）满足 等于 test
	#RewriteRule ^(.*)\.htm $1.php [R]
	# test.htm ===>  /test/test.php


	#RewriteCond %{HTTP_HOST} "127.0.0.1"
	## 如果 HTTP_HOST 是127.0.0.1  则执行
	#RewriteRule ^(.*) http://test.route.com:81/$1 [R]
	# 127.0.0.1:81/test/test.php ===> http://test.route.com:81/test/test.php


	#RewriteCond %{HTTP_HOST} "(.*).0.0.(.*)"
	#RewriteCond %1 "127"
	#RewriteCond %2 "2"   					
	## 这里的%2 应该匹配的是上一个RewriteCond里面的第二个（）里面的内容 ，因为没有所以无法匹配到 ，去除的话使用
	## 127.0.0.* 可以匹配到
	#RewriteRule ^(.*) http://test.route.com:81/$1 [R]


	#RewriteCond %{DOCUMENT_ROOT}/$1 -d [OR]
	#RewriteCond %{DOCUMENT_ROOT}/$1 -f
	#RewriteRule ^(.*).htm $1.php [R]
	## test.htm  ===> /test/test.php   满足条件 D:/.../Route/test 是目录的条件
```







* [RewriteMap]
```
	#RewriteRule ^(.*)\/(.*)\.htm /${pages:$1}/$2.php [R]
	##/page/test.htm ===> /test/test.php
	##/page1/test.htm ===> /test1/test.php

	#RewriteRule ^(.*)\/(.*)\.htm /${server:$1|root}/${server:$2}.php [R]
	#test/URL1.htm  ===> /root/(S1|S2|S3).php
	#URL1/URL1.htm  ===>/(S1|S2|S3)/(S1|S2|S3).php
```



