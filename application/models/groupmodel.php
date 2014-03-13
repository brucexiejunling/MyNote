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
class GroupModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getGroupById($id, $table='groups') {
        $query = $this->db->get_where($table, array('id' => $id), 1);
        return $query->num_rows() > 0 ? $this->toArray($query->row()) : null;
    }

    public function getGroupByName($name, $table='groups') {
        $query = $this->db->get_where($table, array('name' => $name), 1);
        return $query->num_rows() > 0 ? $this->toArray($query->row()) : null;
    }

    public function getGroupMembersById($id, $table='group_members') {
        $this->db->join('groups', 'groups.id = group_members.group_id');
        $this->db->where('groups.id', $id);
        $query = $this->db->get($table);
        $result = array();
        foreach ($query->result() as $row) {
            $result[] = $this->Member_toArray($row);
        }
        return $result;
    }

    public function toArray($result) {
        return array('id' => $result->id, 'name' => $result->name, 'intro' => $result->intro);
    }

    public function Member_toArray($result) {
        return array('id' => $result->id, 'group_id' => $result->group_id, 'user_id' => $result->user_id,
            'user_id' => $result->user_id,);
    }

    public function search($keyword, $table='groups') {
        $this->db->like('name', $keyword);
        $this->db->or_like('intro', $keyword);
        $query = $this->db->get($table);
        return $this->toArrayMul($query);
    }

    public function creatGroup($session, $groupname, $groupintro, $table='groups') {
        $session = $this->session->userdata;
        $query = $this->GroupModel->getGroupByName($groupname);
        $data = array(
            'name' => $groupname,
            'intro' =>$groupintro,
        );
        $this->db->insert($table, $data);
        return  $this->GroupModel->getGroupByName($groupname);
    }
    
    public function getByRandom($number=10, $table='groups'){
        $total = $this->db->count_all($table);
        if($total<=$number){
            return $this->db->get($table)->result_array();
        }else{
            $ids = array();
            while(count($ids)<$number){
                $i = rand(1, $total);
                if(!in_array($i, $ids)){
                    $ids[] = $i;
                }
            }
            $result = array();
            foreach($ids as $id){
                $result[] = $this->getGroupById($id);
            }
        }
        return $result;
    }

    public function toArrayMul($query) {
        $result = array();
        foreach ($query->result() as $group) {
            $result[] = $this->toArray($group);
        }
        return $result;
    }

}

?>
