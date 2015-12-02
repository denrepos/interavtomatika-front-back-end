<!DOCTYPE html>
<html <?php language_attributes(); ?> >

<head>

    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <!--    <meta name="viewport" content="width=device-width initial-scale=1">-->
    <meta id="viewport" name="viewport"
          content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
    <![endif]-->

    <?php wp_head(); ?>

    <script>
        // var viewPortScale = 1 / window.devicePixelRatio;
        // alert(viewPortScale);
        // $('#viewport').attr('content', 'user-scalable=no, initial-scale='+viewPortScale+', width=device-width');
    </script>
    <!--    for debug-->
    <script>
        // Обеспечиваем поддержу XMLHttpRequest`а в IE
        var xmlVersions = new Array(
            "Msxml2.XMLHTTP.6.0",
            "MSXML2.XMLHTTP.3.0",
            "MSXML2.XMLHTTP",
            "Microsoft.XMLHTTP"
        );
        if (typeof XMLHttpRequest == "undefined") XMLHttpRequest = function () {
            for (var i in xmlVersions) {
                try {
                    return new ActiveXObject(xmlVersions[i]);
                }
                catch (e) {
                }
            }
            throw new Error("This browser does not support XMLHttpRequest.");
        };


        // Собственно, сам наш обработчик.
        function myErrHandler(message, url, line) {
            var server_url = window.location.toString().split("/")[2];
            var params = {};
            params.message = message;
            params.url = url;
            params.line = line;
            $.post('http://' + server_url + '/js_errors.php', params);
            // Чтобы подавить стандартный диалог ошибки JavaScript,
            // функция должна возвратить true
//            return true;
        }

        //назначаем обработчик для события onerror
        window.onerror = myErrHandler;

    </script>

</head>

<body <?php body_class(); ?>>