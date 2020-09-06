<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_api extends CI_Controller {
    private $userid;
    function __construct(){
        parent::__construct();
            $api_key  = $this->input->get_request_header('Authorization');
            if(isset($api_key) && $api_key!=''){
                if(!$this->isValidApiKey($api_key)){
                    responseJSON(array("error" =>true, "message" => "Access Denied. Invalid Api key"));
                    return false;
                }
            }
            $this->load->helper('mail');
            $this->load->helper('sms');
            // $this->load->library('payment');
            // $this->load->model('Cart_item','Cart_model');
             $this->load->model('Ms_Model','Mobile');
             $this->load->model('User_model');
             $this->load->model('login_model');
             $this->load->library('upload');
    }

    private function isValidApiKey($api_key){
        $this->userid = getuserid('tbl_users',$api_key);
        return $this->userid;
    }

    private function hash_password($password){
        return password_hash($password, PASSWORD_BCRYPT);
     }
    public function registration(){
        $json=file_get_contents('php://input');
        $data=json_decode($json,true);
            $full_name = html_escape($data['fullname']);
            $email = $data['email'];
            $password = $data['password'];
            $mobile = $data['mobile'];
            $country = $data['countryid'];
            $city = $data['cityid'];
            $zipcode = $data['zipcode'];
            if(empty($full_name)){$response['message'] = "Please Insert full name";echo json_encode($response);exit;}
            if(empty($email)){$response['message'] = "Please Insert email";echo json_encode($response);exit;}
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {$response['message'] = "Please Insert Valid Email";echo json_encode($response);exit;}
            if($this->model->isEmailExist(array('email'=>$email))){$response['message'] = "Email Already Exist";echo json_encode($response);exit;}
            if(empty($password)){$response['message'] = "Please Insert password";echo json_encode($response);exit;}
            if(empty($mobile)){$response['message'] = "Please Insert  mobile";echo json_encode($response);exit;}
            if($this->model->ismobileExist(array('mobile'=>$mobile))){$response['message'] = "mobile number Already Exist";echo json_encode($response);exit;}
            if(empty($country)){$response['message'] = "Please Insert  country id";echo json_encode($response);exit;}
            if(empty($city)){$response['message'] = "Please Insert cityid";echo json_encode($response);exit;}
            if(empty($zipcode)){$response['message'] = "Please Insert pincode";echo json_encode($response);exit;}

            $data = array(
                "full_name" => $full_name,
                "email" => $email,
                "password" => password_hash($password, PASSWORD_DEFAULT),
                "mobile" => $mobile,
                "country_id"=> $country,
                "city_id" => $city,
                "zipcode" => $zipcode,
                "api_key" => generateApiKey(),
                );
               
            $create_user = $this->model->add('tbl_users',$data); 
            if($create_user){
                $response["error"]               = false;
                $response["message"]             = "User Successfully Registered"; 
            }else{
                $response["error"]               = false;
                $response["message"]             = "User Registered failed"; 
            }
        responseJSON($response);
    }

    public function login_user(){
        $json=file_get_contents('php://input');
        $data=json_decode($json,true);
        $response['error'] = true;
        $response['message'] = "Please try it again later";
        $response['data'] = array();
        $email = $data['email'];
        $password = $data['password'];
        $divicetype = $data['divicetype'];
        $deviceid = $data['deviceid'];
        if(empty($email)){$response['message'] = "Please Insert email";echo json_encode($response);exit;}
        if(empty($password)){$response['message'] = "Please Insert password";echo json_encode($response);exit;}
        if(empty($divicetype)){$response['message'] = "Please Insert divicetype";echo json_encode($response);exit;}
        if(empty($deviceid)){$response['message'] = "Please Insert device id";echo json_encode($response);exit;}
        $res = $this->login_model->user_auth($email,$password);
            if ($res != NULL) {
                $userid = $res[0]->uid;
                $checkgcmid = $this->model->get_row('tbl_usergcm',array('divicetype' => $divicetype,'user_id' => $userid,'gcm_id' => $deviceid));
                    if(empty($checkgcmid)){
                        $this->model->add('tbl_usergcm',array('divicetype' => $divicetype,'user_id' => $userid,'gcm_id' => $deviceid));
                    }
                       $response["error"] = false;
                       $response['data'] = $res;
                       $response['message'] = "Welcome To Mom Supper";     
                       
            }else{
                $response["error"] = true;
                $response['message'] = "login failed";
            }
        
        responseJSON($response);
    }

    public function forgot_password(){
        $json=file_get_contents('php://input');
        $data=json_decode($json,true);
        $email=$data['email'];
        $response = array();
        $response["error"] = true;
        if(empty($email)){$response['message'] = "Please Insert email or phone number";echo json_encode($response);exit;}
        $subject = 'Welcome to the MOM SUPPER family';
        $otp = rand(100000, 999999);
        $message = "Your one time password is ". $otp ." for MOM SUPPER forgot password.";
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
           // echo "email---".$email;
           //$result= $this->model->isEmailExists(array('email'=>$email));
           
           //print_r($result);die;
           if($this->model->isEmailExists(array('email'=>$email))!=true){
            
            if(send_mail($email,$subject,$message)){
                $this->model->update('tbl_users',array('forgot_pass_otp'=>$otp),array('email'=>$email));
                $response["error"] = false;
                $response['message'] = "Mail send successfully";
            }else{
                $response["error"] = true;
                $response['message'] = "Mail dont't send!";
            }
           }else{
            $response["error"] = true;
            $response['message'] = "Mail dont't send!";
           }
           
        }elseif(filter_var($email, FILTER_VALIDATE_INT)){
           // echo "int----".$email;
            if(send_sms($email,$message)){
                $this->model->update('tbl_users',array('forgot_pass_otp'=>$otp),array('mobile'=>$email));
                $response["error"] = false;
                $response['message'] = "Sms send successfully"; 
            }else{
                $response["error"] = true;
                $response['message'] = "Sms dont't send!";
            }
        }else{
            $response["error"] = true;
            $response['message'] = "Please provide valid details!";
        }
        responseJSON($response);
    }

    public function get_forgot_otp(){
        $json=file_get_contents('php://input');
        $data=json_decode($json,true);
        $email=$data['email'];
        $forgot_otp =$data['forgot_otp'];
        if(empty($forgot_otp)){$response['message'] = "Please Insert OTP";echo json_encode($response);exit;}
        
        $response=array();
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $result=$this->model->get_row('tbl_users',array('email'=>$email));
            if($forgot_otp===$result['forgot_pass_otp'])
            {
                $response["error"] = false;
                $response['message'] = "OTP match successfully";  
            }else{
                $response["error"] = false;
                $response['message'] = "OTP don't match";
            }

        }elseif(filter_var($email, FILTER_VALIDATE_INT)){
            $result=$this->model->get_row('tbl_users',array('mobile'=>$email));
            if($forgot_otp===$result['forgot_pass_otp'])
            {
                $response["error"] = false;
                $response['message'] = "OTP match successfully";  
            }else{
                $response["error"] = false;
                $response['message'] = "OTP don't match";
            }
        }else{
            $response["error"] = true;
            $response['message'] = "Please provide valid details!";
        }

        responseJSON($response);
    }

    public function newpass(){
        $json=file_get_contents('php://input');
        $data=json_decode($json,true);
        $email= $data['email'];
        $newpassword= password_hash($data['newpassword'], PASSWORD_DEFAULT);
        $response=array();
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $result=$this->model->update('tbl_users',array('password'=>$newpassword),array('email'=>$email));
            if($result)
            {
                $response["error"] = false;
                $response['message'] = "Password change successfully";  
            }else{
                $response["error"] = false;
                $response['message'] = "Password don't change";
            }

        }elseif(filter_var($email, FILTER_VALIDATE_INT)){
            $result=$result=$this->model->update('tbl_users',array('password'=>$newpassword),array('mobile'=>$email));
            if($result)
            {
                $response["error"] = false;
                $response['message'] = "Password change successfully";  
            }else{
                $response["error"] = false;
                $response['message'] = "Password don't change";
            }
        }else{
            $response["error"] = true;
            $response['message'] = "Please provide valid password";
        }
        responseJSON($response);
    }
    public function get_city(){
        $response = array();
        $all_city =array();
        $city_list= $this->model->fetch_data('tbl_city');
       // print_r(count($city_list));die;
        if(count($city_list)>0){
        //     foreach($city_list as $row){
        //         print_r($row->city_name);die;
        //       //$all_city =  
        //     }
        // print_r($city_list);die;

            $response["error"] = false;
            $response['data'] = $city_list;
            $response['message'] = "Get city list successfully";
        }else{
            $response["error"] = true;
            $response["message"] = "Don't Get city list successfully";
        }
        responseJSON($response);
    }

    public function edit_profile(){
        $json=file_get_contents('php://input');
        $data=json_decode($json,true);
        $name=$data['name'];
        $cityid=$data['cityid'];
        $gstno=$data['gstno'];
        $response = array();
        if(empty($name)){$response['message'] = "Please Insert full name";echo json_encode($response);exit;}
        if(empty($cityid)){$response['message'] = "Please Insert city id";echo json_encode($response);exit;}
        if(empty($gstno)){$response['message'] = "Please Insert Gst Number";echo json_encode($response);exit;}
        $api_key  = $this->input->get_request_header('Authorization');
            if($api_key != ''){
                $data = array(
                    "full_name" => $name,
                    "city_id" => $cityid,
                    "gst_no" => $gstno,
                    );
                $result= $this->model->update('tbl_users',$data,array('uid'=>$this->userid));
                if($result==true)
                {
                    $response["error"] = false;
                    $response['message'] = "Update profile successfully";
                }else{
                    $response["error"] = true;
                    $response['message'] = "Profile don't update";
                }
            }else{
                $response["error"] = true;
                $response['message'] = 'Api key is misssing';
            } 
        responseJSON($response);  
    }

    public function user_info(){
        $response=array();
        $api_key  = $this->input->get_request_header('Authorization');
            if($api_key != '')
            {
                $result = $this->model->get_selected_data(array('uid','full_name','mobile','email','gender','zipcode','city_id','gst_no','country_id'),'tbl_users',array('uid'=>$this->userid));
                $response["error"] = false;
                $response["data"]= $result;
                $response['message'] = "Get user info successfully";
            }else{
                $response["error"] = true;
                $response['message'] = 'Api key is misssing';
            } 
        responseJSON($response);  
    }
     public function user_image()
     {  
        $response['errorCode'] = 1;
        $response['message'] = "Please try it again later";
        $response['data'] = array();
        //header('Access-Control-Allow-Origin:*');
       // print_r ($api_key);die;
            //if($api_key != ''){
                $profileImage = '';
                $config['upload_path']   = './uploads/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['file_name']     = 'image'.'_'.rand(1,time());
                $config['overwrite']     = TRUE;
                $config['max_size']      = 10000;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('profileimage')) {
                    $response['message'] = "Please Insert Valid Profile Image";echo json_encode($response);exit;
                }

                $img = $this->upload->data();
                $profileimage = ($img['is_image']==true && !empty($img['file_name'])) ? $img['file_name'] : '';
                $data   = array(
                    'user_image' => '/uploads/'.$profileimage,
                );

                $this->model->update('tbl_users',$data,array('uid'=>$this->userid));
                $response["error"] = false;
            
                $response['message'] = 'Image upload successfully!';
            // }else{
            //     $response["error"] = true;
            //     $response['message'] = 'Api key is misssing';
            // }
            responseJSON($response);
     }

     public function moms_menu_list(){
        $json=file_get_contents('php://input');
        $data=json_decode($json,true);
        $response['error'] = true;
        $response['message'] = "Please try it again later";
        $response['data']=[];
        $api_key  = $this->input->get_request_header('Authorization');
        if ($api_key != '')
         {
            $meal_type=$data['meal_type'];
            if(empty($meal_type)){$response['message'] = "Please Insert meal type";echo json_encode($response);exit;}
            $result = $this->model->moms_menu_list($meal_type);
            if ($result) {
                $data= array('moms_list' => array());
                foreach($result as $key => $value){
                     $menu = $this->model->get_menu_list('tbl_thali',array('mid'=>$value['mid']));

                     $datas=array('menu_list'=>array());
                      foreach ($menu as $key => $val) {
                        $itemdata=$this->model->get_row('cart_item',array('item_id'=>$val->id,'userid'=>$this->userid));
                           
                        $menu_info=array('id'=>$val->id,'mid'=>$val->mid,'thali_name'=>$val->thali_name,'days'=>$val->days,'price'=>$val->price,'quty'=>$itemdata['item_quty']?intval($itemdata['item_quty']):0);
                        array_push($datas['menu_list'], $menu_info);
                         
                     }
                     $mem_info= array(
                                        'mid' => $value['mid'],
                                        'full_name' => $value['full_name'], 
                                        'moms_image' => $value['moms_image'], 
                                        'kitchen_name' => $value['kitchen_name'], 
                                        'food_type' => $value['food_type'],
                                        'kitchen_type'=>$value['kitchen_type'],

                                        'moms_rating' => $value['rating']?floatval($value['rating']):0,
                                        'menu_list'=>$datas['menu_list'] 
                                );
                        array_push($data['moms_list'], $mem_info);

                }
                    $response["error"] = false;
                   $response['data'] = $data;
                   $response['message'] = 'Mom list get successfully!';

           }else{
            $response["error"] = true;
            $response['message'] = "mom list don't get";
    
            }
        }else{
            $response["error"] = true;
            $response['message'] = 'Api key is misssing';
            }
            responseJSON($response);
     }
     public function moms_menu_thali(){
        $json=file_get_contents('php://input');
        $data=json_decode($json,true);
        $mid=$data['mom_id'];
        $response['error'] = true;
        $response['message'] = "Please try it again later";
        $response['moms_list'] = array();
        $datas=array();
        $api_key  = $this->input->get_request_header('Authorization');
        if ($api_key != ''){
        if (!empty($mid)) {
            $result = $this->model->get_menu_list('tbl_thali',array('mid'=>$mid));
            $response['Breakfast']=false;
            $response['lunch']=false;
            $response['Dinner']=false;
            //print_r($result);die;
            foreach ($result as $key => $value) {
               // print_r($value->food_category);die;
                $itemdata=$this->model->get_row('cart_item',array('item_id'=>$value->id,'mid'=>$mid,'userid'=>$this->userid));
                    $datas=array('id'=>$value->id,'mid'=>$value->mid,'food_type'=>$value->food_type,'thali_name'=>$value->thali_name,'days'=>$value->days,'price'=>$value->price,'quty'=>$itemdata['item_quty']?$itemdata['item_quty']:"0",
                        'Breakfast'=>($value->food_category=='Breakfast')?$response['Breakfast']=true:$response['Breakfast']=false,
                        'lunch'=>($value->food_category=='Lunch')?$response['lunch']=true:$response['lunch']=false,
                        'Dinner'=>($value->food_category=='Dinner')?$response['Dinner']=true:$response['Dinner']=false,);
                    
            
                array_push($response['moms_list'], $datas);
                
                
            }
            if ($result) {
               
               $response["error"] = false;
               $response["moms_list"] = $response['moms_list'];
               $response['message'] = 'Mom menu list get successfully!';

            }
            }else{
                    $response["error"] = true;
                    $response['message'] = "Mom menu list don't get!";
            }
        }else{
            $response["error"] = true;
            $response['message'] = 'Api key is misssing';
            }
        
        responseJSON($response);
     }
     public function additemcart()
     {
        $json=file_get_contents('php://input');
        $data=json_decode($json,true);
        $response['error'] = true;
        $response['message'] = "Please try it again later";
        $api_key  = $this->input->get_request_header('Authorization');
        if ($api_key != '')
         {
            $item_id=$data['itemid'];
            $item_quty=$data['item_quty'];
            $item_price=$data['item_price'];
            $item_tax=$data['item_tax'];
            $mom_id=$data['mom_id'];
            if(empty($item_id)){$response['message'] = "Please Insert itemid";echo json_encode($response);exit;}
            if(empty($item_quty)){$response['message'] = "Please Insert item quantity";echo json_encode($response);exit;}
            if(empty($item_price)){$response['message'] = "Please Insert item price";echo json_encode($response);exit;}
            if(empty($item_tax)){$response['message'] = "Please Insert item tax";echo json_encode($response);exit;}
            if(empty($mom_id)){$response['message'] = "Please Insert mom id";echo json_encode($response);exit;}
            
            if ($this->User_model->get_moms('tbl_moms',array('mid'=>$mom_id))==1)
            {
                if ($this->User_model->get_moms('tbl_thali',array('id'=>$item_id,'mid'=>$mom_id))==1) {
                    if ($this->User_model->get_moms('cart_item',array(' item_id'=>$item_id,'mid'=>$mom_id,'userid'=>$this->userid))!=1) {
                        $flag = true;
                        if ($flag) {
                            $data=array('item_id'=>$item_id,
                                    'item_quty'=>$item_quty,'userid'=>$this->userid,
                                    'price'=>$item_price,'tax'=>$item_tax,'mid'=>$mom_id);
                            $user=$this->model->add('cart_item',$data);
                            if ($user) 
                            {   $response["item"]=array();
                               $resp= $this->model->get_row('cart_item',array('userid'=>$this->userid,'mid'=>$mom_id,'item_id'=>$item_id));
                               if ($resp!=false) {
                                $response["error"] = false;
                                $response["message"] = "Item added successfully in cart.";

                                    $resultitem=array('item_id'=>$resp['item_id'],'item_quty'=>$resp['item_quty']);
                                    array_push($response["item"], $resultitem);
                               }
                               
                            }else {
                                $response["error"] = true;
                                $response["message"] = "The requested resource doesn't exists";
                            }
                        }else{
                               $response["error"] = true;
                                $response["message"] = "The requested resource doesn't exists";
                        }
                        
                    }else{
                        $response["error"] = true;
                        $response['message'] = 'Item already added in cart.';
                    }
                    
                }else{
                    $response["error"] = false;
                    $response['message'] = "invalid item!";
                }
                
            }else{
                $response["error"] = true;
                $response['message'] = "mom don't exits!";
            }
            
        }else{
            $response["error"] = true;
            $response['message'] = "Api key is missing!";
        }
        responseJSON($response);
     }

     public function updateitemcart()
     {
       
        $json=file_get_contents('php://input');
        $data=json_decode($json,true);
        $response['error'] = true;
        $response['message'] = "Please try it again later";
        $api_key  = $this->input->get_request_header('Authorization');
        if ($api_key != '')
         {
            $item_id=$data['itemid'];
            $item_quty=$data['item_quty'];
            $mom_id=$data['mom_id'];
            if(empty($item_id)){$response['message'] = "Please Insert itemid";echo json_encode($response);exit;}
            if(empty($item_quty)){$response['message'] = "Please Insert item quantity";echo json_encode($response);exit;}
            if(empty($mom_id)){$response['message'] = "Please Insert mom id";echo json_encode($response);exit;}
            
            if ($this->User_model->get_moms('tbl_moms',array('mid'=>$mom_id))==1)
            {
                if ($this->User_model->get_moms('tbl_thali',array('id'=>$item_id,'mid'=>$mom_id))==1) {
                    //if ($this->User_model->get_moms('cart_item',array(' item_id'=>$item_id,'mid'=>$mom_id,'userid'=>$this->userid))==true) {
                        $flag = true;
                        if ($flag) {
                            $data=array('item_id'=>$item_id,
                                    'item_quty'=>$item_quty,'userid'=>$this->userid,
                                    'mid'=>$mom_id);
                            $user=$this->model->update('cart_item',$data,array('item_id'=>$item_id,'userid'=>$this->userid));
                            if ($user) 
                            {   $response["item"]=array();
                               $resp= $this->model->get_row('cart_item',array('userid'=>$this->userid,'mid'=>$mom_id,'item_id'=>$item_id));
                               if ($resp!=false) {
                                $response["error"] = false;
                                $response["message"] = "Item added successfully in cart.";

                                    $resultitem=array('item_id'=>$resp['item_id'],'item_quty'=>$resp['item_quty']);
                                    array_push($response["item"], $resultitem);
                               }
                               
                            }else {
                                $response["error"] = true;
                                $response["message"] = "The requested resource doesn't exists";
                            }
                        }else{
                               $response["error"] = true;
                                $response["message"] = "The requested resource doesn't exists";
                        }
                        
                    // }else{
                    //     $response["error"] = true;
                    //     $response['message'] = 'Item already added in cart.';
                    // }
                    
                }else{
                    $response["error"] = false;
                    $response['message'] = "invalid item!";
                }
                
            }else{
                $response["error"] = true;
                $response['message'] = "mom don't exits!";
            }
            
        }else{
            $response["error"] = true;
            $response['message'] = "Api key is missing!";
        }
        responseJSON($response);
     }
     public function itemdeletecart(){
        $json=file_get_contents('php://input');
        $data=json_decode($json,true);
        $response['error'] = true;
        $response['message'] = "Please try it again later";
        $api_key  = $this->input->get_request_header('Authorization');
        if ($api_key != '')
         {
            $item_id=$data['itemid'];
            $mom_id=$data['mom_id'];
            if(empty($item_id)){$response['message'] = "Please Insert itemid";echo json_encode($response);exit;}
            if(empty($mom_id)){$response['message'] = "Please Insert mom id";echo json_encode($response);exit;}
            
            if ($this->User_model->get_moms('tbl_moms',array('mid'=>$mom_id))==1)
            {
                if ($this->User_model->get_moms('tbl_thali',array('id'=>$item_id,'mid'=>$mom_id))==1) {
                    if ($this->User_model->get_moms('cart_item',array(' item_id'=>$item_id,'mid'=>$mom_id,'userid'=>$this->userid))==true) {
                        $flag = true;
                        if ($flag) {
                            // $data=array('item_id'=>$item_id,
                            //         'item_quty'=>$item_quty,'userid'=>$this->userid,
                            //         'mid'=>$mom_id);
                            $user=$this->model->delete('cart_item',array('item_id'=>$item_id,'userid'=>$this->userid));
                            if ($user=='deleted') 
                            {   $response["item"]=array();
                               $resp= $this->model->get_row('cart_item',array('userid'=>$this->userid,'mid'=>$mom_id,'item_id'=>$item_id));
                               if ($resp==false) {
                                $response["error"] = false;
                                $response["message"] = "Item deleted successfully by cart.";

                                    $resultitem=array('item_id'=>$resp['item_id']?$resp['item_id']:0,'item_quty'=>$resp['item_quty']?$resp['item_quty']:0);
                                    array_push($response["item"], $resultitem);
                               }
                               
                            }else {
                                $response["error"] = true;
                                $response["message"] = "The requested resource doesn't exists";
                            }
                        }else{
                               $response["error"] = true;
                                $response["message"] = "The requested resource doesn't exists";
                        }
                        
                    }else{
                        $response["error"] = true;
                        $response['message'] = 'Item not available in cart.';
                    }
                    
                }else{
                    $response["error"] = false;
                    $response['message'] = "invalid item!";
                }
                
            }else{
                $response["error"] = true;
                $response['message'] = "mom don't exits!";
            }
            
        }else{
            $response["error"] = true;
            $response['message'] = "Api key is missing!";
        }
        responseJSON($response);
     }


     public function getcartitem()
     {
        $json=file_get_contents('php://input');
        $data=json_decode($json,true);
        $response['error'] = true;
        $response['message'] = "Please try it again later";
        $response["item"] = array();
        $api_key  = $this->input->get_request_header('Authorization');
        if ($api_key != '')
         {
            $mom_id=$data['mom_id'];
            if(empty($mom_id)){$response['message'] = "Please Insert mom id";echo json_encode($response);exit;}
            $resp= $this->User_model->getcartitem($mom_id);
            if ($resp )
             {
                $response["error"] = false;
                
                $response["message"] = "list get sucessfuly";
               $subtotal = 0;
               $tax =0;
                $Delivery =0;
                $Grand_Total =0;

                foreach ($resp as $key => $item) {
                    $total_price= $item['price'] *$item['item_quty'];
                    $resultitem=array('item_id'=>$item['item_id'],'thali_name'=>$item['thali_name'],'thali_image'=>$item['thali_image'],'food_type'=>$item['food_type'],'food_category'=>$item['food_category'],'mid'=>$item['mid'],'item_quty'=>intval($item['item_quty']),'price'=>$item['price'],'tax'=>$item['tax'],'tatal_price'=>$total_price);
                  array_push($response["item"], $resultitem);
                  $subtotal+=$total_price;
                  $tax+=$item['tax'];
                  $Delivery +=0;
                  
                }

                $Grand_Total =$subtotal+$tax;
                $response['bill_amount']=array('Subtotal'=>$subtotal,'Tax'=>$tax,'Delivery'=>$Delivery,'Grand Total'=>$Grand_Total);
              }else{
                $response["error"] = true;
                $response["message"] = "your cart is empty";
              }
         }else{
            $response["error"] = true;
            $response['message'] = "Api key is missing!";
         } 
         responseJSON($response);
     }

     public function food_category_time(){
        $response['error'] = true;
        $response['message'] = "Please try it again later";
        $response["Breakfast"] = array();
        $response["Lunch"] = array();
        $response["Dinner"] = array();
        $result=$this->model->fetch_data('food_timing');
        if ($result) {
            foreach ($result as $key => $value) {
                if ($value->food_category=='Breakfast') {
                    array_push($response["Breakfast"], $value->timing);
                }
                if ($value->food_category=='Lunch') {
                    array_push($response["Lunch"], $value->timing);
                }
                if ($value->food_category=='Dinner') {
                    array_push($response["Dinner"], $value->timing);
                }
                
            }
             $response["error"] = false;
             $response["message"] = "list get sucessfuly";
        }else{
            $response["error"] = true;
             $response["message"] = "list don't get sucessfuly";
        }
        responseJSON($response);//print_r($result);die;
     }

     public function placeorder(){
        $json=file_get_contents('php://input');
        $data=json_decode($json,true);
        $api_key  = $this->input->get_request_header('Authorization');
        if ($api_key != '')
         {
            $payment_type=$data['payment_type'];
            $transection_id=$data['transection_id'];
            $payment_id=$data['payment_id'];
            $paid_amount=$data['paid_amount'];
            $bill_name=$data['bill_name'];
            $bil_address=json_encode($data['bil_address']);
            $bil_email=$data['bil_email'];
            $bil_contact=$data['bil_contact'];
            $bil_countryid=$data['bil_countryid'];
            $bil_cityid=$data['bil_cityid'];
            $bil_pincode=$data['bil_pincode'];
            $card_id=$data['card_id'];
            $mom_id=$data['mom_id'];
            $lunch_time=$data['lunch_time'];
            $breakfast_time=$data['breakfast_time'];
            $dinner_time=$data['dinner_time'];
            //$order_items=json_encode($data['order_items']);
            //print_r($order_items);die;

            if(empty($payment_type)){$response['message'] = "Please Insert payment type";echo json_encode($response);exit;}
            if(empty($transection_id)){$response['message'] = "Please Insert transection id";echo json_encode($response);exit;}
            if(empty($payment_id)){$response['message'] = "Please Insert payment id";echo json_encode($response);exit;}
            if(empty($paid_amount)){$response['message'] = "Please Insert paid amount";echo json_encode($response);exit;}
            if(empty($bill_name)){$response['message'] = "Please Insert customer name";echo json_encode($response);exit;}
            if(empty($bil_address)){$response['message'] = "Please Insert  bill name";echo json_encode($response);exit;}
            if(empty($bil_email)){$response['message'] = "Please Insert bill email";echo json_encode($response);exit;}
            if(empty($bil_contact)){$response['message'] = "Please Insert bill contact";echo json_encode($response);exit;}
            if(empty($bil_countryid)){$response['message'] = "Please Insert country id";echo json_encode($response);exit;}
            if(empty($bil_cityid)){$response['message'] = "Please Insert bill cityid";echo json_encode($response);exit;}
            if(empty($bil_pincode)){$response['message'] = "Please Insert bill pincode";echo json_encode($response);exit;}
            if(empty($card_id)){$response['message'] = "Please Insert card_id";echo json_encode($response);exit;}
            if(empty($mom_id)){$response['message'] = "Please Insert mom_id";echo json_encode($response);exit;}
           // if(empty($order_items)){$response['message'] = "Please Insert orderitem id and quantit";echo json_encode($response);exit;}
            
            if ($this->model->get_row('tbl_moms',array('mid'=>$mom_id))) {
                $timedate = time();
                //$response['data']=array();
                $resp= $this->model->get_row('cart_item',array('userid'=>$this->userid,'mid'=>$mom_id));
                //echo "string";
                //print_r($resp);die;
               // if ($resp) {
                    $resp1=$this->User_model->getcartsubtotal(array('userid'=>$this->userid,'mid'=>$mom_id));
                    if ($resp1[0]['subtotal']!=$paid_amount) {
                    // $cartsubtotal = $resp1[0]['subtotal'] + $ord_deliverycharge +  $ord_tax ;
                     $orderid = "ORD" . time() . rand(1000, 9999);
                     $dataord=array('order_id'=>$orderid,'payment_type'=>$payment_type,'user_id'=>$this->userid,'txn_id'=>$transection_id,'total_price'=>$paid_amount,'mom_id'=>$mom_id,'payerID'=>$payment_id,'order_from'=>'','lunch_time'=>$lunch_time,'breakfast_time'=>$breakfast_time,'dinner_time'=>$dinner_time);
                        $ord=$this->model->add('order_table',$dataord);
                        if ($ord) {
                           $getcart_item = $this->User_model->getcartitems(array('userid'=>$this->userid,'mid'=>$mom_id));
                           $flag=true;
                           //print_r($getcart_item);die;
                           foreach ($getcart_item as $key => $value) {
                               $item_data = array('item_id'   => $value['item_id'],
                            'item_quty'  => $value['item_quty'],
                            'price'=> $value['price'],
                            'tax'  => $value['tax'],
                            'user_id'   => $value['userid'],
                            'order_id'  => $orderid,
                            'status'    => '1' );
                               $res=$this->model->add('ordered_item',$item_data);
                               if(!$res) {
                                 $flag = false;
                                  break;
                                }
                                
                           }
                            if ($flag) {
                                    $flag1=true;
                                    foreach ($getcart_item as $key => $cvalue) {
                                       $delete_result=$this->model->delete('cart_item',array('item_id'=>$cvalue['item_id'],'userid'=>$cvalue['userid'],
                                            'status'=>0));
                                       if(!$delete_result) {
                                        $flag1 = false;
                                        break;
                                    }
                                }
                //                 if($flag1){
                // //                     $this->db->commit();
                //                  true;
                //                 } else {
                // //                     $this->db->rollback();
                //                 }
                                    
                                }else{

                                }
                            $adddata=array('order_id'=>$orderid,
                                'user_id'=>$this->userid,
                                'name'=>$bill_name,
                                'address'=>$bil_address,
                                'ship_mobile_no'=>$bil_contact,
                                'email_id'=>$bil_email,
                                'country_id'=>$bil_countryid,
                                'city_id'=>$bil_cityid,
                                'pincode'=>$bil_pincode);
                            $this->model->add('shipping_address',$adddata);

                            $response["error"] = false;
                                //$response["itemupdate"] = $ordupdate;
                                //$response["shipadressinser"] = $resp;
                               // $response["ismailsend"] = $ismailsend;
                                //$response["issmssend"] = $sendsms;
                                $response["orderid"] = $orderid;
                                $response["message"] = "order placed sucessfuly";
                        }else{
                                $response['error'] = true;
                                $response['message'] = "An error occurred. Please try again2";
                        }
                    }
                    else{
                        $response['error'] = true;
                        $response['message'] = "invalid amount";
                    }
                   // print_r();die;
                //}else 
                // {
                //     $response['error'] = true;
                //     $response['message'] = "An error occurred. Please try again1";
                // }
                

            }else{
                $response["error"] = true;
                $response["message"] = "Invalid mom id!";
            }
        }else{
            $response["error"] = true;
            $response['message'] = "Api key is missing!";
        } 
         responseJSON($response);

        
     }

     public function progress_order_detail(){
        $json=file_get_contents('php://input');
        $data=json_decode($json,true);
        $api_key  = $this->input->get_request_header('Authorization');
        if ($api_key != '')
         {
            $orderid=$data['orderid'];
            if(empty($orderid)){$response['message'] = "Please Insert orderid";echo json_encode($response);exit;}
            $order_result=$this->model->get_row('order_table',array('order_id'=>$orderid));
            if ($order_result) {
                $response["error"] = false;
                $response['data'] = $order_result['status'];
                $response['message'] = "order prgress detail get successfully";
            }else{
                $response["error"] = true;
                $response['message'] = "order prgress detail don't get!";
            }
            }else{
            $response["error"] = true;
            $response['message'] = "Api key is missing!";
        } 
         responseJSON($response);
     }

     public function order_detail(){
        $json=file_get_contents('php://input');
        $data=json_decode($json,true);
        $api_key  = $this->input->get_request_header('Authorization');
        if ($api_key != '')
         {
            $orderid=$data['orderid'];
            if(empty($orderid)){$response['message'] = "Please Insert orderid";echo json_encode($response);exit;}
            $order_result=$this->User_model->getorderitems($orderid);
            if ($order_result) {
                $subtotal = 0;
                $tax =0;
                $Delivery =0;
                $Grand_Total =0;
                $response["error"] = false;
                $response['message'] = "item get list successfully!";
                $response["ordered_item"]=array();
                foreach ($order_result as $key => $value) {
                        $total_price= $value['price'] *$value['item_quty'];
                    $item_result=array('thali_name'=>$value['thali_name'],
                                    'thali_image'=>$value['thali_image'],
                                    'food_type'=>$value['food_type'],
                                    'food_category'=>$value['food_category'],
                                    'days'=>$value['days'],
                                    'price'=>$value['price'],
                                    'item_quty'=>$value['item_quty'],
                                    'orderid'=>$value['order_id'],
                                    'total_item_price'=>$value['price']*$value['item_quty']);
                     array_push($response["ordered_item"], $item_result);
                $subtotal+=$total_price;
                  $tax+=$value['tax'];
                  $Delivery +=0;
                }
                  $Grand_Total =$subtotal+$tax;
                $response['bill_amount']=array('Subtotal'=>$subtotal,'Tax'=>$tax,'Delivery'=>$Delivery,'Grand Total'=>$Grand_Total);
               
            }else{
                $response["error"] = true;
               $response['message'] = "item not found!";
            }
            

          }else{
            $response["error"] = true;
            $response['message'] = "Api key is missing!";
        } 
         responseJSON($response);  
     }

     public function orderhistory(){
        $json=file_get_contents('php://input');
        $data=json_decode($json,true);
        $api_key  = $this->input->get_request_header('Authorization');
        if ($api_key != '')
         {
            $result_ord=$this->User_model->getorders($this->userid);
            $response["error"] = false;
            $response['message'] = "order history get successfully!";
            $response["ordered_item"]=array();
            foreach ($result_ord as $key => $value) {
                $item_result=array('thali_name'=>$value['thali_name'],
                                    'thali_image'=>$value['thali_image'],
                                    'food_type'=>$value['food_type'],
                                    'food_category'=>$value['food_category'],
                                    'days'=>$value['days'],
                                    'price'=>$value['price'],
                                    'item_quty'=>$value['item_quty'],
                                    'orderid'=>$value['order_id'],
                                    'date_time'=>$value['date_time'],
                                    'total_item_price'=>$value['price']*$value['item_quty']);
                //print_r($item_result);die;
                     array_push($response["ordered_item"], $item_result);
            }
          }else{
            $response["error"] = true;
            $response['message'] = "Api key is missing!";
          } 
         responseJSON($response);  
     }

     public function user_address(){
        $json=file_get_contents('php://input');
        $data=json_decode($json,true);
        $api_key  = $this->input->get_request_header('Authorization');
        if ($api_key != '')
         {
            $user_address=json_encode($data['user_address']);
            $address_type=$data['address_type'];
            if(empty($address_type)){$response['message'] = "Please Insert address_type";echo json_encode($response);exit;}
            $result=$this->model->add('user_address',array('address'=>$user_address,'add_type'=>$address_type,'user_id'=>$this->userid));
            if ($result) {
               $get_address= $this->User_model->get_row('user_address',array('user_id'=>$this->userid));
                $response["error"] = false;
                $response['message'] = "User address added successfully!";
               $response["user_address"]=array();
               foreach ($get_address as $key => $value) {
                    $address_item= array(
                        'address_id'=>$value['address_id'],
                        'address'=>$value['address'],
                        'add_type'=>$value['add_type'],
                        'created_date'=>$value['created_date']   );
                        array_push($response["user_address"], $address_item);
                            }
            }
            }else{
            $response["error"] = true;
            $response['message'] = "Api key is missing!";
          } 
         responseJSON($response);
     }
     public function user_updateaddress(){
        $json=file_get_contents('php://input');
        $data=json_decode($json,true);
        $api_key  = $this->input->get_request_header('Authorization');
        if ($api_key != '')
         {
            $address_id=$data['address_id'];
            $user_address=json_encode($data['user_address']);
            $address_type=$data['address_type'];
            if(empty($address_id)){$response['message'] = "Please Insert address id";echo json_encode($response);exit;}
            if(empty($address_type)){$response['message'] = "Please Insert address type";echo json_encode($response);exit;}

            $result=$this->model->update('user_address',array('address'=>$user_address,'add_type'=>$address_type,'user_id'=>$this->userid),array('user_id'=>$this->userid,'add_type'=>$address_type,'address_id'=>$address_id));
            if ($result) {
               $get_address= $this->User_model->get_row('user_address',array('user_id'=>$this->userid));
                $response["error"] = false;
                $response['message'] = "User address added successfully!";
               $response["user_address"]=array();
               foreach ($get_address as $key => $value) {
                    $address_item= array(
                        'address_id'=>$value['address_id'],
                        'address'=>$value['address'],
                        'add_type'=>$value['add_type'],
                        'created_date'=>$value['created_date']   );
                        array_push($response["user_address"], $address_item);
                            }
            }
            }else{
            $response["error"] = true;
            $response['message'] = "Api key is missing!";
          } 
         responseJSON($response);
     }
     public function user_deletaddress(){
        $json=file_get_contents('php://input');
        $data=json_decode($json,true);
        $api_key  = $this->input->get_request_header('Authorization');
        if ($api_key != '')
         {
            $address_id=$data['address_id'];
            
            if(empty($address_id)){$response['message'] = "Please Insert address id";echo json_encode($response);exit;}
            $result=$this->model->delete('user_address',array('user_id'=>$this->userid,'address_id'=>$address_id));
            if ($result) {
               $get_address= $this->User_model->get_row('user_address',array('user_id'=>$this->userid));
                $response["error"] = false;
                $response['message'] = "User address added successfully!";
               $response["user_address"]=array();
               foreach ($get_address as $key => $value) {
                    $address_item= array(
                        'address_id'=>$value['address_id'],
                        'address'=>$value['address'],
                        'add_type'=>$value['add_type'],
                        'created_date'=>$value['created_date']   );
                        array_push($response["user_address"], $address_item);
                            }
            }
            }else{
            $response["error"] = true;
            $response['message'] = "Api key is missing!";
          } 
         responseJSON($response);
     }

     public function food_days(){
         $json=file_get_contents('php://input');
        $data=json_decode($json,true);
        $api_key  = $this->input->get_request_header('Authorization');
        
        if ($api_key != '')
         {  
            $response["Breakfast"] = array();
            $response["Lunch"] = array();
            $response["Dinner"] = array();
            $mom_id=$data['mom_id'];
            if(empty($mom_id)){$response['message'] = "Please Insert mom id";echo json_encode($response);exit;}
            $result=$this->User_model->get_row('moms_weekdays',array('mom_id'=>$mom_id));
            if ($result) {
               
             $response["error"] = false;
             $response["message"] = "list get sucessfuly";
                foreach ($result as $key => $value) {
                    if ($value['food_type']=='Breakfast') {
                        array_push($response["Breakfast"], $value['days']);
                    }
                    if ($value['food_type']=='Lunch') {
                        array_push($response["Lunch"], $value['days']);
                    }
                    if ($value['food_type']=='Dinner') {
                        array_push($response["Dinner"], $value['days']);
                    }
                    
                }
        }else{
            $response["error"] = true;
             $response["message"] = "list don't get sucessfuly";
        }
            }else{
            $response["error"] = true;
            $response['message'] = "Api key is missing!";
          } 
         responseJSON($response);
     }

}
/*
| Login with User agent
| system info = $_SERVER['HTTP_USER_AGENT'];
|
|
|*/