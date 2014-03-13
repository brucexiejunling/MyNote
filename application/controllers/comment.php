<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comment extends CI_Controller {

    public function index() {
        $session = $this->session->userdata;
        $data = array();

        $data['islogin'] = isset($session['islogin']) && $session['islogin'];
        $data['user'] = $data['islogin'] ? $this->UserModel->getUserBySession($session) : array();
        $data['comments'] = $data['islogin'] ? $this->CommentModel->getCommentsByUserIdAndType($session['id']) : array();
        foreach ($data['comments'] as $tcomment) {
            if ($tcomment['target_type'] == 1)
                $data['books'][] = $data['islogin'] ? $this->UserModel->getBookByid($tcomment['target_id']) : array();
            else if ($tcomment['target_type'] == 2)
                $data['papers'][] = $data['islogin'] ? $this->UserModel->getPaperByid($tcomment['target_id']) : array();
            else if ($tcomment['target_type'] == 3)
                $data['webpages'][] = $data['islogin'] ? $this->UserModel->getWebpageByid($tcomment['target_id']) : array();
        }

        $data["title"] = "My comments";
        $data["css"][] = "userinfo.css";
        $this->_generate(array("user/usercomment"), $data);
    }

    public function delete($cid) {
        $session = $this->session->userdata;
        $data = array();
        $data['islogin'] = isset($session['islogin']) && $session['islogin'];
        $data['comments'] = $data['islogin'] ? $this->CommentModel->getCommentById($cid) : array();
        if($data['comments']['user_id']==$session['id']) {
            $this->CommentModel->deleteComment($cid,$session);
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