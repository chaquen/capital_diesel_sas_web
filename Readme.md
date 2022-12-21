# Web site Capital Diesel


# Before start

Create a file .env from .env.example and fill out the information

## Default User wordpress

    user : soporte.capitaldieselsas

    pass : w)wuhGXb*XD^PFnJhgZr254y

    mail : soporte.capitaldieselsas@gmail.com


# How connect and access to phpmyadmin

Type on your browser the URL with port setup in your  .env  file, then type the user and password from your .env file, you don't need to type the server (i.e)

    USERDB=usercapital
    PASSDB=examplepass

## List of utils command 

Start containers

    docker-compose up -d 

Stop containers

    docker-compose down 

Look for states of containers

     docker stats -a

Login Mysql

    mysql -utype_your_user_here -ptype_your_password_here



## Commons errors

"El enlace que has seguido ha caducado" : [Solución] (https://wpdirecto.com/como-solucionar-el-error-el-enlace-que-has-seguido-ha-caducado-en-wordpress/)

Add to .htaccess 

    php_value upload_max_filesize 128M
    php_value post_max_size 128M
    php_value max_execution_time 300
    php_value max_input_time 300


"Warning: POST Content-Length of 5549528 bytes exceeds the limit of 2097152 bytes in Unknown on line 0" [Solución](https://stackoverflow.com/questions/11719495/php-warning-post-content-length-of-8978294-bytes-exceeds-the-limit-of-8388608-b)

Add new variables in enviroment file
    MEMORY_LIMIT=1G
    UPLOAD_LIMIT=1G

Add new enviroment in yaml file, in service phpmyadmin

    ...
    environment:
      ...
      MEMORY_LIMIT: ${MEMORY_LIMIT}
      UPLOAD_LIMIT: ${UPLOAD_LIMIT}
      ...
    ...