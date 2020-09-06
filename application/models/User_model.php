<?php
class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_moms($tbl,$data){
        $this->db->select('*');
        $this->db->where($data);
        $query= $this->db->get($tbl); 
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }  
    }
    public function getcartitem($mom_id){
        $this->db->select("tbl_thali.thali_name,tbl_thali.thali_image,tbl_thali.food_type,tbl_thali.food_category,cart_item.item_id,cart_item.mid,cart_item.item_quty,cart_item.price,cart_item.tax");
        $this->db->from('cart_item');
        $this->db->join('tbl_thali', 'tbl_thali.id = cart_item.item_id','Left');
        $this->db->where('cart_item.mid',$mom_id);
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
    public function getcartsubtotal(){
        $this->db->select('round (sum(`price`*`item_quty`),2) as subtotal');
        $this->db->from('cart_item');
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
    public function getcartitems($where){
        $this->db->select('*');
        $this->db->from('cart_item');
        $this->db->where($where);
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
    public function getorderitems($where){
        $this->db->select('tbl_thali.thali_name,tbl_thali.thali_image,tbl_thali.food_type,tbl_thali.food_category,tbl_thali.days,tbl_thali.price,ordered_item.item_quty,ordered_item.tax,order_table.order_id');
        $this->db->from('order_table');
        $this->db->join('ordered_item','ordered_item.order_id=order_table.order_id','left');
        $this->db->join('tbl_thali','tbl_thali.id=ordered_item.item_id','left');
        $this->db->where('order_table.order_id',$where);
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
    public function getorders($where){
        $this->db->select('tbl_thali.thali_name,tbl_thali.thali_image,tbl_thali.food_type,tbl_thali.food_category,tbl_thali.days,tbl_thali.price,ordered_item.item_quty,order_table.order_id,order_table.date_time');
        $this->db->from('order_table');
        $this->db->join('ordered_item','ordered_item.order_id=order_table.order_id','left');
        $this->db->join('tbl_thali','tbl_thali.id=ordered_item.item_id','left');
        $this->db->where('order_table.user_id',$where);
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
    public function get_row($table_name='', $where=''){
        if($where!=''){    
            $this->db->where($where);
        }
        $query=$this->db->get($table_name);
        if($query->num_rows()>0)
            return $query->result_array();
        else
            return FALSE;
    }
    
}
?>