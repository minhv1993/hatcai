<?php defined('C5_EXECUTE') or die("Access Denied.");
$linkCount = 1;
$faqEntryCount = 1; ?>
<div class="row hc-faq-block-wrapper">
    <?php if (count($rows) > 0) { ?>
        <div class="xs-12">
			<div class="hc-faq-links">
				<?php foreach ($rows as $row) { ?>
					<a href="#<?php echo $bID . $linkCount ?>" class="hc-faq-link"><i class="fa fa-question"></i><?php echo $row['linkTitle'] ?></a>
					<?php $linkCount++;
				} ?>
			</div>
		</div>
        <div class="xs-12 hc-faq-entry">
            <?php foreach ($rows as $row) { ?>
                <div id="<?php echo $bID . $faqEntryCount ?>" name="<?php echo $bID . $faqEntryCount ?>" class="hc-faq-entry-content">
                	
                <h3><i class="fa fa-question"></i><?php echo $row['title'] ?></h3>
                <div class="hc-fag-entry-content"><i class="fa fa-info"></i><?php echo $row['description'] ?></div>
                </div>
                <?php $faqEntryCount++;
            } ?>
        </div>
    <?php } else { ?>
		<div class="hc-faq-links">
            <p><?php echo t('No Faq Entries Entered.'); ?></p>
        </div>
    <?php } ?>
</div>
