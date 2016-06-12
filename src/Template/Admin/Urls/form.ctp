<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'URLs');
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'URLs'), array('action' => 'index'));

if ($this->action == 'admin_edit') {
	$this->Html->addCrumb($this->data['SeoLiteUrl']['url'], '/' . $this->request->url);
	$this->viewVars['title_for_layout'] = 'Url: ' . $this->data['SeoLiteUrl']['url'];
} else {
	$this->Html->addCrumb(__d('croogo', 'Add'), '/' . $this->request->url);
}

echo $this->Form->create('SeoLiteUrl');

?>
<div class="seoLiteUrls row-fluid">
	<div class="span8">
		<ul class="nav nav-tabs">
		<?php
			echo $this->Croogo->adminTab(__d('croogo', 'Url'), '#seo-lite-url');
			echo $this->Croogo->adminTabs();
		?>
		</ul>

		<div class="tab-content">
			<div id='seo-lite-url' class="tab-pane">
			<?php
				echo $this->Form->input('id');
				$this->Form->inputDefaults(array('label' => false, 'class' => 'span10'));
				echo $this->Form->input('url', array(
					'label' => 'Url',
				));
				echo $this->Form->input('description', array(
					'label' => 'Description',
				));
				echo $this->Form->input('status', array(
					'label' => 'Status',
					'class' => false,
				));
			?>
			</div>
			<?php
				echo $this->Croogo->adminTabs();
			?>
		</div>

	</div>

	<div class="span4">
	<?php
		echo $this->Html->beginBox(__d('croogo', 'Publishing')) .
			$this->Form->button(__d('croogo', 'Apply'), array('name' => 'apply')) .
			$this->Form->button(__d('croogo', 'Save'), array('class' => 'btn btn-primary')) .
			$this->Html->link(__d('croogo', 'Cancel'), array('action' => 'index'), array('class' => 'btn btn-danger')) .
			$this->Html->endBox();
		?>
	</div>

</div>
<?php echo $this->Form->end(); ?>
