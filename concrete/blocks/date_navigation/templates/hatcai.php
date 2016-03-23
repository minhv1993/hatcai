<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="hc-text-list-wrapper">

    <div class="hc-text-list-header">
        <h5><?php echo h($title)?></h5>
    </div>

    <?php if (count($dates)) { ?>
	<ul class="hc-text-list-list">
            <li><a href="<?php echo $view->controller->getDateLink()?>"><?php echo t('All')?></a></li>

            <?php foreach($dates as $date) { ?>
                <li><a href="<?php echo $view->controller->getDateLink($date)?>"
                        <?php if ($view->controller->isSelectedDate($date)) { ?>
	class="hc-text-list-list-selected"
                        <?php } ?>><?php echo $view->controller->getDateLabel($date)?></a></li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <?php echo t('None.')?>
    <?php } ?>


</div>
