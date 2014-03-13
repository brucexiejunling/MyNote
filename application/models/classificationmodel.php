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
class ClassificationModel extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    
    public function getClassificationById($id, $table='classifications'){
        $query = $this->db->get_where($table, array('id'=>$id), 1);
        return $query->num_rows()>0?$this->toArray($query->row()):null;
    }
    
    public function getClassificationByName($name, $table='classifications'){
        $query = $this->db->get_where($table, array('classification'=>$name), 1);
        return $query->num_rows()>0?$this->toArray($query->row()):null;
    }
    
    public function getAll($table='classifications'){
        $query = $this->db->get($table);
        return $this->toArrayMul($query);
    }
    
    public function toArrayMul($classifications){
        $result = array();
        foreach($classifications->result() as $classification){
            $result[] = $this->toArray($classification);
        }
        return $result;
    }
    
    public function toArray($result){
    	return array('id'=>$result->id, 'classification'=>$result->classification,
            'intro'=>$result->intro);
    }
}

?>
