<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'URLs');
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'URLs'), array('action' => 'index'));

$this->start('actions');
echo $this->Croogo->adminAction(__d('seo_lite', 'New URL'),
	array('action' => 'add'),
	array('button' => 'success')
);
$this->end();

?>
<div class="seoLiteUrls index">
	<table class="table table-striped">
	<tr>
		<th><?php echo $this->Paginator->sort('id'); ?></th>
		<th><?php echo $this->Paginator->sort('url'); ?></th>
		<th><?php echo $this->Paginator->sort('created'); ?></th>
		<th><?php echo $this->Paginator->sort('created_by'); ?></th>
		<th><?php echo $this->Paginator->sort('updated'); ?></th>
		<th><?php echo $this->Paginator->sort('updated_by'); ?></th>
		<th><?php echo $this->Paginator->sort('status'); ?></th>
		<th class="actions"><?php echo __d('croogo', 'Actions'); ?></th>
	</tr>
	<?php foreach ($seoLiteUrls as $seoLiteUrl): ?>
	<tr>
		<td><?php echo h($seoLiteUrl['SeoLiteUrl']['id']); ?>&nbsp;</td>
		<td>
		<?php
		echo $this->Html->div(null, $seoLiteUrl['SeoLiteUrl']['url'], array(
			'title' => $seoLiteUrl['SeoLiteUrl']['description'],
		));
		?>&nbsp;
		</td>
		<td><?php echo h($seoLiteUrl['SeoLiteUrl']['created']); ?>&nbsp;</td>
		<td><?php echo h($seoLiteUrl['TrackableCreator']['username']); ?>&nbsp;</td>
		<td><?php echo h($seoLiteUrl['SeoLiteUrl']['updated']); ?>&nbsp;</td>
		<td><?php echo h($seoLiteUrl['TrackableUpdater']['username']); ?>&nbsp;</td>
		<td><?php echo $this->Html->status($seoLiteUrl['SeoLiteUrl']['status']); ?>&nbsp;</td>
		<td class="item-actions">
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'view', $seoLiteUrl['SeoLiteUrl']['id']), array('icon' => 'eye-open')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'edit', $seoLiteUrl['SeoLiteUrl']['id']), array('icon' => 'pencil')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'delete', $seoLiteUrl['SeoLiteUrl']['id']), array('icon' => 'trash'), __d('croogo', 'Are you sure you want to delete # %s?', $seoLiteUrl['SeoLiteUrl']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
