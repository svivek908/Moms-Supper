<?php 
Class Model extends Ms_Model{

  //Update record with existing record in codeigniter
    public function exiting_update($id){
      $this->db->where("NOT FIND_IN_SET($id,`uids`)!=",0);
      $this->db->set('uids', 'CONCAT(uids,\',\',\''.$id.'\')', FALSE);
      $this->db->update('test');
    }
  //================get unic data=========
  
}
?>