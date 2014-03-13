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
class NoteModel extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    
    public function getNoteById($id, $table='notes'){
        $query = $this->db->get_where($table, array('id'=>$id), 1);
        return $query->num_rows()>0?$this->toArray($query->row()):null;
    }
    
    public function getInsertId(){
        return $this->db->insert_id( "notes" );
    }
    
    public function addNotes( $data, $table = "notes"){
        $this->db->insert($table, $data);
        return true;
    }
    
    public function getNotesByUserIdAndType($user_id, $type=null, $table='notes'){
        $this->db->order_by("pub_time", "desc");
        $this->db->where(
             $type==null?array('user_id'=>$user_id):array('user_id'=>$user_id, 'target_type'=>$type));
        $query = $this->db->get($table);
        return $this->toArrayMul($query);
    }
    
    public function getNotesByTarget($target_id, $target_type, $table="notes"){
        $query = $this->db->get_where($table, array('target_id'=>$target_id, 'target_type'=>$target_type));
        return $this->toArrayMul($query);
    }
    public function deleteNote( $nid, $user,$table = "notes"){
        if($user['privilege']==1)
            $this->db->delete($table, array('id'=>$nid));
        else
            $this->db->delete($table, array('id'=>$nid, 'user_id'=>$user['id']));
        return true;
    }
    public function toArray($result){
    	return array('id'=>$result->id, 'user_id'=>$result->user_id,
            'target_type'=>$result->target_type, 'target_id'=>$result->target_id,
            'note'=>$result->note, 'pub_time'=>$result->pub_time,
            'mod_time'=>$result->mod_time, 'page_num'=>$result->page_num,
            'for_pub'=>$result->for_pub, 'for_group'=>$result->for_group,
            'for_follower'=>$result->for_follower);
    }
    
    public function toArrayMul($notes){
        $result = array();
        foreach($notes->result() as $note){
            $result[] = $this->toArray($note);
        }
        return $result;
    }
}

?>
