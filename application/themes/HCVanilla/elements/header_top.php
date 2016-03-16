<?php defined('C5_EXECUTE') or die("Access Denied.");?>
<!DOCTYPE html>
<html lang="<?php echo Localization::activeLanguage()?>">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href='https://fonts.googleapis.com/css?family=Patrick+Hand+SC|Kanit:400,600italic,600,500italic,500,400italic,700,700italic,300italic,300,200italic,200|Itim|Patrick+Hand|Alegreya+Sans+SC:400,700,700italic,800,400italic,500,500italic,300italic,300,800italic|Noticia+Text:400,400italic,700,700italic|Lobster|Open+Sans+Condensed:300,700|Roboto+Slab:400,300,700|Roboto+Condensed:400,300,300italic,400italic,700,700italic&subset=latin,vietnamese' rel='stylesheet' type='text/css'>
    <link href="//cdn.muicss.com/mui-0.4.7/css/mui.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $view->getThemePath()?>/css/bootstrap-modified.css">
    <?php echo $html->css($view->getStylesheet('main.less'))?>
    <?php Loader::element('header_required', array('pageTitle' => isset($pageTitle) ? $pageTitle : '', 'pageDescription' => isset($pageDescription) ? $pageDescription : ''));?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//cdn.muicss.com/mui-0.4.7/js/mui.min.js"></script>
    <script>
        if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
            var msViewportStyle = document.createElement('style')
            msViewportStyle.appendChild(
                document.createTextNode(
                    '@-ms-viewport{width:auto!important}'
                )
            )
            document.querySelector('head').appendChild(msViewportStyle)
        }

        function toggleMenu(){
            $("#menu-toggle, #menu").toggleClass("active");
        }
    </script>
</head>
<body>

<div class="<?php echo $c->getPageWrapperClass()?>">
