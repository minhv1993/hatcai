<?php  defined('C5_EXECUTE') or die("Access Denied.");
if (!isset($selectedTopicID)) {
    $selectedTopicID = null;
}
?>

<div class="hc-text-list-wrapper">
    <div class="hc-text-list-header">
        <h5><?php echo h($title); ?></h5>
    </div>
	<?php if ($mode == 'S' && is_object($tree)) {
		$node = $tree->getRootTreeNodeObject();
		$node->populateChildren();
		if (is_object($node)) {
			if (!isset($selectedTopicID)) {
				$selectedTopicID = null;
			}
			$walk = function ($node) use (&$walk, &$view, $selectedTopicID) { ?>
	<ul class="hc-text-list-list">
				<?php foreach ($node->getChildNodes() as $topic) {
				if ($topic instanceof \Concrete\Core\Tree\Node\Type\TopicCategory) { ?>
					<li><?php echo $topic->getTreeNodeDisplayName(); ?></li>
				<?php } else { ?>
					<li><a href="<?php echo $view->controller->getTopicLink($topic); ?>" 
					<?php if (isset($selectedTopicID) && $selectedTopicID == $topic->getTreeNodeID()) { ?> 
	class="hc-text-list-list-selected"
					<?php } ?>><?php echo $topic->getTreeNodeDisplayName(); ?></a></li>
				<?php }
			$walk($topic);
			} ?></ul><?php
};
$walk($node);
}
}

if ($mode == 'P') {
if (count($topics)) {
	?><ul class="hc-text-list-list"><?php
foreach ($topics as $topic) {
?><li><a href="<?php echo $view->controller->getTopicLink($topic); ?>"><?php echo $topic->getTreeNodeDisplayName(); ?></a></li><?php
}
?></ul><?php 
} else {
echo t('No topics.');
}
}
?>

</div>