<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
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
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class AddImageController extends AppController 
{



/**
 * Controller name
 *
 * @var string
 */
public $name = 'AddImage';

/**
 * This controller does not use a model
 *
 * @var array
 */
public $uses = array();

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
    public function display() 
    {
      if ($this->request->is('post')) 
      {
        if ($this->data['Image']) 
        {
            $image = $this->data['Image']['image'];
                        //allowed image types
            $imageTypes = array("image/gif", "image/jpeg", "image/png");
                        //upload folder - make sure to create one in webroot
            $uploadFolder = "albums/images";
                        //full path to upload folder
            $uploadPath = WWW_ROOT.$uploadFolder;


                        //check if image type fits one of allowed types
            foreach ($imageTypes as $type) {
                if ($type == $image['type']) {
                              //check if there wasn't errors uploading file on serwer
                    if ($image['error'] == 0) {
                                     //image file name
                        $imageName = $image['name'];
                                    //check if file exists in upload uploadFolder
                        if (file_exists($uploadPath . '/' . $imageName)) {
                                                    //create full filename with timestamp
                            $imageName = date('His') . $imageName;

                        }
                                    //create full path with image name
                        $full_image_path = $uploadPath . '/' . $imageName;
                                    //upload image to upload folder
                        if (move_uploaded_file($image['tmp_name'], $full_image_path)) {
                            // $this->Session->setFlash('File saved successfully');
                            // $this->set('imageName',$imageName);
                            
        $url="home.php?album=images";
        $this->redirect('../'.$url, $status = null);
                        } else {
                            $this->Session->setFlash('There was a problem uploading file. Please try again.');
                        }
                    } else {


                        $this->Session->setFlash('Error uploading file.');
                    }        
                    break;
                } else {
                    $this->Session->setFlash('Unacceptable file type');
                }
            }
        }
      }
      $this->render('home');
    }
}
