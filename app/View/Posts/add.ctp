<!-- File: /app/View/Posts/add.ctp -->

<h1>Add Post</h1>
<?php
echo $this->Form->create('Post');
// echo $this->Form->input('title');
echo $this->Form->input('status', array('rows' => '3'));
echo $this->Form->input('tmp_post', array('type' => 'hidden','default'=>'0'));
echo $this->Form->end('Save Post');
?>