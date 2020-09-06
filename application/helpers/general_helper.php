<?php 

/**
 * get logged admin data
 * @param string $apikey
 * @param string $name
 */
if (!function_exists('getuserid')) {
    function getuserid($table,$auth_key){
        $ci = get_instance();
        $uid = false;
        $getuserid = $ci->model->get_selected_data('uid',$table,array('api_key' => $auth_key));
        if(count($getuserid) > 0){
            $uid = $getuserid[0]['uid'];
        }
        return $uid;
    }
}
if ( ! function_exists('alert')) {  
    function alert($msg='', $type='success_msg') {
        $CI =& get_instance();?>
        <?php if (empty($msg)): ?>
            <?php if ($CI->session->flashdata('success_msg')): ?>
              <?php echo success_alert($CI->session->flashdata('success_msg')); ?>
            <?php endif ?>
            <?php if ($CI->session->flashdata('error_msg')): ?>
              <?php echo error_alert($CI->session->flashdata('error_msg')); ?>
            <?php endif ?>
            <?php if ($CI->session->flashdata('info_msg')): ?>
              <?php echo info_alert($CI->session->flashdata('info_msg')); ?>
            <?php endif ?>
        <?php else: ?>
            <?php if ($type == 'success_msg'): ?>
              <?php echo success_alert($msg); ?>
            <?php endif ?>
            <?php if ($type == 'error_msg'): ?>
              <?php echo error_alert($msg); ?>
            <?php endif ?>
            <?php if ($type == 'info_msg'): ?>
              <?php echo info_alert($msg); ?>
            <?php endif ?>
        <?php endif; ?>
    <?php }
}
/**
* Success alert
*/
if ( ! function_exists('success_alert')) {  
    function success_alert($msg = '') {?>
        <div class="alert alert-success">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Success!</strong> <?php echo $msg ?>
        </div>
    <?php 
    }
}
 
/**
* Error alert
*/
if ( ! function_exists('error_alert')) {  
    function error_alert($msg = '') {?>
        <div class="alert alert-danger">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Error!</strong> <?php echo $msg ?>
        </div>
    <?php 
    }
}
 
/**
* info alert
*/
if ( ! function_exists('info_alert')) { 
    function info_alert($msg = '') {?>
        <div class="alert alert-info">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Info: </strong> <?php echo $msg ?>
        </div>
    <?php 
    }
}

if (!function_exists('logged_admin_record')) {
    function logged_admin_record() {
        $ci = get_instance();
        if($ci->session->has_userdata('go2groadmin_session')){
            return array('name' => $ci->session->userdata['go2groadmin_session']['logged_username'],
            'id' => $ci->session->userdata['go2groadmin_session']['logged_userid'],
            'apikey' => $ci->session->userdata['go2groadmin_session']['logged_user_api_key']);
        }
    }
}

/**
 * link the css files 
 * 
 * @param array $array
 * @return print css links
 */
if (!function_exists('load_css')) {
    function load_css(array $array) {
        $ci = get_instance();
        foreach ($array as $uri) {
            echo "<link rel='stylesheet' type='text/css' href='" . base_url($uri) .$ci->config->item('Web_unique_url'). "' /> \n";
        }
    }
}

/**
 * link the javascript files 
 * 
 * @param array $array
 * @return print js links
 */
if (!function_exists('load_js')) {

    function load_js(array $array) {
        $ci = get_instance();
        foreach ($array as $uri) {
            echo "<script type='text/javascript'  src='" . base_url($uri) .$ci->config->item('Web_unique_url')."'></script>\n";
        }
    }
}

/**
 * create a encoded id for sequrity pupose 
 * 
 * @param string $id
 * @param string $salt
 * @return endoded value
 */
if (!function_exists('encode_str')) {
    function encode_str($id, $salt) {
        $ci = get_instance();
        $id = $ci->encryption->encode($id . $salt);
        $id = str_replace("=", "~", $id);
        $id = str_replace("+", "_", $id);
        $id = str_replace("/", "-", $id);
        return $id;
    }
}

/**
 * decode the id which made by encode_id()
 * 
 * @param string $id
 * @param string $salt
 * @return decoded value
 */
if (!function_exists('decode_str')) {
    function decode_str($id, $salt) {
        $ci = get_instance();
        $id = str_replace("_", "+", $id);
        $id = str_replace("~", "=", $id);
        $id = str_replace("-", "/", $id);
        $id = $ci->encryption->decode($id);
        if ($id && strpos($id, $salt) !== false) {
            return str_replace($salt, "", $id);
        }
    }
}

