<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Note extends CI_Controller {
    public function index() {
        $session = $this->session->userdata;
        $data = array();
        
        $data['islogin'] = isset($session['islogin']) && $session['islogin'];
        $data['user'] = $data['islogin'] ? $this->UserModel->getUserBySession($session) : array();
        $data['notes'] = $data['islogin'] ? $this->NoteModel->getNotesByUserIdAndType($session['id']): array();
        
        foreach( $data['notes'] as $note ){
            if($note['target_type'] == 1)
                $data['books'][] = $data['islogin'] ? $this->UserModel->getBookByid($note['target_id']) : array();
            else if($note['target_type'] == 2)
                $data['papers'][] = $data['islogin'] ? $this->UserModel->getPaperByid($note['target_id']) : array();
        }
        
        $data["title"]= "My notes";
        $data["css"][] ="userinfo.css";
        $this->_generate(array("user/usernote"), $data);
    }
public function delete($cid) {
        $session = $this->session->userdata;
        $data = array();
        $data['islogin'] = isset($session['islogin']) && $session['islogin'];
        $data['note'] = $data['islogin'] ? $this->NoteModel->getNoteById($cid) : array();
        if($data['note']['user_id']==$session['id']) {
            $this->NoteModel->deleteNote($cid,$session);
        }
        $this->index();
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