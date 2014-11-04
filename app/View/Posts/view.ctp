<!-- File: /app/View/Posts/view.ctp -->

<h1><?php echo h($post['Post']['status']); ?></h1>

<p><small>Created: <?php echo $post['Post']['post_time']; ?></small></p>

<p><?php echo h($post['Post']['post_id']); ?></p>

<!-- 
<h1><?php echo h($post['Post']['title']); ?></h1>

<p><small>Created: <?php echo $post['Post']['created']; ?></small></p>

<p><?php echo h($post['Post']['body']); ?></p> -->