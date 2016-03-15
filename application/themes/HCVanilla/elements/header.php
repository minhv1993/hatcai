<?php defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header_top.php');
?>

<header class="hc-header">
  <div class="container">
    <div class="row bottom-xs">
      <div class="xs-12 sm-4">
        <a class="hc-logo" href="/">
          <span class="logo-top">Hạt Cải</span>
          <span class="logo-bottom">Mustard Seed</span>
        </a>
      </div>
      <div class="hc-auth-search">
        <span class="pull-right hc-search"><?php 
          $as = new GlobalArea('Header Search');
          $as->display(); ?>
        </span>
        <span class="pull-right hc-auth"><?php echo Core::make('helper/navigation')->getLogInOutLink()?></span>
      </div>
      <div class="xs-12 sm-8">
        <?php
          $a = new GlobalArea('Header Navigation');
          $a->display(); ?>
      </div>
    </div>
  </div>
</header>