//------file upload----
if (!function_exists('do_file_upload')) {
    function do_file_upload($filename,$uploadpath,$filetype,$size='',$width='',$height='') {
        $file = [];
        $ci = & get_instance();
        $config['upload_path']          = $uploadpath;
        $config['allowed_types']        = $filetype;
        $config['max_size']             = $size;
        $config['max_width']            = $width;
        $config['max_height']           = $height;
        $config['encrypt_name']           = true;
        $ci->load->library('upload', $config);
        if (!$ci->upload->do_upload($filename))
        {
            $file = array('success' => false,'error'=>$ci->upload->display_errors());
        }
        else
        {
            $file = array('success' => true,'done'=>$ci->upload->data());
        }
        return $file;
    }
}
//-------------Ajax Pagination------------

if(! function_exists('ajaxpagination'))
{ 
    function ajaxpagination($url, $rowscount, $per_page,$fun='',$uri_segment)
    {
        $call = 'all_pagination';
        if($fun){
            $call = $fun;
        }
        $ci = & get_instance();
        $ci->load->library('Ajax_pagination');
        $config = array();
        $config['base_url'] = site_url($url);
        $config["uri_segment"] = $uri_segment;
        $config["total_rows"] = $rowscount;
        $config["per_page"] = $per_page;
        $config['link_func']  = $call;
        $config['full_tag_open'] = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        //$ci->pagination->initialize($config);
        $ci->ajax_pagination->initialize($config);
        //return $ci->ajax_pagination->create_links();
    }
}

//-------------Normal Pagination------------
if(! function_exists('cipagination'))
{
    function cipagination($options) {
        extract($options);
        $ci = & get_instance();
        $ci->load->library('pagination');
        $config = array();
        $config["base_url"] = base_url($url);
        $config["total_rows"] = $rowscount;
        $config["per_page"] = $per_page;
        $config["uri_segment"] = $uri_segment;
        $config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $ci->pagination->initialize($config);
        return $ci->pagination->create_links();
    }
}

/**
 * get user's time zone offset 
 * 
 * @return active users timezone
 */
if (!function_exists('get_timezone_offset')) {

    function get_timezone_offset() {
        $timeZone = new DateTimeZone(get_setting("timezone"));
        $dateTime = new DateTime("now", $timeZone);
        return $timeZone->getOffset($dateTime);
    }

}

/**
 * convert a local time to UTC 
 * 
 * @param string $date
 * @param string $format
 * @return utc date
 */
if (!function_exists('convert_date_local_to_utc')) {

    function convert_date_local_to_utc($date = "", $format = "Y-m-d H:i:s") {
        if (!$date) {
            return false;
        }
        //local timezone
        $time_offset = get_timezone_offset() * -1;

        //add time offset
        return date($format, strtotime($date) + $time_offset);
    }

}

/**
 * get current utc time
 * 
 * @param string $format
 * @return utc date
 */
if (!function_exists('get_current_utc_time')) {

    function get_current_utc_time($format = "Y-m-d H:i:s") {
        $d = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
        $d->setTimeZone(new DateTimeZone("UTC"));
        return $d->format($format);
    }

}

/**
 * convert a UTC time to local timezon as defined on users setting
 * 
 * @param string $date_time
 * @param string $format
 * @return local date
 */
if (!function_exists('convert_date_utc_to_local')) {

    function convert_date_utc_to_local($date_time, $format = "Y-m-d H:i:s") {
        $date = new DateTime($date_time . ' +00:00');
        $date->setTimezone(new DateTimeZone(get_setting('timezone')));
        return $date->format($format);
    }

}

/**
 * get current users local time
 * 
 * @param string $format
 * @return local date
 */
if (!function_exists('get_my_local_time')) {

    function get_my_local_time($format = "Y-m-d H:i:s") {
        return date($format, strtotime(get_current_utc_time()) + get_timezone_offset());
    }

}

/**
 * convert time string to 24 hours format 
 * 01:00 AM will be converted as 13:00:00 
 * 
 * @param string $time  required time format = 01:00 AM/PM
 * @return 24hrs time
 */
if (!function_exists('convert_time_to_24hours_format')) {

    function convert_time_to_24hours_format($time = "00:00 AM") {
        if (!$time)
            $time = "00:00 AM";

        if (strpos($time, "AM")) {
            $time = trim(str_replace("AM", "", $time));
            $check_time = explode(":", $time);
            if ($check_time[0] == 12) {
                $time = "00:" . get_array_value($check_time, 1);
            }
        } else if (strpos($time, "PM")) {
            $time = trim(str_replace("PM", "", $time));
            $check_time = explode(":", $time);
            if ($check_time[0] > 0 && $check_time[0] < 12) {
                $time = $check_time[0] + 12 . ":" . get_array_value($check_time, 1);
            }
        }
        $time.=":00";
        return $time;
    }

}

/**
 * convert time string to 12 hours format 
 * 13:00:00 will be converted as 01:00 AM
 * 
 * @param string $time  required time format =  00:00:00
 * @return 12hrs time
 */
