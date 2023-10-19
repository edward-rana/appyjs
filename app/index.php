<?php require_once( 'system/functions.php' ); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $metas_html = '';
    if( function_exists('aj_page_title_metas') ){
        $metas_html = aj_page_title_metas();
    }
    echo ( $metas_html ? $metas_html : '<title>Default</title>'.PHP_EOL );
    ?>
    <link rel="stylesheet" type="text/css" href="theme/assets/css/style.css?v=1.0.0">
    <link rel="stylesheet" type="text/css" href="theme/assets/css/bootstrap.min.css?v=5.3.2" id="bootstrap-style">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css?v=4.7.0" id="fontawesome-style">
</head>
<body>
    <div id="app_root"></div>
    
    <app_theme>
        <app_page></app_page>
    </app_theme>
    <script src="theme/assets/js/script.js?v=1.0.0"></script>
    <script src="theme/assets/js/bootstrap.min.js?v=5.3.2" id="bootstrap-script"></script>
    <script src="theme/assets/js/jquery.min.js?v=3.7.1" id="jquery-script"></script>
    <!-- Auto-loaded system scripts -->
    <script src="system/config.js?v=1.0.0"></script>
    <script src="system/app.js?v=1.0.0"></script>
</body>
</html>