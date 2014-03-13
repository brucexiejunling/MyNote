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
class FollowshipModel extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    
    public function getFollowshipById($id, $table='followships'){
        $query = $this->db->get_where($table, array('id'=>$id), 1);
        return $query->num_rows()>0?$this->toArray($query->row()):null;
    }
    
    public function getFollowshipsByUserId($user_id, $table='followships'){
        $query = $this->db->get_where($table, array('user_id'=>$user_id));
        return $this->toArrayMul($query);
    }
    
    public function getFollowshipsByFollowerId($follower_id, $table='followships'){
        $query = $this->db->get_where($table, array('follower_id'=>$follower_id));
        return $this->toArrayMul($query);
    }
    
    public function toArray($followship){
    	return array('id'=>$result->id, 'user_id'=>$result->classification,
            'follower_id'=>$result->intro, 'status'=>$result->status);
    }
    
    public function toArrayMul($followships){
        $result = array();
        foreach($followships->result() as $followship){
            $result[] = $this->toArray($followship);
        }
        return $result;
    }
}

?>
