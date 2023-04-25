<?php
    //error_reporting(0);
    setlocale(LC_ALL, 'es_ES');
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    set_time_limit(600);

    require_once 'libs/database.php';
    require_once 'libs/controller.php';
    require_once 'libs/view.php';
    require_once 'libs/model.php';
    require_once 'libs/app.php';
    require_once 'config/config.php';
    
    $app = new App();
?>