if (!function_exists('convert_time_to_12hours_format')) {

    function convert_time_to_12hours_format($time = "") {
        if ($time) {
            $am = " AM";
            $pm = " PM";
            if (get_setting("time_format") === "small") {
                $am = " am";
                $pm = " pm";
            }
            $check_time = explode(":", $time);
            $hour = $check_time[0] * 1;
            $minute = get_array_value($check_time, 1) * 1;
            $minute = ($minute < 10) ? "0" . $minute : $minute;

            if ($hour == 0) {
                $time = "12:" . $minute . $am;
            } else if ($hour == 12) {
                $time = $hour . ":" . $minute . $pm;
            } else if ($hour > 12) {
                $hour = $hour - 12;
                $hour = ($hour < 10) ? "0" . $hour : $hour;
                $time = $hour . ":" . $minute . $pm;
            } else {
                $hour = ($hour < 10) ? "0" . $hour : $hour;
                $time = $hour . ":" . $minute . $am;
            }
            return $time;
        }
    }
}

/**
 * prepare a decimal value from a time string
 * 
 * @param string $time  required time format =  00:00:00
 * @return number
 */
if (!function_exists('convert_time_string_to_decimal')) {

    function convert_time_string_to_decimal($time = "00:00:00") {
        $hms = explode(":", $time);
        return $hms[0] + ($hms[1] / 60) + ($hms[2] / 3600);
    }
}

/**
 * prepare a human readable time format from a decimal value of seconds
 * 
 * @param string $seconds
 * @return time
 */
if (!function_exists('convert_seconds_to_time_format')) {

    function convert_seconds_to_time_format($seconds = 0) {
        $is_negative = false;
        if ($seconds < 0) {
            $seconds = $seconds * -1;
            $is_negative = true;
        }
        $seconds = $seconds * 1;
        $hours = floor($seconds / 3600);
        $mins = floor(($seconds - ($hours * 3600)) / 60);
        $secs = floor($seconds % 60);

        $hours = ($hours < 10) ? "0" . $hours : $hours;
        $mins = ($mins < 10) ? "0" . $mins : $mins;
        $secs = ($secs < 10) ? "0" . $secs : $secs;

        $string = $hours . ":" . $mins . ":" . $secs;
        if ($is_negative) {
            $string = "-" . $string;
        }
        return $string;
    }
}

if (!function_exists('convert_min_to_time_format')) {
    function convert_min_to_time_format($min = 0) {
        $is_negative = false;
        if ($min < 0) {
            $min = $min * -1;
            $is_negative = true;
        }
        $min = $min * 1;
        $hours = intval($min/60);
        $mins = $min - ($hours * 60);
        $hours = ($hours < 10) ? "0" . $hours : $hours;
        $mins = ($mins < 10) ? "0" . $mins : $mins;
        //$secs = ($secs < 10) ? "0" . $secs : $secs;

        $string = $hours . ":" . $mins;
        if ($is_negative) {
            $string = "-" . $string;
        }
        return $string;
    }
}

/**
 * get seconds form a given time string
 * 
 * @param string $time
 * @return seconds
 */
if (!function_exists('convert_time_string_to_second')) {

    function convert_time_string_to_second($time = "00:00:00") {
        $hms = explode(":", $time);
        return $hms[0] * 3600 + ($hms[1] * 60) + ($hms[2]);
    }

}

/**
 * convert a datetime string to relative time 
 * ex: $date_time = "2015-01-01 23:10:00" will return like this: Today at 23:10 PM
 * 
 * @param string $date_time .. it will be considered as UTC time.
 * @param string $convert_to_local .. to prevent conversion, pass $convert_to_local=false 
 * @return date time
 */
if (!function_exists('format_to_relative_time')) {

    function format_to_relative_time($date_time, $convert_to_local = true, $is_short_date = false) {
        if ($convert_to_local) {
            $date_time = convert_date_utc_to_local($date_time);
        }

        $target_date = new DateTime($date_time);
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone(get_setting('timezone')));
        $today = $now->format("Y-m-d");
        $date = "";
        $short_date = "";
        if ($now->format("Y-m-d") == $target_date->format("Y-m-d")) {
            $date = lang("today_at");   //today
            $short_date = lang("today");
        } else if (date('Y-m-d', strtotime(' -1 day', strtotime($today))) === $target_date->format("Y-m-d")) {
            $date = lang("yesterday_at"); //yesterday
            $short_date = lang("yesterday");
        } else if ($target_date->format("y") === $now->format("y")) {
            $date = $target_date->format("M d"); //this year
            $short_date = $target_date->format("d, F");
        } else {
            $date = $target_date->format("M d, Y");  //general date format
            $short_date = $date;
        }
        if ($is_short_date) {
            return $short_date;
        } else {
            return $date . " " . convert_time_to_12hours_format($target_date->format("H:i:s"));
        }
    }

}

