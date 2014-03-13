<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $session = $this->session->userdata;
        if(!(isset($session['islogin']) && $session['islogin'] && $session['privilege']==1)){
            redirect(base_url('index.php/admin/request_login'));
            return;
        }
        $this->_generate(array('admin/sidebar'));
    }
    
    public function request_login(){
        $this->_generate(array('admin/requestlogin'));
    }
    
    public function book($page=1){
        $session = $this->session->userdata;
        if(!(isset($session['islogin']) && $session['islogin'] && $session['privilege']==1)){
            redirect(base_url('index.php/admin/request_login'));
            return;
        }
        $pagenum = 10;
        $data['books'] = $this->BookModel->getBooksInOrder(($page-1)*$pagenum, $pagenum);
        $data['cur_page'] = $page;
        $data['total_page'] = ceil($this->BookModel->getTotal()/$pagenum);
        $data['css'][] = 'adminbook.css';
        $data['js'][] = 'admin/book.js';
        $this->_generate(array('admin/sidebar.php', 'admin/book.php'), $data);
    }
    
    public function delete_book($book_id){
        $session = $this->session->userdata;
        if(!(isset($session['islogin']) && $session['islogin'] && $session['privilege']==1)){
            $result['success'] = false;
            $result['msg'] = 'you cant do this operation';
        }
        if(!$this->BookModel->deleteBookById($book_id)){
            $result['success'] = false;
            $result['msg'] = 'it cant be done somehow';
        }else{
            $result['success'] = true;
            $result['msg'] = 'the book is deleted';
        }
        echo json_encode($result);
    }
    
    public function paper($page=1){
        $session = $this->session->userdata;
        if(!(isset($session['islogin']) && $session['islogin'] && $session['privilege']==1)){
            redirect(base_url('index.php/admin/request_login'));
            return;
        }
        $pagenum = 10;
        $data['papers'] = $this->PaperModel->getPapersInOrder(($page-1)*$pagenum, $pagenum);
        $data['cur_page'] = $page;
        $data['total_page'] = ceil($this->PaperModel->getTotal()/$pagenum);
        $data['css'][] = 'adminpaper.css';
        $data['js'][] = 'admin/paper.js';
        $this->_generate(array('admin/sidebar.php', 'admin/paper.php'), $data);
    }
    
    public function delete_paper($paper_id){
        $session = $this->session->userdata;
        if(!(isset($session['islogin']) && $session['islogin'] && $session['privilege']==1)){
            $result['success'] = false;
            $result['msg'] = 'you cant do this operation';
        }
        if(!$this->PaperModel->deletePaperById($paper_id)){
            $result['success'] = false;
            $result['msg'] = 'it cant be done somehow';
        }else{
            $result['success'] = true;
            $result['msg'] = 'the paper is deleted';
        }
        echo json_encode($result);
    }
    
    public function webpage($page=1){
        $session = $this->session->userdata;
        if(!(isset($session['islogin']) && $session['islogin'] && $session['privilege']==1)){
            redirect(base_url('index.php/admin/request_login'));
            return;
        }
        $pagenum = 10;
        $data['webpages'] = $this->WebpageModel->getWebpagesInOrder(($page-1)*$pagenum, $pagenum);
        $data['cur_page'] = $page;
        $data['total_page'] = ceil($this->WebpageModel->getTotal()/$pagenum);
        $data['css'][] = 'adminwebpage.css';
        $data['js'][] = 'admin/webpage.js';
        $this->_generate(array('admin/sidebar.php', 'admin/webpage.php'), $data);
    }
    
    public function delete_webpage($webpage_id){
        $session = $this->session->userdata;
        if(!(isset($session['islogin']) && $session['islogin'] && $session['privilege']==1)){
            $result['success'] = false;
            $result['msg'] = 'you cant do this operation';
        }
        if(!$this->WebpageModel->deleteWebpageById($webpage_id)){
            $result['success'] = false;
            $result['msg'] = 'it cant be done somehow';
        }else{
            $result['success'] = true;
            $result['msg'] = 'the webpage is deleted';
        }
        echo json_encode($result);
    }
    
    public function user($page=1){
        $session = $this->session->userdata;
        if(!(isset($session['islogin']) && $session['islogin'] && $session['privilege']==1)){
            redirect(base_url('index.php/admin/request_login'));
            return;
        }
        $pagenum = 10;
        $data['users'] = $this->UserModel->getUsersInOrder(($page-1)*$pagenum, $pagenum);
        $data['cur_page'] = $page;
        $data['total_page'] = ceil($this->UserModel->getTotal()/$pagenum);
        $data['css'][] = 'adminuser.css';
        $data['js'][] = 'admin/user.js';
        $this->_generate(array('admin/sidebar.php', 'admin/user.php'), $data);
    }
    
    public function delete_user($user_id){
        $session = $this->session->userdata;
        if(!(isset($session['islogin']) && $session['islogin'] && $session['privilege']==1)){
            $result['success'] = false;
            $result['msg'] = 'you cant do this operation';
        }
        if(!$this->UserModel->deleteUserById($user_id)){
            $result['success'] = false;
            $result['msg'] = 'it cant be done somehow';
        }else{
            $result['success'] = true;
            $result['msg'] = 'the user is deleted';
        }
        echo json_encode($result);
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