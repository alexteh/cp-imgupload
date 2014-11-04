<?php
class Post extends AppModel {
var $primaryKey= 'post_id';
    public $validate = array(
        // 'title' => array('rule' => 'notEmpty'),

        'status' => array('rule' => 'notEmpty')

    );
}

?>