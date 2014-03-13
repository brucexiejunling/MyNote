<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    public function index() {
        $session = $this->session->userdata;
        $data = array();
        $data['islogin'] = isset($session['islogin']) && $session['islogin'];
        $data['user'] = $data['islogin'] ? $this->UserModel->getUserBySession($session) : array();
        $data["title"] = "My Infomation Page";
        $data["css"][] = "userinfo.css";
        $data['js'][] = 'ajaxfileupload.js';
        $data['js'][] = 'userinfo.js';
        $this->_generate(array("user/userinfo"), $data);
    }

    private function _generate($pages=array(), $data=array()) {
        $data["body_content"] = "";
        foreach ($pages as $page) {
            $data["body_content"] .= $this->load->view($page, $data, true);
        }
        $this->load->view("base", $data);
    }

    public function modify_password() {
        $this->form_validation->set_rules('pre_password', 'Password', 'trim|required|max_length[30]|xss_clean');
        $this->form_validation->set_rules('new_password', 'Password', 'trim|required|max_length[30]|xss_clean');
        if ($this->form_validation->run() == false) {
            $result["success"] = false;
            $result["msg"] = "Password not valid";
        } else {
            $user = $this->UserModel->check($this->input->post('email'), $this->input->post('pre_password'));
            if ($user == null) {
                $result["success"] = false;
                $result["msg"] = "password not valid";
            } else {
                if ($this->input->post('new_password') != $this->input->post('new_password_again')) {
                    $result["success"] = false;
                    $result["msg"] = "New password not the same";
                } else {
                    $result["success"] = true;
                    $user = $this->UserModel->modify_password($this->input->post('email'), $this->input->post('pre_password'), $this->input->post('new_password'));
                }
                $result["msg"] = "Success";
                $this->session->set_userdata($user);
                $this->session->set_userdata(array("islogin" => true));
            }
        }
        echo json_encode($result);
    }

    public function modify_nickname() {
        $session = $this->session->userdata;
        $this->form_validation->set_rules('nickname', 'Nickname', 'trim|required|max_length[30]|xss_clean');
        if ($this->form_validation->run() == false) {
            $result["success"] = false;
            $result["msg"] = "Nickname not valid";
        } else if ($this->UserModel->nickname_exist($this->input->post('nickname'))) {
            $result["success"] = false;
            $result["msg"] = "Nickname exist!";
        } else {
            $result["success"] = true;
            $user = $this->UserModel->modify_nickname($session, $this->input->post('nickname'));
            $result["msg"] = $this->load->view("usermanager/topbarstatus", array("islogin" => true, "user" => $user), true);
            $this->session->set_userdata($user);
            $this->session->set_userdata(array("islogin" => true));
        }
        echo json_encode($result);
    }

    public function showuser($uid) {
        $session = $this->session->userdata;
        $data = array();
        $data['islogin'] = isset($session['islogin']) && $session['islogin'];
        $data['is_me'] = isset($session['islogin']) && $session['id'] == $uid;
        $data['user'] = $data['islogin'] ? $this->UserModel->getUserById($uid) : array();
        $data["is_friend"] = $data['islogin'] ? $this->UserModel->is_friend($session['id'], $uid) : array();
        $data["is_group_friend"] = $data['islogin'] ? $this->UserModel->is_group_friend($session['id'], $uid) : array();
        if ($data["is_group_friend"]||$data["is_friend"]||$data['is_me']) {
            $data["notes"] = $this->NoteModel->getNotesByUserIdAndType($uid);
            foreach ($data['notes'] as $note) {
                if ($note['target_type'] == 1)
                    $data['note_books'][] = $data['islogin'] ? $this->UserModel->getBookByid($note['target_id']) : array();
                else if ($note['target_type'] == 2)
                    $data['note_papers'][] = $data['islogin'] ? $this->UserModel->getPaperByid($note['target_id']) : array();
            }
        }
        $data['comments'] = $data['islogin'] ? $this->CommentModel->getCommentsByUserIdAndType($uid) : array();
        foreach ($data['comments'] as $tcomment) {
            if ($tcomment['target_type'] == 1)
                $data['books'][] = $data['islogin'] ? $this->UserModel->getBookByid($tcomment['target_id']) : array();
            else if ($tcomment['target_type'] == 2)
                $data['papers'][] = $data['islogin'] ? $this->UserModel->getPaperByid($tcomment['target_id']) : array();
            else if ($tcomment['target_type'] == 3)
                $data['webpages'][] = $data['islogin'] ? $this->UserModel->getWebpageByid($tcomment['target_id']) : array();
        }
        
        $data["title"] = "My Infomation Page";
        $data["css"][] = "userinfo.css";
        //$this->load->view("user/userinfo", $data);
        $this->_generate(array("user/userinfo_other"), $data);
    }

    public function delete_friend() {
        $session = $this->session->userdata;
        if ($this->UserModel->is_friend($session['id'], $this->input->post('friend_id')) == false) {
            $result["success"] = false;
            $result["msg"] = "Not a Friend";
        } else {
            $result["success"] = true;
            $user = $this->UserModel->delete_friend($session, $this->input->post('friend_id'));
            $result["msg"] = "Deleted";
        }
        echo json_encode($result);
    }

    public function add_friend() {
        $session = $this->session->userdata;
        if ($this->UserModel->is_friend($session['id'], $this->input->post('add_friend_id'))) {
            $result["success"] = false;
            $result["msg"] = "Already a Friend";
        } else {
            $result["success"] = true;
            $this->UserModel->add_friend($session, $this->input->post('add_friend_id'));
            $result["msg"] = "Added";
        }
        echo json_encode($result);
    }

    public function upload_avatar() {
        $session = $this->session->userdata;
        if (!(isset($session['islogin']) && $session['islogin'])) {
            return false;
        }
        $user = $this->UserModel->getUserBySession($session);
        $config['upload_path'] = "./img/avatar";
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2048';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['overwrite'] = true;
        $config['file_name'] = $user['id'];
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload("upload_avatar")) {
            $error = implode(" ", array('error' => $this->upload->display_errors()));
            $msg = '';
        } else {
            $config['image_library'] = 'gd2';
            $config['source_image'] = './img/avatar/' . $this->upload->file_name;
            $config['maintain_ratio'] = true;
            $config['width'] = 150;
            $config['height'] = 100;
            $config['create_thumb'] = false;
            $this->load->library('image_lib', $config);
            if (!$this->image_lib->resize()) {
                $error = 'could not resize the image.';
                $msg = "";
            } else {
                $error = '';
                $msg = base_url("img/avatar") . "/{$this->upload->file_name}";
                $this->UserModel->updateAvatarById($user["id"], $this->upload->file_name);
                $this->session->set_userdata($this->UserModel->getUserById($user["id"]));
            }
        }
        echo json_encode(array("error" => $error, "msg" => $msg));
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */