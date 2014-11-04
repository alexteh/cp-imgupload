<?php
/* display message saved in session if any */
echo $this->Session->flash();
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>


<div> 
<div class="images-form">
<?php echo $this->Form->create('Image', array('type' => 'file')); ?>
    <fieldset>
        <legend><?php echo __('Add Image'); ?></legend>
        <?php
       
        echo $this->Form->input('image', array('type' => 'file' , 'id' => 'add_image_input'));
    ?>
    </fieldset>
<?php 

echo $this->Html->link('back', array('action' => 'back')); 

echo $this->Form->end(__('Submit')); ?>

</div>
<script>
$(document).ready(function(){
 $("#add_image_input").trigger('click');
});
</script>
<div class="image-display">
<?php 

//if is set imageName show uploaded picture

if(isset($imageName)) {
echo $this->Html->image('/albums/images/'.$imageName, array('alt' => 'uploaded image'));
}
?>
</div>
</div>