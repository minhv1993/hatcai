<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>


<!DOCTYPE html lang="<?php echo Localization::activeLanguage()?>">
<html lang="en">
    <head>
        <link href='https://fonts.googleapis.com/css?family=Patrick+Hand+SC|Kanit:400,600italic,600,500italic,500,400italic,700,700italic,300italic,300,200italic,200|Itim|Patrick+Hand|Alegreya+Sans+SC:400,700,700italic,800,400italic,500,500italic,300italic,300,800italic|Noticia+Text:400,400italic,700,700italic|Lobster|Open+Sans+Condensed:300,700|Roboto+Slab:400,300,700|Roboto+Condensed:400,300,300italic,400italic,700,700italic&subset=latin,vietnamese' rel='stylesheet' type='text/css'>
        <?php echo $html->css($view->getStylesheet('main.less'))?>
        <?php Loader::element('header_required') ?>
    </head>
    <body>
        <div id="hc-vanilla" class="<?php echo $c->getPageWrapperClass()?> hc-container">
            <header class="hc-header">
                <section class="logo">
                    <?php $a = new GlobalArea("Site Logo");
                        $a->display();
                    ?>
                </section>
                <section class="navbar">
                    <?php $a = new GlobalArea("Site Navigation");
                        $a->display();
                    ?>
                </section>
            </header>
