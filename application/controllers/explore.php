<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Explore extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['js'][] = 'bootstrap-twipsy.js';
        $data['js'][] = 'bootstrap-popover.js';
        $data['js'][] = 'explore.js';
        $data['css'][] = 'explore.css';
        $data['title'] = 'Explore Resource - Washing Machie-My notes';
        $data['classifications'] = $this->ClassificationModel->getAll();
        $data['groups'] = $this->GroupModel->getByRandom();
        $this->_generate(array("explore"), $data);
    }

    public function ajaxitems(){
        $data['items'] = array();
        $classifications = $this->ClassificationModel->getAll();
        $classes = $this->input->get('classification')==''?array():explode('|', $this->input->get('classification'));
        $types = $this->input->get('type')==''?array():explode('|', $this->input->get('type'));
        $class_ids = array();
        if($classes!=array()){
            foreach($classes as $clazz){
                $classModel = $this->ClassificationModel->getClassificationByName($clazz);
                $class_ids[] = $classModel['id'];
            }
        }
        if(in_array("book", $types)){
            $data['items'] = array_merge($data['items'], $this->BookModel->getRandomBooks(10, $class_ids));
        }
        if(in_array("paper", $types)){
            $data['items'] = array_merge($data['items'], $this->PaperModel->getRandomPapers(10, $class_ids));
        }
        if(in_array("webpage", $types)){
            $data['items'] = array_merge($data['items'], $this->WebpageModel->getRandomWebpages(10, $class_ids));
        }
        if($types==array()){
            $data['items'] = array_merge($data['items'], $this->BookModel->getRandomBooks(10, $class_ids));
            $data['items'] = array_merge($data['items'], $this->PaperModel->getRandomPapers(2, $class_ids));
            $data['items'] = array_merge($data['items'], $this->WebpageModel->getRandomWebpages(2, $class_ids));
        }
        shuffle($data['items']);
        
        foreach(array_slice($data['items'], 0, 10) as $item){
            $this->load->view("explore/{$item['type']}li", $item);
        }
    }

    private function _generate($pages=array(), $data=array()) {
        $data["body_content"] = "";
        foreach ($pages as $page) {
            $data["body_content"] .= $this->load->view($page, $data, true);
        }
        $this->load->view("base", $data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */