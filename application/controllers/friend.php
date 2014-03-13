<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Friend extends CI_Controller {

    public function index() {
        $session = $this->session->userdata;
        $data = array();
        $data['islogin'] = isset($session['islogin']) && $session['islogin'];
        $data['user'] = $data['islogin'] ? $this->UserModel->getUserBySession($session) : array();
        $data['friends'] = $data['islogin'] ? $this->UserModel->get_friends($session) : array();
        $data['friendinfo'] = array();
        $data['notes'] = array();
        $data['comments'] = array();
        foreach ($data['friends'] as $friend_array) {
            if ($friend_array['user_id'] == $data['user']['id'])
                $id = $friend_array['follower_id'];
            else
                $id = $friend_array['user_id'];
            $user =  $this->UserModel->getUserById($id);
            $data['friendinfo'][] =$user ;
            $data['notes'] = array_merge($data['notes'], $data['islogin'] ? $this->NoteModel->getNotesByUserIdAndType($id) : array());
            foreach ($data['notes'] as $note) {
                if ($note['target_type'] == 1)
                    $data['note_books'][] = $data['islogin'] ? $this->BookModel->getBookById($note['target_id']):array();
                else if ($note['target_type'] == 2)
                    $data['note_papers'][] = $data['islogin'] ? $this->PaperModel->getPaperByid($note['target_id']) : array();
            }
            $data['comments'] = array_merge($data['comments'], $data['islogin'] ? $this->CommentModel->getCommentsByUserIdAndType($id) : array());
            foreach ($data['comments'] as $tcomment) {
                if ($tcomment['target_type'] == 1)
                    $data['books'][] = $data['islogin'] ? $this->BookModel->getBookByid($tcomment['target_id']) : array();
                else if ($tcomment['target_type'] == 2)
                    $data['papers'][] = $data['islogin'] ? $this->PaperModel->getPaperByid($tcomment['target_id']) : array();
                else if ($tcomment['target_type'] == 3)
                    $data['webpages'][] = $data['islogin'] ? $this->WebpageModel->getWebpageByid($tcomment['target_id']) : array();
            }
        }

        $data["title"] = "My Friends";
        $data["css"][] = "userinfo.css";
        $this->_generate(array("user/friendinfo"), $data);
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