<?php defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header_top.php');
?>

<header class="hc-header">
  <div class="container">
    <div class="row bottom-xs">
      <div class="xs-12 lg-4 no-padding-xs no-padding-sm no-padding-md margin-bot-xs margin-bot-sm margin-bot-md">
        <a class="hc-logo" href="/">
          <span class="logo-top">Hạt Cải</span>
          <span class="logo-bottom">Mustard Seed</span>
        </a>
      </div>
      <div class="xs-12 lg-8">
        <div class="row">
          <div class="xs-3 sm-2 md-1 lg-offset-6 lg-2 border-bot-xs border-bot-sm border-bot-md first-lg">
            <div class="hc-auth pull-right">
              <?php echo Core::make('helper/navigation')->getLogInOutLink()?>
            </div>
          </div>
          <div class="xs-9 sm-10 md-11 lg-4 border-bot-xs border-bot-sm border-bot-md first-xs">
            <?php 
              $as = new GlobalArea('Header Search');
              $as->display(); ?>
          </div>
          <div class="xs-12 border-bot-xs border-bot-sm border-bot-md margin-top-xs margin-top-sm margin-top-md">
            <?php
              $a = new GlobalArea('Header Navigation');
              $a->display(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>