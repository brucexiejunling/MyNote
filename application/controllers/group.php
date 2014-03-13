<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Group extends CI_Controller {

    public function index() {
        $session = $this->session->userdata;
        $data = array();
        $data['islogin'] = isset($session['islogin']) && $session['islogin'];
        $data['user'] = $data['islogin'] ? $this->UserModel->getUserBySession($session) : array();
        $data['groups_created'] = $data['islogin'] ? $this->UserModel->get_group_created($session) : array();
        $data['groups_joined'] = $data['islogin'] ? $this->UserModel->get_group_joined($session) : array();
        $data["title"] = "My Groups";
        $data["js"][] = "groupinfo.js";
        $data["css"][] = "userinfo.css";
        $this->_generate(array("user/groupinfo"), $data);
    }

    private function _generate($pages=array(), $data=array()) {
        $data["body_content"] = "";
        foreach ($pages as $page) {
            $data["body_content"] .= $this->load->view($page, $data, true);
        }
        $this->load->view("base", $data);
    }

    public function showgroup($gid) {
        $session = $this->session->userdata;
        $data = array();
        $data['islogin'] = isset($session['islogin']) && $session['islogin'];
        $data['group'] = $data['islogin'] ? $this->GroupModel->getGroupById($gid) : array();
        $data['group_members'] = $data['islogin'] ? $this->GroupMemberModel->getGroupMembersByGroupId($gid) : array();
        $data['is_admin'] = $data['islogin'] ? $this->GroupMemberModel->isAdmin($session, $gid) : array();
        $data['is_in_group'] = $data['islogin'] ? $this->GroupMemberModel->getGroupMemberByMemberIdAndGroupId($gid, $session['id']) : array();
        $data['admin'] = $this->GroupMemberModel->getGroupAdminByGroupId($gid);
        if($data['islogin']){
            $data["title"] = "Group Profile : " . $data['group']['name'] . " Page";
        }
        $data['session'] = $session;
        $data["css"][] = "userinfo.css";
        $data["js"][] = "groupinfo.js";
        $this->_generate(array("user/groupinfo_other"), $data);
    }

    public function joingroup($gid) {
        $session = $this->session->userdata;
        $data = array();
        $data['islogin'] = isset($session['islogin']) && $session['islogin'];
        $group =$data['islogin'] ? $this->GroupModel->getGroupById($gid) : array();
        $in_group = $data['islogin'] ? $this->GroupMemberModel->getGroupMemberByMemberIdAndGroupId($gid, $session['id']) : array();
        if (!$in_group) {
            $this->GroupMemberModel->addMember($session, $group, 0);
        }
        $this->showgroup($gid);
    }
    public function quitgroup($gid) {
        $session = $this->session->userdata;
        $data = array();
        $data['islogin'] = isset($session['islogin']) && $session['islogin'];
        $group =$data['islogin'] ? $this->GroupModel->getGroupById($gid) : array();
        $in_group = $data['islogin'] ? $this->GroupMemberModel->getGroupMemberByMemberIdAndGroupId($gid, $session['id']) : array();
        if ($in_group) {
            $this->GroupMemberModel->deleteMember( $group['id'],$session['id']);
        }
        $this->showgroup($gid);
    }
    public function creat_group() {
        $session = $this->session->userdata;
        $check = $this->GroupModel->getGroupByName($this->input->post('groupname'));
        if ($check != null) {
            $result["success"] = false;
            $result["msg"] = "This group name already exists!";
        } else {
            $result["success"] = true;
            $new_group = $this->GroupModel->creatGroup($session, $this->input->post('groupname'), $this->input->post('groupintro'));
            $this->GroupMemberModel->addMember($session, $new_group, 1);
            $result["msg"] = "<a href='group/showgroup/" . $new_group['id'] . "'>" . $new_group['name'] . "</a>";
        }
        echo json_encode($result);
    }

    public function deletemember($gid) {
        $session = $this->session->userdata;
        $islogin = isset($session['islogin']) && $session['islogin'];
        $group = $islogin ? $this->GroupModel->getGroupById($gid) : array();
        $group_members = $islogin ? $this->GroupMemberModel->getGroupMembersByGroupId($gid) : array();
        $is_admin = $islogin ? $this->GroupMemberModel->isAdmin($session, $gid) : array();
        $result = array();
        $member_id = $this->input->post('member_id');
        if (!$islogin) {
            $result['success'] = false;
            $result['msg'] = 'you havent login';
        } else if (!$is_admin) {
            $result['success'] = false;
            $result['msg'] = 'you are not admin of the group';
        } else {
            $this->GroupMemberModel->deleteMember($group['id'], $member_id);
            $result['success'] = true;
            $result['msg'] = '';
        }
        echo json_encode($result);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */