<?php
class Datatable_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query($options) {
        $select = false;  $table = false;
        $join = false; $order = false;
        $limit = false; $offset = false;
        $where = false; $or_where = false;
        $single = false; $where_not_in = false;
        $group_by = false; $total_count = false;
        $column_search = array();
        $column_order = array();

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

        if(!empty($column_search)){
            $i = 0;
    
            foreach ($column_search as $item) // loop column 
            {
                if($_POST['search']['value']) // if datatable send POST for search
                {
                    
                    if($i===0) // first loop
                    {
                        $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                        $this->db->like($item, $_POST['search']['value']);
                    }
                    else
                    {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }

                    if(count($column_search) - 1 == $i) //last loop
                        $this->db->group_end(); //close bracket
                }
                $i++;
            }
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

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        elseif ($order != false) {

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

        if($total_count) {
            return $query->num_rows();
        }
        
        return $query->result();
    }

    function get_datatables($options)
    {
        return $this->_get_datatables_query($options);
        //if($_POST['length'] != -1)
        //$this->db->limit($_POST['length'], $_POST['start']);
    }

    function count_filtered($options)
    {
        $options['limit'] = false;
        $options['offset'] = false;
        $options['total_count'] = true;
        return $this->_get_datatables_query($options);
    }
}
?>