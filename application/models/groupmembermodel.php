<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usermodel
 *
 * @author cestial
 */
class GroupMemberModel extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    
    public function getGroupMemberById($id, $table='group_members'){
        $query = $this->db->get_where($table, array('id'=>$id), 1);
        return $query->num_rows()>0?$this->toArray($query->row()):null;
    }
    
    public function getGroupMembersByGroupId($group_id, $table='group_members'){
        $this->db->join('users', 'users.id = group_members.user_id');
        $this->db->where('group_id',$group_id);
        $query = $this->db->get($table);
        $result = array();
        foreach ($query->result() as $row) {
            $result[]=$this->UsertoArray($row);
        }
        return $result;
    }
    
    public function getGroupMembersByUserId($user_id, $table='group_members'){
        $query = $this->db->get_where($table, array('user_id'=>$user_id));
        return $this->toArrayMul($query);
    }
    public function isAdmin($session,$gid ,$table='group_members'){
        $query = $this->db->get_where($table, array('group_id'=>$gid, 'privilege'=>1));
        return $session['id']==$query->row()->user_id? true:false;
    }
    public function getGroupAdminByGroupId($group_id, $table='group_members'){
        $query = $this->db->get_where($table, array('group_id'=>$group_id, 'privilege'=>1));
        return $this->UserModel->getUserById($query->row()->user_id);
    }
    
    public function toArray($result){
    	return array('id'=>$result->id, 'group_id'=>$result->group_id, 'user_id'=>$result->user_id,
            'privileges'=>$result->privilege, 'status'=>$result->status ,'invitor_id'=>$result->invitor_id);
    }
    
    public function toArrayMul($group_members){
        $result = array();
        foreach($group_members->result() as $group_member){
            $result[] = $this->toArray($group_member);
        }
        return $result;
    }
    public function UsertoArray($result){
    	return array('id'=>$result->id, 'nickname'=>$result->nickname, 'email'=>$result->email,
            'avatar'=>$result->avatar, 'password'=>$result->password, 'privilege'=>$result->privilege,
            'intro'=>$result->intro, 'reg_time'=>$result->reg_time, 'avatar'=>$result->avatar);
    }
    
    public function getGroupMemberByMemberIdAndGroupId($gid, $mid, $table='group_members'){
        $query = $this->db->get_where($table, array('group_id'=>$gid, 'user_id'=>$mid), 1);
        return $query->num_rows()>0?$this->toArray($query->row()):null;
    }
    
    public function deleteMember($gid, $mid, $table='group_members'){
        $this->db->delete($table, array('group_id'=>$gid, 'user_id'=>$mid));
        return true;
    }
    public function addMember($session,$new_group,$previlege, $table='group_members'){
        $data = array(
            'group_id' => $new_group['id'],
            'user_id' => $session['id'], 
            'privilege' => $previlege, 
        );
        $this->db->insert($table, $data);
        return true;
    }
}

?>