/**
 * convert a datetime string to date format as defined on settings
 * ex: $date_time = "2015-01-01 23:10:00" will return like this: Today at 23:10 PM
 * 
 * @param string $date_time .. it will be considered as UTC time.
 * @param string $convert_to_local .. to prevent conversion, pass $convert_to_local=false 
 * @return date
 */
if (!function_exists('format_to_date')) {

    function format_to_date($date_time, $convert_to_local = true) {
        if (!$date_time)
            return "";

        if ($convert_to_local) {
            $date_time = convert_date_utc_to_local($date_time);
        }
        $target_date = new DateTime($date_time);
        return $target_date->format(get_setting('date_format'));
    }

}

/**
 * convert a datetime string to ago format
 * 
 *
 */
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


/**
 * convert a datetime string to 12 hours time format
 * 
 * @param string $date_time .. it will be considered as UTC time.
 * @param string $convert_to_local .. to prevent conversion, pass $convert_to_local=false 
 * @return time
 */
if (!function_exists('format_to_time')) {
    function format_to_time($date_time, $convert_to_local = true) {
        if ($convert_to_local) {
            $date_time = convert_date_utc_to_local($date_time);
        }
        $target_date = new DateTime($date_time);
        return convert_time_to_12hours_format($target_date->format("H:i:s"));
    }
}

/**
 * convert a datetime string to datetime format as defined on settings
 * 
 * @param string $date_time .. it will be considered as UTC time.
 * @param string $convert_to_local .. to prevent conversion, pass $convert_to_local=false 
 * @return date time
 */
if (!function_exists('format_to_datetime')) {
    function format_to_datetime($date_time, $convert_to_local = true) {
        if ($convert_to_local) {
            $date_time = convert_date_utc_to_local($date_time);
        }
        $target_date = new DateTime($date_time);
        return $target_date->format(get_setting('date_format')) . " " . convert_time_to_12hours_format($target_date->format("H:i:s"));
    }
}


if(! function_exists('responseJSON'))
{
    function responseJSON($data)
    {
        if (gettype($data) == 'array') {
            $data = json_encode($data);
        } else if (gettype($data) == 'object') {
            $data = json_encode($data);
        }
        header('Content-Type: application/json; charset=utf-8');
        echo $data;
        return;
    }
}

if(! function_exists('getTextStatus'))
{
    function getTextStatus($statusid)
    {
        switch($statusid)
        {
            case 0:
                $status="PENDING";
                break;
            case 1:
                $status="PREPARE";
                break;
            case 2:
                $status="PACKED";
                break;
            case 3:
                $status="OUT FOR DELIVERY";
                break;
            case 4:
                $status="DELIVERED";
                break;
            case 6:
                $status="CANCELLED";
                break;
            default:
                $status="REJECT";
        }
        return $status;
    }
}

if(! function_exists('verifyRequiredParams')){
    function verifyRequiredParams($required_fields)
    {
        $error = false;
        $error_fields = "";
        $request_params = array();
        $request_params = $_REQUEST;
        // Handling PUT request params
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $ci = & get_instance();
            parse_str($ci->request()->getBody(), $request_params);
        }
        foreach ($required_fields as $field) {
            if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
                $error = true;
                $error_fields .= $field . ', ';
            }
        }

        if ($error) {
            // Required field(s) are missing or empty
            // echo error json and stop the app
            $response = array();
            $ci = & get_instance();
            $response["error"] = true;
            $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
            return $response;
        }
    }
}

if(! function_exists('generateRandomString')){
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

//==================generateApiKey==============
if(! function_exists('generateApiKey')){
    function generateApiKey()
    {
        return md5(uniqid(rand(), true));
    }
}

//==================get_client_ip==============
if(! function_exists('get_client_ip')){
    function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress; 
    }
}
//=====================get_the_browser==============
if(! function_exists('get_the_browser')){
    function get_the_browser()
    {
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)
            return 'Internet explorer';
        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== false)
            return 'Internet explorer';
        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false)
            return 'Mozilla Firefox';
        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false)
            return 'Google Chrome';
        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false)
            return "Opera Mini";
        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false)
            return "Opera";
        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== false)
            return "Safari";
        else
            return 'Other';
    }
}

if ( ! function_exists('str_highlight')) {  
    function str_highlight($pattern, $str) {
        /*
            if(isset($_POST['search']['value'])){
                $array_of_words = array($_POST['search']['value']);
                $pattern = '#(?<=^|\C)(' . implode('|', array_map('preg_quote', $array_of_words))
                . ')(?=$|\C)#i';
            }

        */
        $tag = "<span style='background-color:#FFFF00;'>$1</span>";
        return preg_replace($pattern, $tag, $str);
    }
}
?>