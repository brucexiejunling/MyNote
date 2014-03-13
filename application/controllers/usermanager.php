<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class UserManager extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
    }
    
    public function login(){
        $this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[30]|valid_email|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[30]|xss_clean');
        if($this->form_validation->run() == false){
            $result["success"] = false;
            $result["msg"] = "data not valid";
        }else{
            $user = $this->UserModel->check($this->input->post('email'), $this->input->post('password'));
            if($user==null){
                $result["success"] = false;
                $result["msg"] = "email or password not valid";
            }else{
                $result["success"] = true;
                $result["msg"] = $this->load->view("usermanager/topbarstatus", array("islogin"=>true, "user"=>$user), true);
                $this->session->set_userdata($user);
                $this->session->set_userdata(array("islogin"=>true));
            }
        }
        echo json_encode($result);
    }
    
    public function logout(){
        $this->session->sess_destroy();
        $this->load->view("usermanager/topbarstatus", array());
    }
    public function signup(){
        $this->form_validation->set_rules('newemail', 'Email', 'trim|required|max_length[20]|valid_email|xss_clean');
        $this->form_validation->set_rules('newpassword', 'Password', 'trim|required|max_length[15]|xss_clean');
        if($this->form_validation->run() == false){
            $result["success"] = false;
            $result["msg"] = "data not valid";
        }
        if($this->input->post('newpassword')!=$this->input->post('newpassword_again')){
            
            $result["success"] = false;
            $result["msg"] = "Password is not the same";
        }
        else{
            $user = $this->UserModel->check_new($this->input->post('newemail'),$this->input->post('newnickname'),$this->input->post('newpassword'));
            if($user==null){
                $result["success"] = false;
                $result["msg"] = "email or nickname exists";
            }else{
                $result["success"] = true;
                $result["msg"] = $this->load->view("usermanager/topbarstatus", array("islogin"=>true, "user"=>$user), true);
                $this->session->set_userdata($user);
                $this->session->set_userdata(array("islogin"=>true));
            }
        }
        echo json_encode($result);
    }
    public function topbarstatus(){
        $session = $this->session->userdata;
        $data = array();
        $data['islogin'] = isset($session['islogin']) && $session['islogin'];
        $data['user'] = $data['islogin']?$this->UserModel->getUserBySession($session):array();
        $this->load->view("usermanager/topbarstatus", $data);
    }

    private function _generate($pages=array(), $data=array()) {
        $data["body_content"] = "";
        foreach ($pages as $page) {
            $data["body_content"] .= $this->load->view($page, $data, true);
        }
        $this->load->view("base", $data);
    }

}