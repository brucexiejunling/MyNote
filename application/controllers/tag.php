<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tag extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->add();
    }
    
    public function add($target_type, $target_id){
        $session = $this->session->userdata;
        if(!(isset($session['islogin']) && $session['islogin'])){
            $result['success'] = false;
            $result['msg'] = 'you need to login';
        }else if($this->input->post('newtag')==''){
            $result['success'] = false;
            $result['msg'] = 'the new tag is empty';
        }else{
            $tag = $this->TagModel->getTagByName($this->input->post('newtag'));
            if($tag==null){
                $tag = $this->TagModel->add($this->input->post('newtag'));
            }
            $tag_target = $this->TagTargetModel->add($target_type, $target_id, $tag['id']);
            $tagship = $this->TagshipModel->add($tag_target['id'], $session['id']);
            $tag_num = $this->TagshipModel->count_up($tag_target['id']);
            $result['success']=true;
            $result['msg'] = "
                <span class='label tag' alt='{$tag['id']}' target_type='{$target_type}' target_id='{$target_id}'>
                    {$tag['name']}($tag_num)
                </span>";
        }
        echo json_encode($result);
    }
    
    public function up($target_type, $target_id, $tag_id){
        $session = $this->session->userdata;
        if(!(isset($session["islogin"]) && $session["islogin"])){
            $result['success'] = false;
            $result['msg'] = 'you need to login';
        }else{
            $tag_target = $this->TagTargetModel->getSpercified($target_type, $target_id, $tag_id);
            $this->TagshipModel->add($tag_target['id'], $session['id']);
            $result['success'] = true;
            $tag = $this->TagModel->getTagById($tag_id);
            $result['msg'] = $tag["name"]."(".$this->TagshipModel->count_up($tag_target['id']).")";
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