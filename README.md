Download bot - Johnny 5 :).
---------------------------------------------
You may change configuration parameters in app/config/config.php
You should set write permissions to "download" folder, you can change it in config $paramList['download_folder'] = '';
  Now it also uses default config parameters for RabbitMQ, but you can change it in config.php
  
Run "composer install" to download dependencies(You may download composer from https://getcomposer.org/download/).
  Composer should have permissions for write in "vendor" folder;
       
Set execute permissions for main bot script. 
For short syntax, you may use this command "alias bot='DIR_PATH/bot'" 
After that, you can use 'bot help', to get the list of all commands.