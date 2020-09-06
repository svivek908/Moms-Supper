<?php
if (!defined('BASEPATH'))

    exit('No direct script access allowed');

class General {
    var $CI;

    public function __construct() {

        // Set the super object to a local variable for use later

        $this->CI = & get_instance();

    }

    public function check_exits_rec($option){
        $result = false;
        $record = $this->CI->model->get_records($option);
        if(!empty($record)){
            $result = $record;
        }
        return $result;
    }

    public function sendMail($to, $fromEmail, $fromName, $subject, $message) {

        $this->CI->load->library('email');

        $this->CI->email->mailtype = 'html';

        $this->CI->email->from($fromEmail, $fromName);

        $this->CI->email->to($to);

        $this->CI->email->subject($subject);

        $this->CI->email->message($message);

        $result = $this->CI->email->send();

        if ($result == 1)

            return 1;

        else

            return 0;
    }

    public function expirePage() {

        $this->CI->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');

        $this->CI->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');

        $this->CI->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);

        $this->CI->output->set_header('Pragma: no-cache');

    }

    //----------------password hash--------------
    public function getHashedPassword($plainPassword)
    {
        return password_hash($plainPassword, PASSWORD_DEFAULT);
    }

    //---------------verify password----------------
    public function verifyHashedPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword) ? true : false;
    }

    public function get_attempt_ques(){
        if($this->CI->session->has_userdata('user_attempt_quiz')){
            $id_arr = array();
            $user_attempt_quiz = $this->CI->session->userdata('user_attempt_quiz');
            foreach ($user_attempt_quiz as $key => $value) {
                array_push($id_arr, $value['questionId']);
            }
            return $id_arr;
        }else{
            return false;
        }
    }
}



/* End of file General.php */

/* Location: ./application/libraries/general.php */