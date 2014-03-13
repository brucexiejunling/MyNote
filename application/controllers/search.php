<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $keyword = $this->input->get('search');
        $data['book_result'] = $this->BookModel->search($keyword);
        $data['paper_result'] = $this->PaperModel->search($keyword);
        $data['webpage_result'] = $this->WebpageModel->search($keyword);
        $data['group_result'] = $this->GroupModel->search($keyword);
        $data['user_result'] = $this->UserModel->search($keyword);
        $data['css'][] = 'search.css';
         $data['title'] = 'Search Result in My notes-Washing Machine';
        $this->_generate(array('search'), $data);
    }

    private function _generate($pages=array(), $data=array()) {
        $data["body_content"] = "";
        foreach ($pages as $page) {
            $data["body_content"] .= $this->load->view($page, $data, true);
        }
        $this->load->view("base", $data);
    }

}