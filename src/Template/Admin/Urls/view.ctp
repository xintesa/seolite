<?php
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'URLs'), h($url['id']));

$this->Html
    ->addCrumb('', '/admin', array('icon' => 'home'))
    ->addCrumb(__d('croogo', 'URLs'), array('action' => 'index'));

?>
<h2 class="hidden-desktop"><?php echo __d('croogo', 'URL'); ?></h2>

<?php $this->append('action-buttons'); ?>
    <?php echo $this->Croogo->adminAction(__d('croogo', 'Edit URL'), array('action' => 'edit', $url['id']), array('button' => 'outline-secondary')); ?>
    <?php echo $this->Croogo->adminAction(__d('croogo', 'Delete URL'), array('action' => 'delete', $url['id']), array('button' => 'outline-danger', 'escape' => true), __d('croogo', 'Are you sure you want to delete # {0}?', $url['id'])); ?>
    <?php echo $this->Croogo->adminAction(__d('croogo', 'List URLs'), array('action' => 'index'), array('button' => 'outline-secondary')); ?>
    <?php echo $this->Croogo->adminAction(__d('croogo', 'New URL'), array('action' => 'add'), array('button' => 'outline-success')); ?>
<?php $this->end(); ?>

<div class="seoLiteUrls view">
    <dl class="inline">
        <dt><?php echo __d('croogo', 'Id'); ?></dt>
        <dd>
            <?php echo h($url['id']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('croogo', 'Url'); ?></dt>
        <dd>
            <?php echo h($url['url']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('croogo', 'Description'); ?></dt>
        <dd>
            <?php echo h($url['description']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('croogo', 'Status'); ?></dt>
        <dd>
            <?php echo h($url['status']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('croogo', 'Created'); ?></dt>
        <dd>
            <?php echo h($url['created']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('croogo', 'Created By'); ?></dt>
        <dd>
            <?php echo h($url['TrackableCreator']['username']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('croogo', 'Updated'); ?></dt>
        <dd>
            <?php echo h($url['updated']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('croogo', 'Updated By'); ?></dt>
        <dd>
            <?php echo h($url['username']); ?>
            &nbsp;
        </dd>
    </dl>
</div>
