<?php

class TagTargetModel extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    
    public function getTagTargetById($id, $table='tag_target'){
        $query = $this->db->get_where($table, array('id'=>$id), 1);
        return $query->num_rows()>0?$this->toArray($query->row()):null;
    }
    
    public function getTagTargetByTargetTypeAndId($target_type, $target_id, $table='tag_target'){
        $query = $this->db->get_where($table, array('target_type'=>$target_type, 'target_id'=>$target_id));
        return $query->result_array();
    }
    
    public function getSpercified($target_type, $target_id, $tag_id, $table='tag_target'){
        $query = $this->db->get_where($table, array('target_type'=>$target_type, 'target_id'=>$target_id, 'tag_id'=>$tag_id), 1);
        return $query->row_array();
    }
    
    public function add($target_type, $target_id, $tag_id, $table='tag_target'){
        $this->db->insert($table, array('target_type'=>$target_type, 'target_id'=>$target_id, 'tag_id'=>$tag_id));
        return $this->getTagTargetById($this->db->insert_id());
    }
    
    public function toArray($result){
    	return array('id'=>$result->id, 'tag_id'=>$result->tag_id, 'target_id'=>$result->target_id,
            'target_type'=>$result->target_type);
    }
}

?>
