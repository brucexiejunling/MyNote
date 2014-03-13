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
class TypeModel extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    
    public function getTypeById($id, $table='types'){
        $query = $this->db->get_where($table, array('id'=>$id), 1);
        return $query->num_rows()>0?$this->toArray($query->row()):null;
    }
    
    public function getTypeByName($name, $table='types'){
        $query = $this->db->get_where($table, array('type'=>$name), 1);
        return $query->num_rows()>0?$this->toArray($query->row()):null;
    }
    
    public function toArray($result){
    	return array('id'=>$result->id, 'name'=>$result->type);
    }
}

?>
