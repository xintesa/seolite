<?php
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'URLs'), h($seoLiteUrl['SeoLiteUrl']['id']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'URLs'), array('action' => 'index'));

?>
<h2 class="hidden-desktop"><?php echo __d('croogo', 'URL'); ?></h2>

<div class="row-fluid">
	<div class="span12 actions">
		<ul class="nav-buttons">
		<li><?php echo $this->Html->link(__d('croogo', 'Edit URL'), array('action' => 'edit', $seoLiteUrl['SeoLiteUrl']['id']), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Form->postLink(__d('croogo', 'Delete URL'), array('action' => 'delete', $seoLiteUrl['SeoLiteUrl']['id']), array('button' => 'danger', 'escape' => true), __d('croogo', 'Are you sure you want to delete # %s?', $seoLiteUrl['SeoLiteUrl']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List URLs'), array('action' => 'index'), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New URL'), array('action' => 'add'), array('button' => 'success')); ?> </li>
		</ul>
	</div>
</div>

<div class="seoLiteUrls view">
	<dl class="inline">
		<dt><?php echo __d('croogo', 'Id'); ?></dt>
		<dd>
			<?php echo h($seoLiteUrl['SeoLiteUrl']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Url'); ?></dt>
		<dd>
			<?php echo h($seoLiteUrl['SeoLiteUrl']['url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Description'); ?></dt>
		<dd>
			<?php echo h($seoLiteUrl['SeoLiteUrl']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Status'); ?></dt>
		<dd>
			<?php echo h($seoLiteUrl['SeoLiteUrl']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Created'); ?></dt>
		<dd>
			<?php echo h($seoLiteUrl['SeoLiteUrl']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Created By'); ?></dt>
		<dd>
			<?php echo h($seoLiteUrl['TrackableCreator']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Updated'); ?></dt>
		<dd>
			<?php echo h($seoLiteUrl['SeoLiteUrl']['updated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Updated By'); ?></dt>
		<dd>
			<?php echo h($seoLiteUrl['TrackableUpdater']['username']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
