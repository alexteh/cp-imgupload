<h1>Edit Post</h1>
<?php
echo $this->Form->create('Post');
echo $this->Form->input('status', array('rows' => '3'));
echo $this->Form->input('post_id', array('type' => 'hidden'));
echo $this->Form->input('tmp_post', array('type' => 'hidden','default'=>'0'));
echo $this->Form->end('Save Post');
?>
