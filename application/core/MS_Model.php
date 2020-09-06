<?php
Class MS_model extends CI_Model
{
    /*********Insert data in to table*********/
    function add($table,$data)
    {
        $this->db->insert($table, $data);
        //echo $this->db->last_query(); die();
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    /*********Insert data in to table*********/
    function batch_insert($table,$data)
    {
        $this->db->insert_batch($table, $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }
    /*********Insert End*********/

    /*********Update data in to table*********/
    function update($table,$data,$where)
    {
        $this->db->where($where);
        return $this->db->update($table,$data);
    }

    /*************get row***************/
    public function get_row($table_name='', $where=''){
        if($where!=''){    
            $this->db->where($where);
        }
        $query=$this->db->get($table_name);
        if($query->num_rows()>0)
            return $query->row_array();
        else
            return FALSE;
    }
    
    /*********Delete Data form table*********/
    function delete($table,$where)
    {
        if( $this->db->delete($table,$where) )
        {
            return "deleted";
        }
        else
        {
            return false;
        }
    }

    /***********count data************/
    public function record_count($table, $where =false)
    {
        if($where != false){
            $this->db->where($where);
        }
        //return $this->db->count_all($table);
        return $this->db->count_all_results($table);
    }

    public function get_records($options) {
        $select = false;  $table = false;
        $join = false; $order = false;
        $limit = false; $offset = false;
        $where = false; $or_where = false;
        $single = false; $where_not_in = false;
        $like = false; $group_by = false;

        extract($options);

        if ($select != false)
            $this->db->select($select);

        if ($table != false)
            $this->db->from($table);

        if ($where != false)
            $this->db->where($where);

        if ($where_not_in != false) {
            foreach ($where_not_in as $key => $value) {
                if (count($value) > 0)
                    $this->db->where_not_in($key, $value);
            }
        }

        if ($like != false) {
            $this->db->like($like);
        }

        if ($or_where != false)
            $this->db->or_where($or_where);

        if ($limit != false) {

            if ($limit!=false && $offset!=false) {
                $this->db->limit($limit,$offset);
            }
            elseif (!is_array($limit)) {
                $this->db->limit($limit);
            } else {
                foreach ($limit as $limitval => $offset) {
                    $this->db->limit($limitval, $offset);
                }
            }
        }


        if ($order != false) {

            if (is_array($order)) {
                foreach ($order as $key => $value) {
                    if (is_array($value)) {
                        foreach ($order as $orderby => $orderval) {
                            $this->db->order_by($orderby, $orderval);
                        }
                    } else {
                        $this->db->order_by($key, $value);
                    }
                }
            }else {
                $this->db->order_by($order);
            }
        }

        if ($join != false) {

            foreach ($join as $key => $value) {

                if (is_array($value)) {

                    if (count($value) == 3) {
                        $this->db->join($value[0], $value[1], $value[2]);
                    } else {
                        foreach ($value as $key1 => $value1) {
                            $this->db->join($key1, $value1);
                        }
                    }
                } else {
                    $this->db->join($key, $value);
                }
            }
        }

        if ($group_by != false){
            $this->db->group_by($group_by);
        }

        $query = $this->db->get();

        if($single) {
            return $query->row();
        }
        
        return $query->result();
    }
    public function fetch_data($tbl)  
      {  
         //data is retrive from this query 
		$this->db->select('*');
		//$this->db->where('$arr');
		$query= $this->db->get($tbl); 
		return $query->result(); 
      } 
    public function isEmailExist($data){
        // Query to check whether username already exist or not
        $condition = "email =" . "'" . $data['email'] . "'";
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }        
    }
    public function isEmailExists($data){
        // Query to check whether username already exist or not
        $condition = "email =" . "'" . $data['email'] . "'";
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return null;
        }        
    }
    public function ismobileExist($data){
        // Query to check whether username already exist or not
        $condition = "mobile =" . "'" . $data['mobile'] . "'";
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }        
    }
    function get_selected_data($info,$table,$where='',$order='',$type='',$limit='',$start='')
    {
        $this->db->select($info);
        $this->db->from($table);
        if($where!='')
        {
            $this->db->where($where);
        }
        if($order!='' && $type!='')
        {
          $this->db->order_by($order,$type);
        }
        if($limit!='' && $start!='')
        {
          $this->db->limit($limit,$start);
        }
        if($limit!='')
        {
          $this->db->limit($limit);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) 
        {
            return $query->result_array();
        }
        else 
        {
            return array();
        }
    }

    public function moms_menu_list($meal_type){
        $this->db->select('tbl_moms.mid,tbl_moms.kitchen_type,tbl_moms.full_name,tbl_moms.moms_image,tbl_moms.kitchen_name,tbl_food_type.food_type,moms_rating.rating');
        $this->db->from('tbl_moms');
        $this->db->join('tbl_food_type', 'tbl_food_type.mom_id = tbl_moms.mid');
        $this->db->join('moms_rating', 'moms_rating.mom_id = tbl_moms.mid','left');
        $this->db->where('tbl_food_type.food_type',$meal_type);
        $query = $this->db->get();
        if($query->num_rows() != 0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }

    }
    public function get_menu_list($table_name='', $where=''){
        $response['moms_list'] = array();
        if($where!=''){    
            $this->db->where($where);
        }
        $query=$this->db->get($table_name);
        $array = array();

            foreach($query->result() as $row)
            {
                $array[] = $row; // add each user id to the array
            }

            return $array;
        }

     // public function updateorderitem($order_id,$userid,$mom_id){

     // }   
}

?>