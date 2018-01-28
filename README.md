 ### Files是一个文件浏览列表，带有搜索（按左上角的Files就可以搜索），部分文件预览功能
 ### Demo：http://files.xcssa.com
 ### 版本：0.0.1
 ### 安装：
 #####环境：nginx+php
Linux下nginx配置事例：
（我这里的环境是nginx1.12+php7.2，其它的可自行修改）
```
server
{
    listen 80;
    server_name files.xcssa.com;
    client_max_body_size 1024m;
    root   Files的目录路径/html;
	
    location ^~ />/ {
        rewrite ^/>([\s|\S]*)$ /$1 break;
    }

    location ~ /([\s|\S]*)/$ {
        rewrite ^/([\s|\S]*)/$ / last;
    }

    location = / {
        #try_files $uri =404;
        fastcgi_pass  unix:/tmp/php-cgi-71.sock;
        fastcgi_index index.php;
        include fastcgi.conf;
        #include pathinfo.conf;
    }

    location / {
        root   Files的目录路径/html/Files;
        rewrite ^/([\s|\S]*)$ /$1 break;
    }
}
```
Windows下nginx配置事例：
（我这里的环境是nginx1.12+php7.2，其它的可自行修改）
```
server {
        listen       80;
        server_name  localhost;
        client_max_body_size 1024m;
        root   Files的目录路径/html;

        location ^~ />/ {
            rewrite ^/>([\s|\S]*)$ /$1 break;
        }

        location ~ /([\s|\S]*)/$ {
            rewrite ^/([\s|\S]*)/$ / last;
        }

        location = / {
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            include        fastcgi_params;
        }

        location / {
            root   Files的目录路径/html/Files;
            rewrite ^/([\s|\S]*)$ /$1 break;
        }
}
```
###现在到了配置Files配置文件的时候了
> 修改 Files的目录路径/Config/ConstantDefinition.php 里的 FILES_PATH 全局变量的值为：Files的目录路径/html/Files

###预览

![](http://files.xcssa.com/1.png)
![](http://files.xcssa.com/2.png)
![](http://files.xcssa.com/3.png)
![](http://files.xcssa.com/4.png)
![](http://files.xcssa.com/5.png)