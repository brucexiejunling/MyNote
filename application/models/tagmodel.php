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
class TagModel extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    
    public function getTagById($id, $table='tags'){
        $query = $this->db->get_where($table, array('id'=>$id), 1);
        return $query->num_rows()>0?$this->toArray($query->row()):null;
    }
    
    public function getTagByName($name, $table='tags'){
        $query = $this->db->get_where($table, array('name'=>$name), 1);
        return $query->num_rows()>0?$this->toArray($query->row()):null;
    }
    
    public function add($name, $table='tags'){
        $this->db->insert($table, array('name'=>$name));
        return $this->getTagById($this->db->insert_id());
    }
    
    public function toArray($result){
    	return array('id'=>$result->id, 'name'=>$result->name);
    }
    
    public function getTagsByTagtargets($tagtargets, $table='tags'){
        $result = array();
        foreach($tagtargets as $tagtarget){
            $query = $this->db->get_where($table, array('id'=>$tagtarget['tag_id']), 1);
            if($query->num_rows>0){
                $tag = $query->row_array();
                $tag['target_id'] = $tagtarget['target_id'];
                $tag['target_type'] = $tagtarget['target_type'];
                $tag['number'] = $this->TagshipModel->count_up($tagtarget['id']);
                $result[] = $tag;
            }
        }
        $numbers = array();
        foreach ($result as $key => $row) {
            $numbers[$key] = $row['number'];
        }   
        array_multisort($numbers, SORT_DESC, $result);
        return $result;
    }
}

?>
