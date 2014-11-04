<h1>Blog posts</h1>
<p>
<?php

echo $this->Html->link('Add Post', array('action' => 'add')); 
echo '<br>';
echo $this->Html->link('Add Image', array('action' => 'addpic'));  

?>

</p>
<table>
    <tr>
        <th>post_Id</th>
        <th>Status</th>
        <th>Actions</th>
        <th>post_time</th>
    </tr>

<!-- Here's where we loop through our $posts array, printing out post info -->

    <?php foreach ($posts as $post): ?>
    <tr>
        <td><?php echo $post['Post']['post_id']; ?></td>
        <td>
            <?php
                echo $this->Html->link(
                    $post['Post']['status'],
                    array('action' => 'view', $post['Post']['post_id'])
                );
            ?>
        </td>
        <td>
            <?php
                echo $this->Form->postLink(
                    'Delete',
                    array('action' => 'delete', $post['Post']['post_id']),
                    array('confirm' => 'Are you sure?')
                );
            ?>
            <?php
                echo $this->Html->link(
                    'Edit', array('action' => 'edit', $post['Post']['post_id'])
                );
            ?>
        </td>
        <td>
            <?php echo $post['Post']['post_time']; ?>
        </td>
    </tr>
    <?php endforeach; ?>

</table>
