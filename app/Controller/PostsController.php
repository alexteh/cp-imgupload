<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class PostsController extends AppController {
    public $helpers = array('Html', 'Form');

    public function index() {
        $this->set('posts', $this->Post->find('all'));
    }

    public function view($post_id = null) 
     {
        if (!$post_id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $conditions = array("Post.post_id" => $post_id);
		// Example usage with a model:
		$post = $this->Post->find('first', array('conditions' => $conditions));

       // $post = $this->Post->findById($post_id);
        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('post', $post);
    }
    public function add() {
        if ($this->request->is('post')) {
            $this->Post->create();
            if ($this->Post->save($this->request->data)) {
                $this->Session->setFlash(__('Your post has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Unable to add your post.'));
        }
    }

    public function delete($post_id) 
    {
	    if ($this->request->is('get')) {
	        throw new MethodNotAllowedException();
	    }

	    if ($this->Post->delete($post_id)) {
	        $this->Session->setFlash(
	            __('The post with id: %s has been deleted.', h($post_id))
	        );
	        return $this->redirect(array('action' => 'index'));
	    }
	}

    public function edit($id = null) 
     {
	    if (!$id) {
	        throw new NotFoundException(__('Invalid post'));
	    }


        $conditions = array("Post.post_id" => $id);
		// Example usage with a model:
		$post = $this->Post->find('first', array('conditions' => $conditions));

	   // $post = $this->Post->findById($id);

	    if (!$post) {
	        throw new NotFoundException(__('Invalid post'));
	    }

	    if ($this->request->is(array('post', 'put'))) {
	        $this->Post->post_id = $id;
	        if ($this->Post->save($this->request->data)) {
	            $this->Session->setFlash(__('Your post has been updated.'));
	            return $this->redirect(array('action' => 'index'));
	        }
	        $this->Session->setFlash(__('Unable to update your post.'));
	    }

	    if (!$this->request->data) {
	        $this->request->data = $post;
	    }
	}

	public function addpic(){
		 return $this->redirect(
            array('controller' => 'addimage', 'action' => 'display')
        );
	}
}

