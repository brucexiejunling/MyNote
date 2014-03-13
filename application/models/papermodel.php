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
class PaperModel extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    
    public function getPaperById($id, $table='papers'){
        $query = $this->db->get_where($table, array('id'=>$id), 1);
        return $query->num_rows()>0?$this->toArray($query->row_array()):null;
    }
    
    public function getPapersByClassfication( $classfication, $num = 10, $table = 'papers' ){
        $query = $this->db->get_where($table, array('classification' => $classfication), $num);
        return $query->num_rows() > 0 ? $this->toArrayMul($query) : null;
    }
    
    public function getInsertId(){
        return $this->db->insert_id( "papers" );
    }
    
    public function addBook( $data, $table = "papers"){
        $this->db->insert($table, $data);
        return true;
    }
    
    public function getRandomPapers($number=3, $classes=array(), $table='papers'){
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
        $papers = array();
        for($i=0; $i<$number; $i++){
            $papers[] = $this->getPaperById($result_array[rand(1,$total)-1]['id']);
        }
        return $papers;
    }
    
    public function search($keyword, $table='papers'){
        $this->db->like('title', $keyword);
        $query = $this->db->get($table);
        return $this->toArrayMul($query);
    }
    
    public function toArray($result){
    	return array_merge($result, array('type'=>'paper', 'cover'=>'paper_default.png'));
    }
    
    public function getPaperByUserid($uid, $table="papers")
    {
        $query = $this->db->get_where($table, array('uid'=>$uid),1);
    }
    
    public function toArrayMul($query){
        $result = array();
        foreach($query->result_array() as $book){
            $result[] = $this->toArray($book);
        }
        return $result;
    }
    
    public function getPapersInOrder($offset, $number=10, $table='papers'){
        $query = $this->db->get_where($table, array(), $number, $offset);
        return $query->num_rows()==0?array():$this->toArrayMul($query);
    }

    public function deletePaperById($paper_id, $table='papers'){
        $this->db->delete($table, array('id'=>$paper_id), 1);
        return true;
    }
    
    public function getTotal($table='papers'){
        return $this->db->count_all($table);
    }
}

?>
