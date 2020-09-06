<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Moms extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->has_userdata('logged_admin_session')){
			redirect('Msa-Login','refresh');
		}
		$this->load->model('datatable_model','dtm');
	}

	public function index($flag = false)
	{
		if ($this->input->is_ajax_request()) {
			$data = array('status' => $flag);
			$html = $this->load->view('admin/moms/list',$data,true);
			$response = array('page' => $html);
			responseJSON($response);
		}else{
            exit('No direct script access allowed');
        }
	}


	public function moms_list($flag = false){
		if ($this->input->is_ajax_request()) {

			$select = array('mid', 'full_name', 'mobile', 'email', 'gender', 'zipcodes', 'status', 'profile_img', 'create_at', 'update_at');

			$column_search = array('full_name', 'mobile', 'email', 'status');

			$column_order = array('create_at', 'full_name', 'mobile');

			$order = array('create_at' => 'desc');
			
			$options = array(
				'table' => 'tbl_moms',
				'select' => $select,
				'column_order' => $column_order, //set column field database for datatable orderable
				'column_search' => $column_search, //set column field database for datatable searchable 
				'order' => $order,
				'limit' => $_POST['length'],
				'offset' => $_POST['start'],
				'where' => (!$flag) ? false : array('status' => $flag)
			);

			$list = $this->dtm->get_datatables($options);
			//echo $this->db->last_query();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $moms) {
				if(isset($_POST['search']['value'])){
					$array_of_words = array($_POST['search']['value']);
					$pattern = '#(?<=^|\C)(' . implode('|', array_map('preg_quote', $array_of_words))
					. ')(?=$|\C)#i';
				}
				$dyn_clss = ($moms->status == 'Active') ? 'btn-success' : 'btn-danger';

				$no++;
				$row = array();
				$row[] = $no;
				$row[] = date('d-m-Y H:i:s',strtotime($moms->create_at));
				$row[] = '<a href="#Moms_menu" class="change_inside_link" 
							data-url = "'.base_url('Msa-moms_menu/'.$moms->mid).'"
							data-bck = "'.$flag.'"
							data-toggle="tooltip" data-placement="top" title="Moms Menu"
							>'. str_highlight($pattern, $moms->full_name).'</a>';
				$row[] = str_highlight($pattern, $moms->mobile); 
				$row[] = str_highlight($pattern, $moms->email);
				$row[] = '<a href = "javascript: void(0)" 
					id="change_status" data-url="'.base_url('Msa-moms_status').'" 
					data-input = "'.$moms->status.'" 
					data-rowid = "'.$moms->mid.'"
					data-tblid = "Moms_table"
					class = "btn '.$dyn_clss.'">'.
					str_highlight($pattern, $moms->status).
					'</a>';
				$row[] = 'Edit';
				$data[] = $row;
			}

			$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->model->record_count('tbl_moms'),
						"recordsFiltered" => $this->dtm->count_filtered($options),
						"data" => $data,
					);
			//output to json format
			echo json_encode($output);
		}else{
            exit('No direct script access allowed');
        }
	}

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

	//-----------moms menu---------
	public function moms_menu($momid = false){
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

	//-----------moms menu list---------
	public function menu_list($momid = false){
		if ($this->input->is_ajax_request()) {

			$select = array('tbl_moms.mid AS momid', 'tbl_moms.full_name AS mom_name', 
				'tbl_items.name AS item_name', 'tbl_items.image', 'tbl_items.category', 
				'tbl_menu.id AS menuid', 'tbl_menu.meal_type', 'tbl_menu.status', 
				'tbl_menu.time_duration', 'tbl_menu.create_at', 'tbl_menu.update_at');

			$column_search = array('tbl_moms.full_name', 'tbl_items.name');

			$column_order = array('tbl_menu.create_at');

			$order = array('tbl_menu.create_at' => 'desc');
			
			$join = array(
				'tbl_moms' => 'tbl_moms.mid = tbl_menu.mom_id',
				'tbl_items' => 'tbl_items.id = tbl_menu.item_id',
			);

			$where = (!$momid) ? false : array('tbl_menu.mom_id' => $momid);
			$options = array(
				'table' => 'tbl_menu',
				'select' => $select,
				'column_order' => $column_order, //set column field database for datatable orderable
				'column_search' => $column_search, //set column field database for datatable searchable 
				'order' => $order,
				'join' => $join,
				'limit' => $_POST['length'],
				'offset' => $_POST['start'],
				'where' => $where
			);

			$list = $this->dtm->get_datatables($options);
			//echo $this->db->last_query();

			$data = array();
			$no = $_POST['start'];
			foreach ($list as $menu) {
				if(isset($_POST['search']['value'])){
					$array_of_words = array($_POST['search']['value']);
					$pattern = '#(?<=^|\C)(' . implode('|', array_map('preg_quote', $array_of_words))
					. ')(?=$|\C)#i';
				}
				$dyn_clss = ($menu->status == 'Active') ? 'btn-success' : 'btn-danger';

				$item_img = '<img src="'.base_url($menu->image).'" class="mx-auto d-block rounded-circle" style="width: 80%;">';
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = date('d-m-Y H:i:s',strtotime($menu->create_at));
				$row[] = str_highlight($pattern, $menu->mom_name);
				$row[] = $item_img;
				$row[] = $menu->meal_type; 
				$row[] = str_highlight($pattern, $menu->item_name);
				$row[] = $menu->category; 
				$row[] = '<a href = "javascript: void(0)" 
					id="change_status" data-url="'.base_url('Msa-menu_status').'" 
					data-input = "'.$menu->status.'" 
					data-rowid = "'.$menu->menuid.'"
					data-tblid = "Menu_table"
					class = "btn '.$dyn_clss.'">'.
					$menu->status.
					'</a>';
				$row[] = $menu->time_duration; 
				$data[] = $row;
			}
			$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->model->record_count('tbl_menu',$where),
						"recordsFiltered" => $this->dtm->count_filtered($options),
						"data" => $data,
					);
			//output to json format
			echo json_encode($output);
		}else{
            exit('No direct script access allowed');
        }
	}
}
