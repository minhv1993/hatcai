<?php defined('C5_EXECUTE') or die("Access Denied.");

      $c = Page::getCurrentPage();
      if (is_object($f)) {
          if ($maxWidth > 0 || $maxHeight > 0) {
              $im = Core::make('helper/image');
              $thumb = $im->getThumbnail(
                  $f,
                  $maxWidth,
                  $maxHeight
              ); //<-- set these 2 numbers to max width and height of thumbnails
              $tag = new \HtmlObject\Image();
              $tag->src($thumb->src)->width($thumb->width)->height($thumb->height);
              $tag->addClass('ccm-image-block img-responsive bID-'.$bID);
              if ($altText) {
                  $tag->alt(h($altText));
              }
              if ($title) {
                  $tag->title(h($title));
              }
              if ($linkURL):
                  print '<a href="' . $linkURL . '">';
              endif;

              print $tag;

              if ($linkURL):
                  print '</a>';
              endif;
          } else {
              if ($linkURL):
                  print '<a href="'.$linkURL.'">';
              endif;
              print '<div class="hc-image-block bID-'.$bID.'" alt="'.h($altText).'" title="'.h($title).'" style="background-image: url('.File::getRelativePathFromID($fID).')"></div>';

              if ($linkURL):
                  print '</a>';
              endif;
          }
      } else if ($c->isEditMode()) { ?>

<div class="ccm-edit-mode-disabled-item">
    <?php echo t('Empty Image Block.')?>
</div>

<?php } ?>

<?php if(isset($foS) && is_object($foS)) { ?>
<script>
$(function() {
    $('.bID-<?php print $bID;?>')
        .mouseover(function(e){$(this).css("background-image", '<?php print $imgPath["hover"];?>');})
        .mouseout(function (e) { $(this).css("background-image", '<?php print $imgPath["default"];?>'); });
});
</script>
<?php } ?>
