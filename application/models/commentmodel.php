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
class CommentModel extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    
    public function getCommentById($id, $table='comments'){
        $query = $this->db->get_where($table, array('id'=>$id), 1);
        return $query->num_rows()>0?$this->toArray($query->row()):null;
    }
    
    public function getCommentsByUserIdAndType($user_id, $type=null, $table='comments'){
        $this->db->order_by("pub_time", "desc");
        $this->db->where(
             $type==null?array('user_id'=>$user_id):array('user_id'=>$user_id, 'target_type'=>$type));
        $query = $this->db->get($table);
        return $this->toArrayMul($query);
    }
    
    public function getCommentsByTarget($target_id, $target_type, $table="comments"){
        $query = $this->db->get_where($table, array('target_id'=>$target_id, 'target_type'=>$target_type));
        return $this->toArrayMul($query);
    }
    
    public function toArray($result){
    	return array('id'=>$result->id, 'user_id'=>$result->user_id,
            'target_type'=>$result->target_type, 'target_id'=>$result->target_id,
            'comment'=>$result->comment, 'pub_time'=>$result->pub_time,
            'mod_time'=>$result->mod_time);
    }
    
    public function addComment( $data, $table = "comments"){
        $this->db->insert($table, $data);
        return true;
    }
    public function deleteComment( $cid, $user,$table = "comments"){
        if($user['privilege']==1)
            $this->db->delete($table, array('id'=>$cid));
        else
            $this->db->delete($table, array('id'=>$cid, 'user_id'=>$user['id']));
        return true;
    }
    public function getInsertId(){
        return $this->db->insert_id( "comments" );
    }
    
    public function toArrayMul($comments){
        $result = array();
        foreach($comments->result() as $comment){
            $result[] = $this->toArray($comment);
        }
        return $result;
    }
    
}

?>
