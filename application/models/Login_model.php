<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_Model extends CI_Model {

	public function admin_auth($username,$pass,$roll){
		$result = false;
		//echo $user = $this->db->escape_str($username);
		$this->db->select(array('id','name','email','mobile','password'));
		$this->db->from('employee');
		$this->db->where('email',$username);
		$this->db->where('roll',$roll);
		$this->db->limit('1');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$res = $query->result();
			$hashedPassword = $res[0]->password;
			$verifypass = $this->general->verifyHashedPassword($pass, $hashedPassword);
			if($verifypass){
				$result = $res;
			}
		}
		return $result;
	}

	public function auth($username,$pass){
		$result = false;
		//echo $user = $this->db->escape_str($username);
		$this->db->select(array('id','name','email','mobile','password'));
		$this->db->from('members');
		$this->db->where('email',$username);
		$this->db->limit('1');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$res = $query->result();
			$hashedPassword = $res[0]->password;
			$verifypass = $this->general->verifyHashedPassword($pass, $hashedPassword);
			if($verifypass){
				$result = $res;
			}
		}
		return $result;	
	}

	public function checkUser($userData = array(),$table){
		if(!empty($userData)){
			//OAuth conditions
			$oauthConditions = array('oauth_provider'=>$userData['oauth_provider'],'oauth_uid'=>$userData['oauth_uid']);
			
			// Check whether user data already exists in database with same oauth info
			$this->db->from($table);
			$this->db->where($oauthConditions);
			$prevRowNum = $this->db->count_all_results();
			
			// Check whether user data already exists in database with same email
			$this->db->from($table);
			$this->db->where("email != '' AND email = '".$userData['email']."'");
			$prevRowNum2 = $this->db->count_all_results();			
			
			if($prevRowNum > 0){
				//add modified date if not included
				if(!array_key_exists("modified", $userData)){
					$userData['update_at'] = date("Y-m-d H:i:s");
				}
				
				//update data
				$update = $this->db->update($table,$userData,$oauthConditions);
			}elseif($prevRowNum2 > 0){
				//add modified date if not included
				
				$conditions = array('email'=>$userData['email']);
				
				//update data
				$update = $this->db->update($table,$userData,$conditions);
			}else{
				//add created, modified and other required date if not included
				
				$userData['status'] = 'Active';
				//insert user data to users table
				$insert = $this->db->insert($table, $userData);
			}
			
			// Get user data from the database
			$query = $this->db->get_where($table, $oauthConditions);
			$userData = $query->row_array();
		}
		
		// Return user data
		return $userData;
	}
	
	public function user_auth($username,$pass){
		$result = false;
		//echo $user = $this->db->escape_str($username);
		$this->db->select(array('uid','full_name','email','mobile','password','gender','zipcode','city_id'));
		$this->db->from('tbl_users');
		$this->db->where('email',$username);
		$this->db->limit('1');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$res = $query->result();
			$hashedPassword = $res[0]->password;
			$verifypass = $this->general->verifyHashedPassword($pass, $hashedPassword);
			if($verifypass){
				$result = $res;
			}
		}
		return $result;	
	}
	
}
?>