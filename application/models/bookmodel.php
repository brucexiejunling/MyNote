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
class BookModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getBookById($id, $table='books') {
        $query = $this->db->get_where($table, array('id' => $id), 1);
        return $query->num_rows() > 0 ? $this->toArray($query->row_array()) : null;
    }
    public function getBooksByClassfication( $classfication, $num=10, $table = 'books' ){
        $query = $this->db->get_where($table, array('classification' => $classfication), $num);
        return $query->num_rows() > 0 ? $this->toArrayMul($query) : null;
    }
    
    public function getInsertId(){
        return $this->db->insert_id( "books" );
    }
    
    public function addBook( $data, $table = "books"){
        $this->db->insert($table, $data);
        return true;
    }
    
    public function getRandomBooks($number=12, $classIds=array(), $table='books') {
        foreach ($classIds as $id) {
            $this->db->or_where('classification', $id);
        }
        $query = $this->db->get($table);
        $result_array = $query->result_array();
        $total = $query->num_rows();
        if ($total == 0) {
            return array();
        }
        $books = array();
        for ($i = 0; $i < $number; $i++) {
            $books[] = $this->getBookById($result_array[rand(1, $total) - 1]['id']);
        }
        return $books;
    }
    
    public function search($keyword, $table='books'){
        $this->db->like('name', $keyword);
        $query = $this->db->get($table);
        return $this->toArrayMul($query);
    }
    
    public function toArrayMul($query){
        $result = array();
        foreach($query->result_array() as $book){
            $result[] = $this->toArray($book);
        }
        return $result;
    }

    public function toArray($result) {
        return array_merge($result, array('type' => 'book'));
    }
    public function UsertoArray($result,$uid,$name) {
        return array_merge($result, array('type' => 'book','userid'=>$uid,'nickname'=>$name));
    }
    
    public function getBooksInOrder($offset, $number=10, $table='books'){
        $query = $this->db->get_where($table, array(), $number, $offset);
        return $query->num_rows()==0?array():$this->toArrayMul($query);
    }

    public function deleteBookById($book_id, $table='books'){
        $this->db->delete($table, array('id'=>$book_id), 1);
        return true;
    }
    
    public function getTotal($table='books'){
        return $this->db->count_all($table);
    }
}

?>
