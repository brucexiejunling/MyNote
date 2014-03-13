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
class WebpageModel extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    
    public function getWebpageById($id, $table='webpages'){
        $query = $this->db->get_where($table, array('id'=>$id), 1);
        return $query->num_rows()>0?$this->toArray($query->row_array()):null;
    }
    
    public function getWebpagesByClassfication( $classfication, $num = 10, $table = 'webpages' ){
        $query = $this->db->get_where($table, array('classification' => $classfication), $num);
        return $query->num_rows() > 0 ? $this->toArrayMul($query) : null;
    }
    
    public function getInsertId(){
        return $this->db->insert_id( "webpages" );
    }
    
    public function addBook( $data, $table = "webpages"){
        $this->db->insert($table, $data);
        return true;
    }
    
    public function getRandomWebpages($number=3, $classes=array(), $table='webpages'){
        if($classes!=array()){
            foreach($classes as $classification){
                $classModel = $this->ClassificationModel->getClassificationByName($classification);
                $this->db->or_where('classification', $classModel['id']);
            }
        }
        $query = $this->db->get($table);
        $result_array = $query->result_array();
        $total = $query->num_rows();
        if($total==0){
            return array();
        }
        $webpages = array();
        for($i=0; $i<$number; $i++){
            $webpages[] = $this->getWebpageById($result_array[rand(1,$total)-1]['id']);
        }
        return $webpages;
    }
    
    public function search($keyword, $table='webpages'){
        $this->db->like('title', $keyword);
        $query = $this->db->get($table);
        return $this->toArrayMul($query);
    }
    
    public function toArray($result){
    	return array_merge($result, array('type'=>'webpage'));
    }
    
    public function toArrayMul($query){
        $result = array();
        foreach($query->result_array() as $webpage){
            $result[] = $this->toArray($webpage);
        }
        return $result;
    }
    
    public function getWebpagesInOrder($offset, $number=10, $table='webpages'){
        $query = $this->db->get_where($table, array(), $number, $offset);
        return $query->num_rows()==0?array():$this->toArrayMul($query);
    }

    public function deleteWebpageById($webpage_id, $table='webpages'){
        $this->db->delete($table, array('id'=>$webpage_id), 1);
        return true;
    }
    
    public function getTotal($table='webpages'){
        return $this->db->count_all($table);
    }

}

?>
