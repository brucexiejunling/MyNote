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
class TagshipModel extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    
    public function getTagshipById($id, $table='tagships'){
        $query = $this->db->get_where($table, array('id'=>$id), 1);
        return $query->num_rows()>0?$this->toArray($query->row()):null;
    }
    
    public function add($tag_target_id, $user_id, $up_or_down=1, $table='tagships'){
        $this->db->insert($table, array("tag_target_id"=>$tag_target_id, "user_id"=>$user_id, "up_or_down"=>$up_or_down));
        return $this->getTagshipById($this->db->insert_id());
    }
    
    public function voted($tag_target_id, $user_id, $table='tagships'){
        $query = $this->db->get_where($table, array('tag_target_id'=>$tag_target_id, 'user_id'=>$user_id), 1);
        return $query->num_rows();
    }
    
    public function count_up($tag_target_id, $table='tagships'){
        $query = $this->db->get_where($table, array('tag_target_id'=>$tag_target_id, 'up_or_down'=>1));
        return $query->num_rows();
    }
    
    public function toArray($result){
    	return array('id'=>$result->id, 'tag_target'=>$result->tag_target_id, 'up_or_down'=>$result->up_or_down,
            'user_id'=>$result->user_id);
    }
}

?>
