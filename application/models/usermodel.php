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
class UserModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getUserById($id, $table='users') {
        $query = $this->db->get_where($table, array('id' => $id), 1);
        return $query->num_rows() > 0 ? $this->toArray($query->row()) : null;
    }
    public function getUserNameById($id, $table='users') {
        $query = $this->db->get_where($table, array('id' => $id), 1);
        return $query->num_rows() > 0 ? $query->row()->nickname : null;
    }
    public function getUserByEmail($email, $table='users') {
        $query = $this->db->get_where($table, array('email' => $email), 1);
        return $query->num_rows() > 0 ? $this->toArray($query->row()) : null;
    }

    public function toArray($result) {
        return array('id' => $result->id, 'nickname' => $result->nickname, 'email' => $result->email,
            'avatar' => $result->avatar, 'password' => $result->password, 'privilege' => $result->privilege,
            'intro' => $result->intro, 'reg_time' => $result->reg_time, 'avatar' => $result->avatar);
    }

    public function Friends_toArray($result) {
        return array('user_id' => $result->user_id, 'follower_id' => $result->follower_id);
    }

    public function Groups_toArray($result) {
        return array('id' => $result->id, 'name' => $result->name, 'intro' => $result->intro);
    }
    
    public function Comments_toArray($result){
        return array('id'=>$result->id,'user_id'=>$result->user_id,'comment'=>$result->comment,
                      'target_type'=>$result->target_type,'target_id'=>$result->target_id,'pub_time'=>$result->pub_time);
    }
    
    public function Books_toArray( $result ){
        return array('id'=>$result->id,'name'=>$result->name,'cover'=>$result->cover);
    }

    public function Paper_toArray($result){
        return array('id'=>$result->id,'title'=>$result->title,'authors'=>$result->authors,
                'image'=>$result->image);
    }

    public function Webpage_toArray($result){
        return array('id'=>$result->id,'url'=>$result->url,'title'=>$result->title,'image'=>$result->image);
    }
    
    public function Notes_toArray($result){
        return array('id'=>$result->id,'user_id'=>$result->user_id,'target_type'=>$result->target_type,
                      'target_id'=>$result->target_id,'page_num'=>$result->page_num,'pub_time'=>$result->pub_time,
            'note'=>$result->note);
    }
    
    public function getUserBySession($session, $table='users'){
        return $this->getUserById($session['id']);
    }

    public function check($email, $password, $table='users') {
        $query = $this->db->get_where($table, array('email' => $email, 'password' => sha1($password)), 1);
        return $query->num_rows() > 0 ? $this->toArray($query->row()) : null;
    }

    public function check_new($email, $nickname, $password, $table='users') {
        $this->db->where('email', $email);
        $this->db->or_where('nickname', $nickname);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0)
            return null;
        $pub_time = $mod_time = date("Y-m-d H:i:s");
        $data = array(
            'email' => $email,
            'nickname' => $nickname,
            'password' =>sha1( $password),
            'reg_time'=>$pub_time
        );
        $this->db->insert($table, $data);
        $this->db->where('email', $email);
        $this->db->or_where('nickname', $nickname);
        $query = $this->db->get($table);
        return $query->num_rows() > 0 ? $this->toArray($query->row()) : null;
    }

    public function modify_password($email, $pre_password, $new_password, $table='users') {
        $this->db->where('email', $email);
        $query = $this->db->update($table, array('password' => sha1($new_password)));
        $query = $this->db->get_where($table, array('email' => $email, 'password' => sha1($new_password)), 1);
        return $query->num_rows() > 0 ? $this->toArray($query->row()) : null;
    }

    public function modify_avatar($email, $new_avatar, $table='users') {
        $this->db->where('email', $email);
        $query = $this->db->update($table, array('avatar' => $new_avatar));
        $query = $this->db->get_where($table, array('email' => $email), 1);
        return $query->num_rows() > 0 ? $this->toArray($query->row()) : null;
    }

    public function modify_nickname($session, $new_nickname, $table='users') {
        $this->db->where('id', $session['id']);
        $query = $this->db->update($table, array('nickname' => $new_nickname));
        $query = $this->db->get_where($table, array('id' => $session['id']), 1);
        return $query->num_rows() > 0 ? $this->toArray($query->row()) : null;
    }

    public function nickname_exist($new_nickname, $table='users') {
        ;
        $query = $this->db->get_where($table, array('nickname' => $new_nickname), 1);
        return $query->num_rows() > 0 ? true : false;
    }

    public function get_friends($session, $table='followships') {
        $uid = $this->getUserById($session['id']);
        $this->db->where('user_id', $uid['id']);
        $this->db->or_where('follower_id', $uid['id']);
        $query = $this->db->get($table);
        $result = array();
        foreach ($query->result() as $row) {
            $result[] = $this->Friends_toArray($row);
        }
        return $result;
    }

    public function delete_friend($session, $friend_id, $table='followships') {
        $query1 = $this->db->get_where($table, array('user_id' => $session['id'], 'follower_id' => $friend_id));
        $query2 = $this->db->get_where($table, array('user_id' => $friend_id, 'follower_id' => $session['id']));
        if ($query1->num_rows() > 0)
            $this->db->delete($table, array('user_id' => $session['id'], 'follower_id' => $friend_id));
        else if ($query2->num_rows() > 0)
            $this->db->delete($table, array('user_id' => $friend_id, 'follower_id' => $session['id']));
        return $query1->num_rows() > 0 || $query1->num_rows() > 0;
    }

    public function add_friend($session, $friend_id, $table='followships') {
        $data = array(
            'user_id' => $session['id'],
            'follower_id' => $friend_id,
        );
        $this->db->insert($table, $data);
        return true;
    }

    public function get_group_created($session, $table='group_members') {
        $this->db->join('groups', 'groups.id = group_members.group_id');
        $this->db->where('user_id', $session['id']);
        $this->db->where('privilege', 1);
        $query = $this->db->get($table);
        $result = array();
        foreach ($query->result() as $row) {
            $result[] = $this->Groups_toArray($row);
        }
        return $result;
    }

    public function get_group_joined($session, $table='group_members') {
        $this->db->join('groups', 'groups.id = group_members.group_id');
        $this->db->where('user_id', $session['id']);
        $this->db->where('privilege', 0);
        $query = $this->db->get($table);
        $result = array();
        foreach ($query->result() as $row) {
            $result[] = $this->Groups_toArray($row);
        }
        return $result;
    }
    
    public function get_comments($session,$table='comments'){
        $this->db->where('user_id',$session['id']);
        $query = $this->db->get($table);
        $result = array();
        foreach ($query->result() as $row) {
            $result[]=$this->Comments_toArray($row);
        } 
        return $result;
    }
    
    public function get_notes($session,$table='notes'){
        $this->db->where('user_id',$session['id']);
        $query = $this->db->get($table);
        $result = array();
        foreach ($query->result() as $row) {
            $result[]=$this->Notes_toArray($row);
        } 
        return $result;
    }
    
    public function getBookByid($bid,$table='books'){
        $this->db->where('id',$bid);
        $query = $this->db->get($table);
        return $query->num_rows() > 0 ? $this->Books_toArray($query->row()) : null;
        
    }
    
    public function getPaperByid($pid,$table='papers'){
        $this->db->where('id',$pid);
        $query = $this->db->get($table);
        return $query->num_rows() > 0 ? $this->Paper_toArray($query->row()) : null;
    }
    
    public function getWebpageByid($wid,$table='webpages'){
        $this->db->where('id',$wid);
        $query = $this->db->get($table);
        return $query->num_rows() > 0 ? $this->Webpage_toArray($query->row()) : null;
    }
    
    public function is_friend( $uid1, $uid2, $table = "followships" ){
        $query1 = $this->db->get_where($table,array('user_id'=>$uid1, 'follower_id'=>$uid2));
        $query2 = $this->db->get_where($table,array('user_id'=>$uid2, 'follower_id'=>$uid1));
        return $query1->num_rows()>0 || $query2->num_rows()>0;
    }

    public function is_group_friend($uid1, $uid2, $table = "group_members") {
        $query1 = $this->db->get_where($table, array('user_id' => $uid1));
        $query2 = $this->db->get_where($table, array('user_id' => $uid2));
        if ($query1->num_rows() == 0 || $query1->num_rows() == 0)
            return false;
        foreach ($query1->result_array() as $row1) {
            foreach ($query2->result_array() as $row2) {
                if ($row1["group_id"] == $row2["group_id"]) {
                    return true;
                }
            }
        }
        return false;
    }

    public function search($keyword, $table='users') {
        $this->db->like('nickname', $keyword);
        $this->db->or_like('email', $keyword);
        $query = $this->db->get($table);
        return $this->toArrayMul($query);
    }

    public function toArrayMul($query) {
        $result = array();
        foreach ($query->result() as $user) {
            $result[] = $this->toArray($user);
        }
        return $result;
    }

    public function updateAvatarById($id, $avatar, $table="users") {
        $this->db->update($table, array("avatar" => $avatar), array("id" => $id));
    }
    
    public function getUsersInOrder($offset, $number=10, $table='users'){
        $query = $this->db->get_where($table, array(), $number, $offset);
        return $query->num_rows()==0?array():$this->toArrayMul($query);
    }

    public function deleteUserById($user_id, $table='users'){
        $this->db->delete($table, array('id'=>$user_id), 1);
        return true;
    }
    
    public function getTotal($table='users'){
        return $this->db->count_all($table);
    }
}

?>
