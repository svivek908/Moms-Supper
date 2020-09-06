<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_items extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->has_userdata('logged_admin_session')){
			redirect('Msa-Login','refresh');
		}
		$this->load->model('datatable_model','dtm');
	}

	public function index()
	{
		if ($this->input->is_ajax_request()) {
			$data = array();
			$html = $this->load->view('admin/items/list',$data,true);
			$response = array('page' => $html);
			responseJSON($response);
		}else{
            exit('No direct script access allowed');
        }
	}

	//-----------Item list---------
	public function item_list($momid = false){
		if ($this->input->is_ajax_request()) {

			$select = array('id', 'name', 'image', 'category', 'status', 'create_at');

			$column_search = array('name');

			$column_order = array('name', 'category', 'status');

			$order = array('create_at' => 'desc');

			//$where = (!$momid) ? false : array('tbl_menu.mom_id' => $momid);
			$options = array(
				'table' => 'tbl_items',
				'select' => $select,
				'column_order' => $column_order, //set column field database for datatable orderable
				'column_search' => $column_search, //set column field database for datatable searchable 
				'order' => $order,
				'limit' => $_POST['length'],
				'offset' => $_POST['start'],
			);

			$list = $this->dtm->get_datatables($options);
			//echo $this->db->last_query();

			$data = array();
			$no = $_POST['start'];
			foreach ($list as $item) {
				if(isset($_POST['search']['value'])){
					$array_of_words = array($_POST['search']['value']);
					$pattern = '#(?<=^|\C)(' . implode('|', array_map('preg_quote', $array_of_words))
					. ')(?=$|\C)#i';
				}
				$dyn_clss = ($item->status == 'Active') ? 'btn-success' : 'btn-danger';

				$item_img = '<img src="'.base_url($item->image).'" class="mx-auto d-block rounded-circle" style="width: 80%;">';
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = date('d-m-Y H:i:s',strtotime($item->create_at));
				$row[] = $item_img;
				$row[] = str_highlight($pattern, $item->name);
				$row[] = $item->category; 
				$row[] = '<a href = "javascript: void(0)" 
					id="change_status" data-url="'.base_url('Msa-menu_status').'" 
					data-input = "'.$item->status.'" 
					data-rowid = "'.$item->id.'"
					data-tblid = "Item_table"
					class = "btn '.$dyn_clss.'">'.
					$item->status.
					'</a>';
				$row[] = 'Edit'; 
				$data[] = $row;
			}
			$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->model->record_count('tbl_items'),
						"recordsFiltered" => $this->dtm->count_filtered($options),
						"data" => $data,
					);
			//output to json format
			echo json_encode($output);
		}else{
            exit('No direct script access allowed');
        }
	}
	
	//----------Change status-----------
	public function change_status(){
		if ($this->input->is_ajax_request()) {
			$response = array('success' => false, 'message' => 'Something wrong try after some time');
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			$data = array(
				'status' => ($status == 'Active') ? 'Inactive' : 'Active'
			);
			$where = array('mid' => $id);
			$result = $this->model->update('tbl_moms',$data,$where);
			if($result){
				$response['success'] = true;
				$response['message'] = 'Record successfully updated';
			}
			responseJSON($response);
		}else{
            exit('No direct script access allowed');
        }
	}

	//-----------Add Item---------
	public function open_page($action){
		if ($this->input->is_ajax_request()) {
			if($action == 'add'){
				$html = $this->load->view('admin/items/add','',true);
			}else{
				$html = $this->load->view('admin/items/edit',$data,true);
			}
			$response = array('page' => $html);
			responseJSON($response);
		}else{
            exit('No direct script access allowed');
        }
	}

	//-----------Edit Item---------
	public function edit_item($momid = false){
		if ($this->input->is_ajax_request()) {
			$data = array('momid' => $momid,
				'back_url' => $this->input->post('backurl')
			);
			$html = $this->load->view('admin/menu/list',$data,true);
			$response = array('page' => $html);
			responseJSON($response);
		}else{
            exit('No direct script access allowed');
        }
	}
}
