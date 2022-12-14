# Web site Capital Diesel


# Before start

Create a file .env from .env.example and fill out the information

## Default User wordpress

    user : soporte.capitaldieselsas

    pass : MfFjCoM3w#B2^QXQRw

    mail : soporte.capitaldieselsas@gmail.com


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
