<?php defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header_top.php');
?>

<header class="hc-header">
  <div class="container">
    <div class="row bottom-xs">
      <div class="xs-12 md-5 no-padding-xs no-padding-sm margin-bot-sm">
        <a class="hc-logo" href="/">
          <span class="logo-top">Hạt Cải</span>
          <span class="logo-bottom">Mustard Seed</span>
        </a>
      </div>
      <div id="menu-toggle" class="hidden-sm hidden-md hidden-lg hidden-xl menu-button" onclick="toggleMenu()">
        <i class="fa fa-bars"></i>
      </div>
      <div id="menu"class="xs-12 md-7 hidden-xs">
        <div class="row full-height-xs column-xs start-xs">
          <div class="xs-12 sm-offset-0 sm-2 md-offset-6 md-2 border-bot-xs border-bot-sm margin-top-xs first-md boxed">
            <div class="hc-auth pull-right">
              <?php echo Core::make('helper/navigation')->getLogInOutLink()?>
            </div>
          </div>
          <div class="xs-12 sm-10 md-4 border-bot-xs border-bot-sm margin-top-xs first-sm boxed">
            <?php 
              $as = new GlobalArea('Header Search');
              $as->display(); ?>
          </div>
          <div class="xs-12 margin-bot-sm margin-top-xs margin-top-sm nav-wrapper">
            <?php
              $a = new GlobalArea('Header Navigation');
              $a->display(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>