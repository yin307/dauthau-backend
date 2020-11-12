<?php
defined("BASEPATH") or exit("No direct script access allowed");
require PATH_STSTEM . "/PHPMailer/PHPMailerAutoload.php";
class Zeanni_model extends CI_Model
{
    // private $base_url;
    private $_getSegment = array();
    // private $_systemSession = array();
    private $_systemCookie = array();
    // private $Lib_ZN;
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        // $this->base_url = base_url();
        $this->load->model("Savefile_model", "Savefile");
        // $this->load->library("Lib_ZN");
        // $this->Lib_ZN = new Lib_ZN();
        function isJson($string)
        {
            json_decode($string);
            return (json_last_error() == JSON_ERROR_NONE);
        }
        $self = !empty($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : $_SERVER["REDIRECT_URL"];
        $self = explode("/", $self);
        $_getSegment = array();
        $count = count($self) + 5;
        if (!empty($_GET["indexSegment--"])) {
            for ($x = 1; $x <= $count; $x++) {
                $_getSegment[($x - 1)] = $this->db->escape_str($this->uri->segment($x));
            }
        } else {
            for ($x = 1; $x <= $count; $x++) {
                $_getSegment[$x] = $this->db->escape_str($this->uri->segment($x));
            }
        }
        $this->_getSegment = $_getSegment;
        if (!empty($_COOKIE)) {
            $this->_systemCookie = $_COOKIE;
            foreach ($this->_systemCookie as $k => $v) {
                if (isJson($v)) {
                    $this->_systemCookie[$k] = json_decode($v, true);
                }
            }
        }
        // $this->_systemSession = $this->session->userdata();

        $_GET = empty($_GET) ? array() : $_GET;
        $_POST = empty($_POST) ? array() : $_POST;
        foreach ($_GET as $k => $v) {
            $_GET[$k] = $this->db->escape_str($v);
        }
        foreach ($_POST as $k => $v) {
            $_POST[$k] = $this->db->escape_str($v);
        }
    }
    public function sendMaXacThuc($toEmail = '', $OTP_CODE = '')
    {
        $this->load->config('email');
        $mailInfo = $this->config->item('mailInfo');

        if (empty($toEmail)) {
            $_POST = json_decode(file_get_contents('php://input'), true);
            if (!empty($_POST['email'])) {
                $toEmail = $_POST['email'];
            }
            if (empty($toEmail)) {
                return array('errorCode' => 1, 'data' => array());
            }
        }
        if (empty($OTP_CODE)) {
            $rand = md5(microtime());
            $OTP_CODE = strtoupper(substr($rand, 0, 6));
            $this->db->where(array('EMAIL' => $toEmail));
            $this->db->update('TBL_USERS', array('OTP_CODE' => $OTP_CODE));
        }

        //send mail
        $mail = new PHPMailer();
        //Khai báo gửi mail bằng SMTP
        $mail->IsSMTP();
        $mail->CharSet = "UTF-8";
        //Tắt mở kiểm tra lỗi trả về, chấp nhận các giá trị 0 1 2
        // 0 = off không thông báo bất kì gì, tốt nhất nên dùng khi đã hoàn thành.
        // 1 = Thông báo lỗi ở client
        // 2 = Thông báo lỗi cả client và lỗi ở server
        $mail->SMTPDebug  = 0;
        $mail->Debugoutput = "html"; // Lỗi trả về hiển thị với cấu trúc HTML
        $mail->Host       = "smtp.gmail.com"; //host smtp để gửi mail
        $mail->Port       = 587; // cổng để gửi mail
        $mail->SMTPSecure = "tls"; //Phương thức mã hóa thư - ssl hoặc tls
        $mail->SMTPAuth   = true; //Xác thực SMTP
        $mail->Username   = $mailInfo['smtp_user']; // Tên đăng nhập tài khoản Gmail
        $mail->Password   = "hchdexogutacmzms"; //Mật khẩu của ung dung cua gmail
        $mail->SetFrom($mailInfo['smtp_user'], "Mã xác thực từ App Mua Sắm Công"); // Thông tin người gửi
        $mail->AddReplyTo($mailInfo['smtp_user']); // Ấn định email sẽ nhận khi người dùng reply lại.
        $mail->AddAddress($toEmail); //Email của người nhận
        $mail->Subject = "Mã xác thực từ App Mua Sắm Công"; //Tiêu đề của thư
        $mail->MsgHTML('<div>Mã xác thực: ' . $OTP_CODE . '</div>'); //Nội dung của bức thư.
        if (!$mail->Send()) {
            return array('errorCode' => 1, 'data' => array());
        } else {
            return array('errorCode' => 0, 'data' => array());
        }
    }
    public function sendOTP_CODE()
    {
        $arr = json_decode(file_get_contents('php://input'), true);
        if (empty($arr['email'])) {
            return array('errorCode' => 2, 'data' => array());
        }
        $email = $this->db->escape_str(trim($arr['email']));
        $email = strtolower($email);
        //check acount exits
        $this->db->select('EMAIL');
        $this->db->where(' Lower(EMAIL) ', $email);
        $data = $this->db->get('TBL_USERS')->result_array();
        if (empty($data)) {
            return array('errorCode' => 1, 'data' => array());
        }

        $TOKEN = md5((microtime() . rand(10, 1000)));
        $OTP_CODE = strtoupper(substr($TOKEN, 0, 6));
        $this->sendMaXacThuc($email, $OTP_CODE);
        $this->db->where(' Lower(EMAIL) ', $email);
        $this->db->update('TBL_USERS', array('OTP_CODE' => $OTP_CODE));
        return array('errorCode' => 0, 'data' => array());
    }
    public function forgotPassword()
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
        if (!empty($_POST['password'])) {
            $password = trim($_POST['password']);
        }
        if (!empty($_POST['email'])) {
            $email = strtolower(trim($_POST['email']));
        }
        if (!empty($_POST['otp'])) {
            $otp = trim($_POST['otp']);
        }

        if (empty($password) || empty($email) || empty($otp)) {
            return array('errorCode' => 1, 'data' => array());
        }

        $TOKEN = md5((microtime() . rand(10, 1000)));
        $res = $this->getUserInfo(array('EMAIL' => $email, 'OTP_CODE' => $otp));
        if ($res['errorCode'] == 0) {
            $this->db->where('USER_ID', $res['data']['USER_ID']);
            $this->db->update('TBL_USERS', array('TOKEN' => $TOKEN, 'PWD' => md5($password)));
            $res['data']['TOKEN'] = $TOKEN;
        }
        return $res;
    }
    public function checkMailExist()
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
        if (!empty($_POST['email'])) {
            $email = strtolower(trim($_POST['email']));
        }
        if (empty($email)) {
            return array('errorCode' => 1, 'data' => array());
        }
        $this->db->select('USER_ID,OTP_CODE');
        $this->db->where(array(' Lower(EMAIL) ' => $email));
        $data = $this->db->get('TBL_USERS')->result_array();
        if (!empty($data)) {
            return array('errorCode' => 1, 'msg' => 'Email đã được đăng ký');
        } else {
            return array('errorCode' => 0, 'msg' => 'ok');
        }
    }
    public function xacthuccode()
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
        if (!empty($_POST['OTP_CODE'])) {
            $OTP_CODE = $_POST['OTP_CODE'];
        }
        if (!empty($_POST['email'])) {
            $email = strtolower(trim($_POST['email']));
        }
        if (empty($OTP_CODE) || empty($email)) {
            return array('errorCode' => 1, 'data' => array());
        }

        $this->db->select('USER_ID,OTP_CODE');
        $this->db->where(array(' Lower(EMAIL) ' => $email, 'OTP_CODE' => $OTP_CODE));
        $data = $this->db->get('TBL_USERS')->result_array();
        if (!empty($data)) {
            $data = $data[0];
            $this->db->where(array(' Lower(EMAIL) ' => $email, 'OTP_CODE' => $OTP_CODE));
            $this->db->update('TBL_USERS', array('STATUS' => 2));
            return array('errorCode' => 0, 'data' => $data);
        } else {
            return array('errorCode' => 2, 'data' => array());
        }
    }
    public function getUserId()
    {
        $arr = getallheaders();
        if (empty($arr['x-csrftoken'])) {
            return -1;
        }
        $TOKEN = $this->db->escape_str(trim($arr['x-csrftoken']));

        if (empty($TOKEN)) {
            return -1;
        }

        $this->db->select('USER_ID');
        $this->db->where(array('TOKEN' => $TOKEN));
        $row = $this->db->get('TBL_USERS')->row_array();

        if (empty($row['USER_ID'])) {
            return -1;
        }

        return $row['USER_ID'];
    }
    public function getUserInfo($arr = array())
    {
        $arrWhere = array();
        if (empty($arr)) {
            $_POST = json_decode(file_get_contents('php://input'), true);
            if (!empty($_POST['TOKEN'])) {
                $TOKEN = $_POST['TOKEN'];
            }

            $arrWhere['TOKEN'] = $TOKEN;
        } else {
            if (!empty($arr['EMAIL'])) {
                $arrWhere['Lower(EMAIL)'] = $arr['EMAIL'];
            }
            if (!empty($arr['PWD'])) {
                $arrWhere['PWD'] = md5($arr['PWD']);
            }
            if (!empty($arr['OTP_CODE'])) {
                $arrWhere['OTP_CODE'] = $arr['OTP_CODE'];
            }
        }

        if (empty($arrWhere)) {
            return array('errorCode' => 1, 'data' => array());
        }

        $this->db->select('a.USER_ID,a.FULLNAME,a.EMAIL,a.STATUS,a.TOKEN,a.TEL_NUM,a.BIRTHDAY,a.SEX,b.ORGANIZATION_ID,a.SOCIAL_ID,b.TYPE,b.STATUS as STATUS_ORGANIZATION');
        $this->db->from('TBL_USERS a');
        $this->db->join('AW_USER_ORGANIZATION b', 'b.USER_ID = a.USER_ID', 'left');
        $this->db->where($arrWhere);
        $data = $this->db->get()->result_array();

        if (!empty($data)) {
            $arr = array();
            foreach ($data as $row) {
                $arr[$row['TYPE']] = array(
                    'ORGANIZATION_ID' => $row['ORGANIZATION_ID'],
                    'STATUS_ORGANIZATION' => $row['STATUS_ORGANIZATION'],
                    'TYPE' => $row['TYPE'],
                );
            }
            $data = $data[0];
            $data['ORGANIZATION'] = $arr;
            $sql = 'select *
            from "TBL_PACKAGE_FOLLOWS_V2"
            where "USER_ID" = ' . $data['USER_ID'];
            $query = $this->db->query($sql);
            $data2 =  $query->result_array();
            $res = array();
            foreach ($data2 as $vl) {
                $k = $vl['IS_SUB_PACKAGE'] == 1 ? $vl['BID_PACKAGE_ID'] : ($vl['BID_PACKAGE_ID'] . '_0');
                $res[$k] = 1;
            }

            return array('errorCode' => 0, 'data' => $data, 'packageFollows' => $res);
        } else {
            return array('errorCode' => 2, 'data' => array(), 'packageFollows' => array());
        }
    }
    public function login()
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
        if (!empty($_POST['password'])) {
            $password = trim($_POST['password']);
        }
        if (!empty($_POST['email'])) {
            $email = $this->db->escape_str(strtolower(trim($_POST['email'])));
        }
        if (!empty($_POST['devicesId'])) {
            $devicesId = $this->db->escape_str(strtolower(trim($_POST['devicesId'])));
        }

        if (empty($password) || empty($email)) {
            return array('errorCode' => 1, 'data' => array());
        }

        $TOKEN = md5((microtime() . rand(10, 1000)));

        $res = $this->getUserInfo(array('EMAIL' => $email, 'PWD' => $password));
        if ($res['errorCode'] == 0) {
            $dataInsert = array(
                'TOKEN' => $TOKEN
            );
            if (!empty($devicesId)) {
                $dataInsert['DEVICES_ID'] = $devicesId;
            }
            $this->db->where('USER_ID', $res['data']['USER_ID']);
            $this->db->update('TBL_USERS', $dataInsert);
            $res['data']['TOKEN'] = $TOKEN;
        }

        return $res;
    }
    public function register()
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
        if (!empty($_POST['password'])) {
            $password = trim($_POST['password']);
        }
        if (!empty($_POST['full_name'])) {
            $full_name = $this->db->escape_str($_POST['full_name']);
        }
        if (!empty($_POST['email'])) {
            $email = $this->db->escape_str(strtolower(trim($_POST['email'])));
        }
        $devicesId = '';
        if (!empty($_POST['devicesId'])) {
            $devicesId = $this->db->escape_str(strtolower(trim($_POST['devicesId'])));
        }

        if (empty($password) || empty($full_name) || empty($email)) {
            return array('errorCode' => 1, 'data' => array());
        } else if (count(explode('@', $email)) != 2) {
            return array('errorCode' => 2, 'data' => array());
        }
        //check acount exits
        $this->db->select('EMAIL');
        $this->db->where(' Lower(EMAIL) ', $email);
        $data = $this->db->get('TBL_USERS')->result_array();
        if (!empty($data)) {
            return array('errorCode' => 3, 'data' => array());
        }

        $TOKEN = md5((microtime() . rand(10, 1000)));
        $OTP_CODE = strtoupper(substr($TOKEN, 0, 6));
        $this->sendMaXacThuc($email, $OTP_CODE);
        // $arrInsert = array(
        //         'FULLNAME'=>$full_name,
        //         'EMAIL'=>$email,
        //         'PWD'=>md5($password),
        //         'TOKEN'=>$TOKEN,
        //         'OTP_CODE'=>$OTP_CODE,
        // );
        // $this->db->insert('TBL_USERS',$arrInsert);
        $sql = 'insert into TBL_USERS(USER_ID,FULLNAME,EMAIL,PWD,TOKEN,OTP_CODE,DEVICES_ID) 
            values(NVL((SELECT MAX("USER_ID") FROM "TBL_USERS"),0)+1 , 
            \'' . $full_name . '\', \'' . $email . '\', \'' . md5($password) . '\', \'' . $TOKEN . '\',\'' . $OTP_CODE . '\',\'' . $devicesId . '\')';
        $this->db->query($sql);

        $this->db->select('USER_ID');
        $this->db->where('EMAIL', $email);
        $data1 = $this->db->get('TBL_USERS')->result_array();

        return array('errorCode' => 0, 'data' => array(
            'USER_ID' => $data1[0]['USER_ID'],
            'FULLNAME' => $full_name,
            'TOKEN' => $TOKEN,
            'EMAIL' => $email,
            'TEL_NUM' => '',
            'BIRTHDAY' => '',
            'SEX' => ''
        ));
    }

    public function loginFacebook()
    {
        //email, social_id,full_name, phone
        $_POST = json_decode(file_get_contents('php://input'), true);
        if (!empty($_POST['social_id'])) {
            $social_id = $this->db->escape_str(trim($_POST['social_id']));
        }
        if (!empty($_POST['full_name'])) {
            $full_name = $this->db->escape_str($_POST['full_name']);
        }
        if (!empty($_POST['email'])) {
            $email = $this->db->escape_str(strtolower(trim($_POST['email'])));
        }
        $phone = '';
        if (!empty($_POST['phone'])) {
            $phone = $this->db->escape_str(strtolower(trim($_POST['phone'])));
        }
        $devicesId = '';
        if (!empty($_POST['devicesId'])) {
            $devicesId = $this->db->escape_str(strtolower(trim($_POST['devicesId'])));
        }

        if (empty($social_id) || empty($full_name) || empty($email)) {
            return array('errorCode' => 1, 'data' => array());
        } else if (count(explode('@', $email)) != 2) {
            return array('errorCode' => 2, 'data' => array());
        }

        //check xem tai khoan da tung duoc dang ky chua.
        //neu chua thì đăng ký.
        //neu rồi thì so sánh update token va tra ve thong tin
        $TOKEN = md5((microtime() . rand(10, 1000)));

        $res = $this->getUserInfo(array('EMAIL' => $email));
        if ($res['errorCode'] == 0 && ($social_id == $res['data']['SOCIAL_ID'] || empty($res['data']['SOCIAL_ID']))) {
            // $data = $res['data'];
            $dataInsert = array(
                'TOKEN' => $TOKEN,
                'SOCIAL_ID' => $social_id
            );
            if (!empty($devicesId)) {
                $dataInsert['DEVICES_ID'] = $devicesId;
            }
            $this->db->where('USER_ID', $res['data']['USER_ID']);
            $this->db->update('TBL_USERS', $dataInsert);

            $res['data']['TOKEN'] = $TOKEN;

            return $res;
        } else if ($res['errorCode'] != 0) {
            //insert data
            $sql = 'insert into TBL_USERS(USER_ID,FULLNAME,EMAIL,TOKEN,LOGIN_TYPE,TEL_NUM,SOCIAL_ID,DEVICES_ID,STATUS) 
                values(NVL((SELECT MAX("USER_ID") FROM "TBL_USERS"),0)+1 , 
                \'' . $full_name . '\', \'' . $email . '\', \'' . $TOKEN . '\',2,\'' . $phone . '\',\'' . $social_id . '\',\'' . $devicesId . '\',1)';
            $this->db->query($sql);

            $this->db->select('USER_ID,FULLNAME,EMAIL,STATUS,SOCIAL_ID,TEL_NUM,BIRTHDAY,SEX');
            $this->db->where(array(' Lower(EMAIL) ' => $email));
            $data = $this->db->get('TBL_USERS')->result_array();
            $data = $data[0];
            $data['TOKEN'] = $TOKEN;
            return array('errorCode' => 0, 'data' => $data, 'packageFollows' => array());
        } else {
            return array('errorCode' => 3, 'data' => array(), 'packageFollows' => array());
        }
    }

    public function updateUserInfo()
    {
        $arr = getallheaders();
        if (empty($arr['x-csrftoken'])) {
            return array(
                'error' => 1,
                'msg' => 'Không lấy được giá trị TOKEN truyền lên.',
                'data' => ''
            );
        }
        $token = $this->db->escape_str(trim($arr['x-csrftoken']));

        $_POST = json_decode(file_get_contents('php://input'), true);
        $data = array();
        if (!empty($_POST['bod'])) {
            $data[] = ' BIRTHDAY = TO_DATE(\'' . $this->db->escape_str(trim($_POST['bod'])) . '\',\'yyyy-MM-dd\') ';
        }
        if (!empty($_POST['phone'])) {
            $data[] = ' TEL_NUM = \'' . $this->db->escape_str($_POST['phone']) . '\' ';
        }
        if (!empty($data)) {
            $sql = 'update TBL_USERS set ' . join($data, ',') . '
                where TOKEN=\'' . $token . '\'';
            $this->db->query($sql);

            return array(
                'error' => 0,
                'msg' => 'OK',
                'data' => ''
            );
        } else {
            return array(
                'error' => 1,
                'msg' => 'Không nhận được giá trị update.',
                'data' => ''
            );
        }
    }

    public function GetListLocation()
    {
        $sql = "select a.ID,a.NAME 
            from TBL_LOCATIONS a
            order by ID ";
        $query = $this->db->query($sql);
        $data =  $query->result_array();
        $res = array();
        foreach ($data as $vl) {
            $res[] = array('label' => $vl['NAME'], 'value' => $vl['NAME'], 'ID' => $vl['ID']);
        }
        return $res;
    }
    private function getNewsHighlights()
    {
        $where = '';
        if (!empty($_GET['keySearch'])) {
            $_GET['keySearch'] = $this->db->escape_str(trim($_GET['keySearch']));
            $where = " and  a1.\"TITLE\" like '%" . $_GET['keySearch'] . "%' ";
        }
        $sql = "SELECT a.*, rownum r__ 
            FROM ( 
                select a1.\"ID\" as \"a1-zn-ID\",  a1.\"TITLE\" as \"a1-zn-TITLE\", 
                    a1.\"IMG\" as \"a1-zn-IMG\",  a1.\"DATE_SUBMITTED\" as \"a1-zn-DATE_SUBMITTED\",  a1.\"COUNT_VIEW\" as \"a1-zn-COUNT_VIEW\",  a1.\"SHORT_DESCRIPTION\" as \"a1-zn-SHORT_DESCRIPTION\",  a1.\"STATUS\" as \"a1-zn-STATUS\",  a1.\"HIGHLIGHTS\" as \"a1-zn-HIGHLIGHTS\"  
                from \"NEWS\" a1
                where a1.\"STATUS\" =  '1' and a1.\"IMG\" is not null " . $where . " 
                order by  a1.\"HIGHLIGHTS\" desc,  a1.\"ID\" desc 
            ) a 
            WHERE rownum <  6 ";

        $query = $this->db->query($sql);
        $data =  $query->result_array();
        return $data;
    }
    public function GetListNews()
    {
        $where = '';
        if (!empty($_GET['keySearch'])) {
            $_GET['keySearch'] = $this->db->escape_str(trim($_GET['keySearch']));
            $where = " and  a1.\"TITLE\" like '%" . $_GET['keySearch'] . "%' ";
        }

        $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $sql = "SELECT * FROM ( 
                SELECT a.*, rownum r__ 
                FROM ( 
                    select a1.\"ID\" as \"a1-zn-ID\",  a1.\"TITLE\" as \"a1-zn-TITLE\", 
                        a1.\"IMG\" as \"a1-zn-IMG\",  a1.\"DATE_SUBMITTED\" as \"a1-zn-DATE_SUBMITTED\",  a1.\"COUNT_VIEW\" as \"a1-zn-COUNT_VIEW\",  a1.\"SHORT_DESCRIPTION\" as \"a1-zn-SHORT_DESCRIPTION\",  a1.\"STATUS\" as \"a1-zn-STATUS\",  a1.\"HIGHLIGHTS\" as \"a1-zn-HIGHLIGHTS\"  
                    from \"NEWS\" a1
                    where a1.\"STATUS\" =  '1' and a1.\"IMG\" is not null " . $where . " 
                    order by  a1.\"HIGHLIGHTS\" desc,  a1.\"ID\" desc 
                ) a 
                WHERE rownum < ((" . $page . " * 5) + 6 ) 
            ) WHERE r__ >= (((" . $page . "-1) * 5) + 6)";

        $query = $this->db->query($sql);
        $data =  $query->result_array();
        $newsHighlights = array();
        if ($page == 1) {
            $newsHighlights = $this->getNewsHighlights();
        }
        return array('data' => $data, 'newsHighlights' => $newsHighlights);
    }
    public function NewsDetail()
    {
        $_getSegment = $this->_getSegment;
        if (!empty($_getSegment[2])) {
            $_getSegment[2] = $this->db->escape_str($_getSegment[2]);
        } else {
            $_getSegment[2] = "";
        }
        $sql = "select  a1.\"ID\" as \"a1-zn-ID\",  a1.\"TITLE\" as \"a1-zn-TITLE\",  a1.\"IMG\" as \"a1-zn-IMG\",  
                a1.\"EDITOR\" as \"a1-zn-EDITOR\", a1.\"DATE_SUBMITTED\" as \"a1-zn-DATE_SUBMITTED\",  
                a1.\"COUNT_VIEW\" as \"a1-zn-COUNT_VIEW\",  a1.\"SHORT_DESCRIPTION\" as \"a1-zn-SHORT_DESCRIPTION\",  
                to_char(substr(a1.\"POST\",0,3000)) as \"a1-zn-POST\", 
                to_char(substr(a1.\"POST\",3001,3000)) as \"a1-zn-POST1\", 
                to_char(substr(a1.\"POST\",6001,3000)) as \"a1-zn-POST2\",
                to_char(substr(a1.\"POST\",9001,3000)) as \"a1-zn-POST3\",
                a1.\"STATUS\" as \"a1-zn-STATUS\" ,a1.SOURCE_URL
            from \"NEWS\" a1 
            where  '" . $_getSegment[2] . "'  = a1.\"ID\"";
        $query = $this->db->query($sql);
        $data =  $query->result_array();

        //update count view news
        $_GET['ID'] = $_getSegment[2];
        $this->updateViewNews();
        if (!empty($data[0])) {
            $data[0]['a1-zn-POST'] = $data[0]['a1-zn-POST'] . $data[0]['a1-zn-POST1'] . $data[0]['a1-zn-POST2'] . $data[0]['a1-zn-POST3'];
        }
        return $data;
    }

    public function newsInvolve()
    {
        if (!isset($_NewsDetail)) {
            $_NewsDetail = $this->NewsDetail();
        }
        if (empty($_NewsDetail[0]["a1-zn-ID"])) {
            $_POST["NewsDetail-0-a1-zn-ID"] = "";
        } else {
            $_POST["NewsDetail-0-a1-zn-ID"] = $this->db->escape_str($_NewsDetail[0]["a1-zn-ID"]);
        }

        $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $sql = "SELECT * FROM ( 
            SELECT a.*, rownum r__ 
            FROM ( 
                select DISTINCT a1.\"ID\" as \"a1-zn-ID\",  a1.\"TITLE\" as \"a1-zn-TITLE\",  
                    a1.\"IMG\" as \"a1-zn-IMG\",  a1.\"COUNT_VIEW\" as \"a1-zn-COUNT_VIEW\" ,
                    a1.DATE_SUBMITTED as \"a1-zn-DATE_SUBMITTED\"
                from \"NEWS\" a1 
                left join \"AW_NEWS_KEYTAG\" a2  on a2.\"NEWS_ID\" = a1.\"ID\" 
                left join \"AW_NEWS_KEYTAG\" a3  on a3.\"KEY_TAG_ID\" = a2.\"KEY_TAG_ID\" 
                where a1.\"IMG\" is not null and '" . $_POST['NewsDetail-0-a1-zn-ID'] . "'  = a3.\"NEWS_ID\" and  '1'  = a1.\"STATUS\" 
                    and a1.\"ID\" !=  '" . $_POST['NewsDetail-0-a1-zn-ID'] . "'  
                    order by  a1.\"ID\" desc
            ) a 
            WHERE rownum < ((" . $page . " * 5) + 1 ) 
        ) WHERE r__ >= (((" . $page . "-1) * 5) + 1)";

        $query = $this->db->query($sql);
        $data =  $query->result_array();
        return $data;
    }
    public function TopNhaThauDuThau()
    {

        $sql = 'select * 
        from (select a1."BIDER_NAME" as "a1-zn-BIDER_NAME",  
            a1."BUSSINESS_REGISTRATION_NUM" as "a1-BUSSINESS_REGISTRATION_NUM",  
            a1."BUSSINESS_REGISTRATION_DATE" as "a1-BUSSINESS_REGISTRATION_DATE",  
            a1."TAXNUMBER" as "a1-zn-TAXNUMBER",  a1."TEL_NUM" as "a1-zn-TEL_NUM",  
            to_char(a1."APPROVAL_DATE", \'yyyy-mm-dd hh24:mi:ss\') as "a1-zn-APPROVAL_DATE",  
            a1."FAX_NUM" as "a1-zn-FAX_NUM",  
            a1."PROVINCE" as "a1-zn-PROVINCE",  
            TO_CHAR(a1."WEBSITE") as "a1-zn-WEBSITE",  
            a1."ADDRESS" as "a1-zn-ADDRESS",  a1."BUSSINESS_FIELD" as "a1-zn-BUSSINESS_FIELD",  
            a1."BIDER_EN_NAME" as "a1-zn-BIDER_EN_NAME",  a1."BUSSINESS_TYPE" as "a1-zn-BUSSINESS_TYPE",
            a3.count_
        from "TBL_BIDERS" a1
        inner join (
            select b1.*
            from (
                select BID_BUSSINESS_REGISTRATION_NUM, COUNT(BID_BUSSINESS_REGISTRATION_NUM) as count_
                from "TBL_BIDINGS" 
                where APPROVAL_DATE > TO_DATE(\'' . date('Y-01-01') . '\',\'yyyy-MM-dd\')  
                group by BID_BUSSINESS_REGISTRATION_NUM
                order by count_ desc 
            ) b1
            where rownum <100
        ) a3 on a3.BID_BUSSINESS_REGISTRATION_NUM = a1.BUSSINESS_REGISTRATION_NUM
        /*where a1."ADDRESS" is not null and a1."TEL_NUM" is not null*/
        order by count_ desc
        )
        where rownum <6';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function listBiders()
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $where = array();
        if (!empty($_GET['keySearch'])) {
            $_GET['keySearch'] = $this->db->escape_str(trim($_GET['keySearch']));
            $where[] = " (
                Lower(a1.\"BIDER_NAME\") like '%" . $_GET['keySearch'] . "%' 
                or a1.\"BUSSINESS_REGISTRATION_NUM\" like '%" . strtoupper($_GET['keySearch']) . "%' 
            )";
        }

        if (!empty($_POST['from_date'])) {
            $where[] = " a1.\"BUSSINESS_REGISTRATION_DATE\" >= TO_DATE('" . $_POST['from_date'] . "','yyyy-MM-dd') ";
        }
        if (!empty($_POST['to_date'])) {
            $where[] = " a1.\"BUSSINESS_REGISTRATION_DATE\" <= TO_DATE('" . $_POST['to_date'] . "','yyyy-MM-dd') ";
        }

        if (!empty($_POST['localtion'])) {
            $where[] = " a1.\"PROVINCE\" like '%" . $_POST['localtion'] . "%' ";
        }

        if (!empty($_GET['BUSSINESS_FIELD'])) {
            $_GET['BUSSINESS_FIELD'] = $this->db->escape_str(trim($_GET['BUSSINESS_FIELD']) . ',');
        }
        $join = '';
        $select = '';
        $orderBy = '';
        if (!empty($_GET['type']) && $_GET['type'] == 'topBider') {
            $join = ' left join (
                select b1.*
                from (
                    select BID_BUSSINESS_REGISTRATION_NUM, COUNT(BID_BUSSINESS_REGISTRATION_NUM) as count_
                    from "TBL_BIDINGS" 
                    where APPROVAL_DATE > TO_DATE(\'' . date('Y-01-01') . '\',\'yyyy-MM-dd\')  
                    group by BID_BUSSINESS_REGISTRATION_NUM
                    order by count_ desc 
                ) b1
                where rownum <100
            ) a3 on a3.BID_BUSSINESS_REGISTRATION_NUM = a1.BUSSINESS_REGISTRATION_NUM ';
            $select = 'a3.count_, ';
            $orderBy = ' NVL(count_,0) desc, ';
        }

        if (!empty($where)) {
            $where = ' where ' . join(' and ', $where);
        } else {
            $where = '';
        }
        $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $sql = "SELECT * FROM ( 
            SELECT a.*, rownum r__ 
            FROM ( 
                select " . $select . " a1.\"BIDER_NAME\" as \"a1-zn-BIDER_NAME\",  
                    a1.\"BUSSINESS_REGISTRATION_NUM\" as \"a1-BUSSINESS_REGISTRATION_NUM\",  
                    a1.\"BUSSINESS_REGISTRATION_DATE\" as \"a1-BUSSINESS_REGISTRATION_DATE\",  
                    a1.\"TAXNUMBER\" as \"a1-zn-TAXNUMBER\",  a1.\"TEL_NUM\" as \"a1-zn-TEL_NUM\",  
                    to_char(a1.\"APPROVAL_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-APPROVAL_DATE\",  
                    a1.\"FAX_NUM\" as \"a1-zn-FAX_NUM\",  
                    a1.\"PROVINCE\" as \"a1-zn-PROVINCE\",  
                    to_char(a1.\"WEBSITE\") as \"a1-zn-WEBSITE\",  
                    a1.\"ADDRESS\" as \"a1-zn-ADDRESS\",  a1.\"BUSSINESS_FIELD\" as \"a1-zn-BUSSINESS_FIELD\",  
                    a1.\"BIDER_EN_NAME\" as \"a1-zn-BIDER_EN_NAME\",  a1.\"BUSSINESS_TYPE\" as \"a1-zn-BUSSINESS_TYPE\"
                from \"TBL_BIDERS\" a1
                " . $join
            . $where . "
                ORDER BY " . $orderBy . " NVL(a1.\"APPROVAL_DATE\",TO_DATE('1111-01-01','yyyy-MM-dd')) desc
            ) a 
            WHERE rownum < ((" . $page . " * 100) + 1 ) 
        ) WHERE r__ >= (((" . $page . "-1) * 100) + 1)";
        $query = $this->db->query($sql);
        $data =  $query->result_array();
        return $data;
    }

    public function detailBiders()
    {
        $_getSegment = $this->_getSegment;
        if (!empty($_getSegment[2])) {
            $_getSegment[2] = $this->db->escape_str($_getSegment[2]);
        } else {
            $_getSegment[2] = "";
        }
        //update count view 
        $sql = 'update "TBL_BIDERS" set "COUNT_VIEW"=NVL("COUNT_VIEW",0) +1 where  \'' . $_getSegment[2] . '\'  = "BUSSINESS_REGISTRATION_NUM"';
        $this->db->query($sql);
        //end: update count view 

        $sql = "select a1.COMPANY_STATUS,
                    a1.\"BUSSINESS_REGISTRATION_NUM\" as \"a1-BUSSINESS_REGISTRATION_NUM\", a1.COUNT_VIEW, 
                    to_char(a1.\"BUSSINESS_REGISTRATION_DATE\", 'yyyy-mm-dd hh24:mi:ss')  as \"a1-BUSSINESS_REGISTRATION_DATE\",  a1.\"BIDER_NAME\" as \"a1-zn-BIDER_NAME\",  a1.\"BIDER_EN_NAME\" as \"a1-zn-BIDER_EN_NAME\",  a1.\"BUSSINESS_FIELD\" as \"a1-zn-BUSSINESS_FIELD\",  a1.\"BUSSINESS_TYPE\" as \"a1-zn-BUSSINESS_TYPE\",  a1.\"TEL_NUM\" as \"a1-zn-TEL_NUM\",  a1.\"FAX_NUM\" as \"a1-zn-FAX_NUM\",  a1.\"AUTHORIZED_CAPITAL\" as \"a1-zn-AUTHORIZED_CAPITAL\",  a1.\"PROVINCE\" as \"a1-zn-PROVINCE\",  a1.\"ADDRESS\" as \"a1-zn-ADDRESS\",  a1.\"COUNTRY\" as \"a1-zn-COUNTRY\",  a1.\"EMPLOYEE_NUM\" as \"a1-zn-EMPLOYEE_NUM\",  to_char(a1.\"WEBSITE\") as \"a1-zn-WEBSITE\",  a1.\"WORKING_NAME\" as \"a1-zn-WORKING_NAME\",  
                    to_char(a1.\"APPROVAL_DATE\", 'yyyy-mm-dd hh24:mi:ss')  as \"a1-zn-APPROVAL_DATE\",  
                    to_char(a1.\"EFFECTIVE_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-EFFECTIVE_DATE\",  a1.\"TAXNUMBER\" as \"a1-zn-TAXNUMBER\",  a1.\"LEADER_EMAIL\" as \"a1-zn-LEADER_EMAIL\",  a1.\"CURATOR_EMAIL\" as \"a1-zn-CURATOR_EMAIL\",  a1.\"AGENT_NAME\" as \"a1-zn-AGENT_NAME\"  
                from \"TBL_BIDERS\" a1 
                where  '" . $_getSegment[2] . "'  = a1.\"BUSSINESS_REGISTRATION_NUM\"";
        $query = $this->db->query($sql);
        $data =  $query->result_array();
        return $data;
    }
    public function listProcurings()
    {
        $_POST = json_decode(file_get_contents('php://input'), true);

        $where = array();
        if (!empty($_GET['keySearch'])) {
            $_GET['keySearch'] = $this->db->escape_str(trim($_GET['keySearch']));
            $where[] = " (
                Lower(a1.\"PROCURING_NAME\") like '%" . $_GET['keySearch'] . "%'
                or a1.\"PROCURING_CODE\" like '%" . strtoupper($_GET['keySearch']) . "%'
            ) ";
        }

        if (!empty($_POST['from_date'])) {
            $where[] = " a1.\"APPROVAL_DATE\" >= TO_DATE('" . $_POST['from_date'] . "','yyyy-MM-dd') ";
        }
        if (!empty($_POST['to_date'])) {
            $where[] = " a1.\"APPROVAL_DATE\" <= TO_DATE('" . $_POST['to_date'] . "','yyyy-MM-dd') ";
        }

        if (!empty($_POST['localtion'])) {
            $where[] = " a1.\"PROVINCE\" like '%" . $_POST['localtion'] . "%' ";
        }

        if (!empty($_GET['bussiness_type'])) {
            $_GET['bussiness_type'] = $this->db->escape_str($_GET['bussiness_type']);
        } else {
            $_GET['bussiness_type'] = "";
        }

        if ($_GET['bussiness_type'] !== '') {
            // bo find theo type
            //  $where[] = " '".$_GET['bussiness_type'] . "'  = a1.\"BUSSINESS_TYPE\") ";
        }

        if (!empty($where)) {
            $where = ' and ' . join(' and ', $where);
        } else {
            $where = '';
        }
        $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $sql = "SELECT * FROM ( 
            SELECT a.*, rownum r__ 
            FROM ( 
                select a1.\"PROCURING_CODE\" as \"a1-zn-PROCURING_CODE\", 
                     a1.\"PROCURING_NAME\" as \"a1-zn-PROCURING_NAME\",  a1.\"ADDRESS\" as \"a1-zn-ADDRESS\",  
                     a1.\"TEL_NUM\" as \"a1-zn-TEL_NUM\",  
                     a1.\"PROVINCE\" as \"a1-zn-PROVINCE\",
                     to_char(a1.\"APPROVAL_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-APPROVAL_DATE\",
                     a1.\"STATUS\"
                from \"TBL_PROCURINGS\" a1 
                where (a1.\"STATUS\" = 'Y' OR a1.\"STATUS\" = 'N') " . $where . "
                ORDER BY NVL(a1.\"APPROVAL_DATE\",TO_DATE('1111-01-01','yyyy-MM-dd')) desc
            ) a 
            WHERE rownum < ((" . $page . " * 100) + 1 ) 
        ) WHERE r__ >= (((" . $page . "-1) * 100) + 1)";
        echo $sql;
        $query = $this->db->query($sql);
        $data =  $query->result_array();
        return $data;
    }
    public function procuringsDetail()
    {
        $_getSegment = $this->_getSegment;
        if (!empty($_getSegment[2])) {
            $_getSegment[2] = $this->db->escape_str($_getSegment[2]);
        } else {
            $_getSegment[2] = "";
        }
        //SUBORDINATE_TYPE: phân loại trực thuộc - DB đang thiếu 
        $sql = "select  '' as SUBORDINATE_TYPE,
                    a1.\"PROCURING_CODE\" as \"a1-zn-PROCURING_CODE\",  a1.\"PROCURING_NAME\" as \"a1-zn-PROCURING_NAME\",  
                    a1.\"BRIEF_NAME\" as \"a1-zn-BRIEF_NAME\",  a1.\"PROCURING_EN_NAME\" as \"a1-zn-PROCURING_EN_NAME\",  
                    a1.\"BUSSINESS_REGISTRATION_NUM\" as \"a1-BUSSINESS_REGISTRATION_NUM\",  
                    a1.\"DIRECTLY_TYPE\" as \"a1-zn-DIRECTLY_TYPE\",  a1.\"AGENCY_TYPE\" as \"a1-zn-AGENCY_TYPE\",  
                    a1.\"PROVINCE\" as \"a1-zn-PROVINCE\",  a1.\"ADDRESS\" as \"a1-zn-ADDRESS\",  
                    a1.\"TEL_NUM\" as \"a1-zn-TEL_NUM\",  a1.\"FAX_NUM\" as \"a1-zn-FAX_NUM\",  
                    to_char(a1.\"WEBSITE\") as \"a1-zn-WEBSITE\", a1.TAX_NUM as \"a1-zn-TAX_NUM\"
                from \"TBL_PROCURINGS\" a1 where  '" . $_getSegment[2] . "'  = a1.\"PROCURING_CODE\"";
        $query = $this->db->query($sql);
        $data =  $query->result_array();
        return $data;
    }

    public function listBiderSelections()
    {
        $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $where = ' where NVL(a1."BID_NUM",0) > 0 and a1."CREATE_DATE" is not null ';
        if (!empty($_GET['keySearch'])) {
            $_GET['keySearch'] = $this->db->escape_str(trim($_GET['keySearch']));
            $where .= " and (a1.\"NAME\" like '%" . $_GET['keySearch'] . "%' or a1.\"INVESTORS\" like '%" . $_GET['keySearch'] . "%' or a1.\"BIDER_SELECTION_ID\" like '%" . $_GET['keySearch'] . "%') ";
        }

        //check dieu kien cho trang thong ke
        if (!empty($_GET['time']) && $_GET['time'] == '1d') {
            //CREATE_DATE
            $where .= " and a1.\"CREATE_DATE\" >= TO_DATE('" . date("Y-m-d") . "','yyyy-MM-dd') ";
        } else {
            $where .= " and a1.\"CREATE_DATE\" > TO_DATE('" . date("Y-01-01") . "','yyyy-MM-dd') ";
        }

        $sql = "SELECT * FROM
                (
                    SELECT a.*, rownum r__
                    FROM
                    (
                        select a1.\"BIDER_SELECTION_ID\" as \"a1-zn-BIDER_SELECTION_ID\", 
                        TO_CHAR(a1.\"NAME\") as \"a1-zn-NAME\",  a1.\"INVESTORS\" as \"a1-zn-INVESTORS\",  
                        a1.\"VERSION_NUM\" as \"a1-zn-VERSION_NUM\",  a1.\"BID_NUM\" as \"a1-zn-BID_NUM\", 
                        a1.\"VALUE\" as \"a1-zn-VALUE\",  
                        to_char(a1.\"CREATE_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-CREATE_DATE\",
                        NVL(a1.\"COUNT_VIEW\",0) as \"COUNT_VIEW\",
                        (SELECT a2.\"LOCATION\" as \"a2-zn-LOCATION\" from \"TBL_PACKAGE_INFO\" a2 where a1.\"BIDER_SELECTION_ID\" = a2.\"CODE\" and rownum = 1 ) as LOCATION,
                        a1.\"PROCURING_CODE\"

                        from \"TBL_BIDER_SELECTIONS\" a1 
                        -- left join ( 
                        --         select \"CODE\",MAX(\"ID\") as \"ID\"
                        --         from \"TBL_PACKAGE_INFO\" 
                        --         group by CODE
                        -- ) a2 on a1.\"BIDER_SELECTION_ID\" = a2.\"CODE\" 
                        -- left join \"TBL_PACKAGE_INFO\"  a5 on a5.\"ID\"=a2.\"ID\"
                        " . $where . "
                        order by  a1.\"CREATE_DATE\" desc
                    ) a
                    WHERE rownum < ((" . $page . " * 100) + 1 )
                )
                WHERE r__ >= (((" . $page . "-1) * 100) + 1)";

        if (!empty($_GET['s_test'])) {
            echo $sql;
        }
        $query = $this->db->query($sql);
        $data =  $query->result_array();
        // print_r($data);
        return $data;
    }
    public function biderSelectionsDetail()
    {
        $_getSegment = $this->_getSegment;
        if (!empty($_getSegment['2'])) {
            $_getSegment['2'] = $this->db->escape_str($_getSegment['2']);
        } else {
            $_getSegment['2'] = "";
        }
        $sql = "select  to_char(a1.\"NAME\") as \"a1-zn-NAME\",  a1.\"BIDER_SELECTION_ID\" as \"a1-zn-BIDER_SELECTION_ID\",  
                        a1.\"VERSION_NUM\" as \"a1-zn-VERSION_NUM\",  a2.\"PROCURING_NAME\" as \"a2-zn-PROCURING_NAME\",  
                        a1.\"INVESTORS\" as \"a1-zn-INVESTORS\",  a1.\"TYPE\" as \"a1-zn-TYPE\",  
                        a1.\"APPROVAL_STATUS\" as \"a1-zn-APPROVAL_STATUS\",  a1.\"VALUE\" as \"a1-zn-VALUE\",  
                        a1.\"APPROVAL_OFFICE\" as \"a1-zn-APPROVAL_OFFICE\",  
                        a1.\"APPROVAL_DOC_NUM\" as \"a1-zn-APPROVAL_DOC_NUM\",  
                        to_char(a1.\"APPROVAL_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-APPROVAL_DATE\",
                        to_char(a1.\"CREATE_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-CREATE_DATE\",
                        a2.\"PROVINCE\" as \"PROVINCE\",
                        a1.\"PROCURING_CODE\"
                from \"TBL_BIDER_SELECTIONS\" a1 
                left join \"TBL_PROCURINGS\" a2  on a2.\"PROCURING_CODE\" = a1.\"PROCURING_CODE\" 
                where  '" . $_getSegment['2'] . "'  = a1.\"BIDER_SELECTION_ID\"";

        $query = $this->db->query($sql);
        $data =  $query->result_array();
        $_GET['ID'] = $_getSegment['2'];
        $this->updateViewKHLCNT();
        return $data;
    }

    public function biderSelections_packageInfo()
    {
        $_getSegment = $this->_getSegment;
        if (!empty($_getSegment['2'])) {
            $_getSegment['2'] = $this->db->escape_str($_getSegment['2']);
        } else {
            $_getSegment['2'] = "";
        }
        $sql = "select  a1.\"ID\" as \"a1-zn-ID\",  a1.\"CODE\" as \"a1-zn-CODE\",  
                a1.\"PACKAGE_NAME\" as \"a1-zn-PACKAGE_NAME\",  
                a1.\"BIDER_SELECTION_TYPE\" as \"a1-zn-BIDER_SELECTION_TYPE\",  
                a1.\"VALUE\" as \"a1-zn-VALUE\",  a1.\"INTERNET\" as \"a1-zn-INTERNET\",  
                a1.\"SELECTION_TIME\" as \"a1-zn-SELECTION_TIME\",  a1.\"LOCATION\" as \"a1-zn-LOCATION\",  
                a1.\"BID_TYPE\" \"as-zn-BID_TYPE\",

                a1.\"FUNDING_SOURCE\" as \"a1-zn-FUNDING_SOURCE\"  from \"TBL_PACKAGE_INFO\" a1 where  '" . $_getSegment['2'] . "'  = a1.\"CODE\"";
        $query = $this->db->query($sql);
        $data =  $query->result_array();
        return $data;
    }
    public function packageInfo_detail()
    {
        $_getSegment = $this->_getSegment;
        if (!empty($_getSegment[2])) {
            $_getSegment[2] = $this->db->escape_str($_getSegment[2]);
        } else {
            $_getSegment[2] = "";
        }
        $sql = "select  a1.\"ID\" as \"a1-zn-ID\",  a1.\"PACKAGE_NUM\" as \"a1-zn-PACKAGE_NUM\",  
                a1.\"VERSION\" as \"a1-zn-VERSION\",  a1.\"PACKAGE_NAME\" as \"a1-zn-PACKAGE_NAME\",  
                a1.\"VALUE\" as \"a1-zn-VALUE\",  a1.\"FUNDING_SOURCE\" as \"a1-zn-FUNDING_SOURCE\",  
                a1.\"BIDER_SELECTION_TYPE\" as \"a1-zn-BIDER_SELECTION_TYPE\",  
                a1.\"SELECTION_TIME\" as \"a1-zn-SELECTION_TIME\",  a1.\"EXCUTE_TIME\" as \"a1-zn-EXCUTE_TIME\",
                a1.\"CONTRACT_TYPE\",
                a1.\"BID_TYPE\",
                a2.\"BID_PACKAGE_ID\",
                a3.\"BIDING_ID\",
                a2.\"CODELINK\"
            from \"TBL_PACKAGE_INFO\" a1 
            left join \"TBL_BID_PACKAGES\" a2 on a1.\"CODE\"=a2.\"CODEKH\"
            left join \"TBL_BIDINGS\" a3 on a2.\"BID_PACKAGE_CODE\" = a3.\"BID_PACKAGE_CODE\"
            where  '" . $_getSegment[2] . "'  = a1.\"ID\"";
        $query = $this->db->query($sql);
        $data =  $query->result_array();
        return $data;
    }
    public function listBidings()
    {
        // $startLimit = (int) (empty($_GET['page'])  ? 0 : (($_GET['page'] - 1)  * 20));
        $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $BUSSINESS_FIELD = empty($_GET['BUSSINESS_FIELD']) ? 'hang-hoa' : $this->db->escape_str(trim($_GET['BUSSINESS_FIELD']));
        $where = '';
        if (!empty($_GET['keySearch'])) {
            $_GET['keySearch'] = $this->db->escape_str(trim($_GET['keySearch']));
            $where = " and  (a1.\"PROCURING_NAME\" like '%" . $_GET['keySearch'] . "%'
                                    or a1.\"PACKAGE_NAME\" like '%" . $_GET['keySearch'] . "%'
                                    or a1.\"BID_PACKAGE_CODE\" like '%" . $_GET['keySearch'] . "%')
                                    ";
        }

        $sql = "SELECT * FROM ( 
                    SELECT a.*, rownum r__ 
                    FROM ( 
                        select  a1.\"BIDING_ID\" as \"a1-zn-BIDING_ID\",  a1.\"PROCURING_NAME\" as \"a1-zn-PROCURING_NAME\",  a1.\"PACKAGE_NAME\" as \"a1-zn-PACKAGE_NAME\",  a1.\"PROJECT_NAME\" as \"a1-zn-PROJECT_NAME\",  
                        to_char(a1.\"FINISH_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-FINISH_DATE\",  a1.\"VERSION\" as \"a1-zn-VERSION\",  
                        to_char(a1.\"PUBLIC_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-PUBLIC_DATE\",  a1.\"NOTI_TYPE\" as \"a1-zn-NOTI_TYPE\",  
                        a1.\"BID_TYPE\" as \"a1-zn-BID_TYPE\",  a1.COUNT_VIEW,
                        a1.\"NOTI_TYPE\" as \"a2-zn-PREQUALIFICATION_STATUS\",  
                        to_char(a1.\"APPROVAL_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-APPROVAL_DATE\",  
                        a1.\"BIDER_NAME\" as \"a1-zn-BIDER_NAME\",  a1.\"BID_PACKAGE_CODE\" as \"a1-zn-BID_PACKAGE_CODE\",  
                        a1.\"PRICE_BIDING\" as \"a1-zn-PRICE_BIDING\",  a1.\"PRICE_ACCEPT\" as \"a1-zn-PRICE_ACCEPT\",
                        to_char(a1.PUBLIC_DATE, 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-CREATE_DATE\"
                        from \"TBL_BIDINGS\" a1
                        left join \"TBL_BID_PACKAGES\" a2  on a2.\"BID_PACKAGE_CODE\" = a1.\"BID_PACKAGE_CODE\"" .
            " where (a1.\"NOTI_TYPE\" !=  '1' or a1.\"NOTI_TYPE\"  is null) and a1.\"FIELD\"='" . $BUSSINESS_FIELD . "'
                        " . $where . "
                        order by  NVL(a1.\"PUBLIC_DATE\",TO_DATE('1000-01-01','yyyy-MM-dd')) desc
                    ) a 
                    WHERE rownum < ((" . $page . " * 100) + 1 ) 
                ) WHERE r__ >= (((" . $page . "-1) * 100) + 1)";
        $query = $this->db->query($sql);
        $data =  $query->result_array();
        return $data;
    }
    public function listBidPackages_prequalification()
    {
        $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $BUSSINESS_FIELD = empty($_GET['BUSSINESS_FIELD']) ? 'hang-hoa' : $this->db->escape_str(trim($_GET['BUSSINESS_FIELD']));
        $where = '';
        if (!empty($_GET['keySearch'])) {
            $_GET['keySearch'] = $this->db->escape_str(trim($_GET['keySearch']));
            $where = " and  (a2.\"PROCURING_NAME\" like '%" . $_GET['keySearch'] . "%'
                        or a1.\"PACKAGE_NAME\" like '%" . $_GET['keySearch'] . "%'
                        or a1.\"BID_PACKAGE_CODE\" like '%" . $_GET['keySearch'] . "%')
                        ";
        }
        $sql = "SELECT * FROM ( 
            SELECT a.*, rownum r__ 
            FROM ( 
                select a1.\"BID_PACKAGE_ID\" as \"a1-zn-BID_PACKAGE_ID\",  a2.\"PROCURING_NAME\" as \"a2-zn-PROCURING_NAME\",  
                    a1.\"PACKAGE_NAME\" as \"a1-zn-PACKAGE_NAME\",  a1.\"BID_PACKAGE_CODE\" as \"a1-zn-BID_PACKAGE_CODE\",  
                    a1.\"NOTI_VERSION_NUM\" as \"a1-zn-NOTI_VERSION_NUM\",  a2.\"PROVINCE\" as \"a1-zn-LOCATION\",  
                    to_char(a1.\"PRE_START_DOC_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-START_SUBMISSION_DATE\",  
                    to_char(a1.\"PRE_FINISH_DOC_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-FINISH_SUBMISSION_DATE\",  
                    to_char(a1.\"CREATE_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-CREATE_DATE\",
                    a1.\"BID_TYPE\" as \"a1-zn-BID_TYPE\",
                    a1.\"COUNT_VIEW\" as \"a1-zn-COUNT_VIEW\",a1.\"COUNT_SUB\" as \"a1-zn-COUNT_SUB\" ,a1.\"FIELD\",
                    a2.\"PROCURING_CODE\",
                    a2.\"ADDRESS\",
                    a1.\"OPEN_DATE\",
                    a1.\"OPEN_PLACE\",
                    a2.\"EFFECTIVE_DATE\"
                    from \"TBL_BID_PACKAGES\" a1 
                    inner join \"TBL_PROCURINGS\" a2  on a1.\"PROCURING_CODE\" = a2.\"PROCURING_CODE\"
                    where a1.\"PREQUALIFICATION_STATUS\" =  '1' and a1.\"FIELD\" = '" . $BUSSINESS_FIELD . "' " . $where . "
                    order by  a1.\"CREATE_DATE\" desc
            ) a 
            WHERE rownum < ((" . $page . " * 100) + 1 ) 
        ) WHERE r__ >= (((" . $page . "-1) * 100) + 1)";
        $query = $this->db->query($sql);
        $data =  $query->result_array();
        return $data;
    }
    public function listBidPackages()
    {
        $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $BUSSINESS_FIELD = empty($_GET['BUSSINESS_FIELD']) ? 'hang-hoa' : $this->db->escape_str(trim($_GET['BUSSINESS_FIELD']));
        $where = '';
        if (!empty($_GET['keySearch'])) {
            $_GET['keySearch'] = $this->db->escape_str(trim($_GET['keySearch']));
            $where = " and  (a2.\"PROCURING_NAME\" like '%" . $_GET['keySearch'] . "%'
                                    or a1.\"PACKAGE_NAME\" like '%" . $_GET['keySearch'] . "%'
                                    or a1.\"BID_PACKAGE_CODE\" like '%" . $_GET['keySearch'] . "%')
                                    ";
        }

        //check dieu kien cho trang thong ke
        $time = !empty($_GET['time']) ? trim($_GET['time']) : '';
        $type = !empty($_GET['type']) ? trim($_GET['type']) : '';

        if ($time == '1d' && $type == 'onOff') {
            // 'OPEN_DATE'
            $where .= " and ( 
                (a1.\"OPEN_DATE\" >= TO_DATE('" . date("Y-m-d") . "','yyyy-MM-dd')  and a1.\"OPEN_DATE\" <= TO_DATE('" . date('Y-m-d', strtotime(date("Y-m-d") . "+1 days")) . "','yyyy-MM-dd')) 
                or
                (a1.\"CLOSE_DATE\" >= TO_DATE('" . date("Y-m-d") . "','yyyy-MM-dd')  and a1.\"CLOSE_DATE\" <= TO_DATE('" . date('Y-m-d', strtotime(date("Y-m-d") . "+1 days")) . "','yyyy-MM-dd')) 
            ) ";
        } else if ($type == 'phathanh-hsmt') {
            $where .= " and a1.\"START_SUBMISSION_DATE\" >= TO_DATE('" . date("Y-m-d") . "','yyyy-MM-dd')  and a1.\"START_SUBMISSION_DATE\" <= TO_DATE('" . date('Y-m-d', strtotime(date("Y-m-d") . "+1 days")) . "','yyyy-MM-dd') ";
        } else if ($type == 'dongmothau-nm') {
            //+1d&type=dongmothau-nm
            $where .= " and ( 
                (a1.\"OPEN_DATE\" >= TO_DATE('" . date('Y-m-d', strtotime(date("Y-m-d") . "+1 days")) . "','yyyy-MM-dd')  and a1.\"OPEN_DATE\" <= TO_DATE('" . date('Y-m-d', strtotime(date("Y-m-d") . "+2 days")) . "','yyyy-MM-dd')) 
                or
                (a1.\"CLOSE_DATE\" >= TO_DATE('" . date('Y-m-d', strtotime(date("Y-m-d") . "+1 days")) . "','yyyy-MM-dd')  and a1.\"CLOSE_DATE\" <= TO_DATE('" . date('Y-m-d', strtotime(date("Y-m-d") . "+2 days")) . "','yyyy-MM-dd')) 
            ) ";
        } else if ($type == 'phathanh-hsmt-nm') {
            // time=+1d&type=phathanh-hsmt-nm
            $where .= " and a1.\"START_SUBMISSION_DATE\" >= TO_DATE('" . date('Y-m-d', strtotime(date("Y-m-d") . "+1 days")) . "','yyyy-MM-dd')  and a1.\"START_SUBMISSION_DATE\" <= TO_DATE('" . date('Y-m-d', strtotime(date("Y-m-d") . "+2 days")) . "','yyyy-MM-dd') ";
        } else if ($time == '1d') {
            $where .= " and a1.\"CREATE_DATE\" >= TO_DATE('" . date("Y-m-d") . "','yyyy-MM-dd') ";
        }

        $sql = "SELECT * FROM ( 
                    SELECT a.*, rownum r__ 
                    FROM ( 
                        select a1.\"BID_PACKAGE_ID\" as \"a1-zn-BID_PACKAGE_ID\",  
                        a2.\"PROCURING_NAME\" as \"a2-zn-PROCURING_NAME\",  a1.\"PACKAGE_NAME\" as \"a1-zn-PACKAGE_NAME\",  
                        a1.\"BID_PACKAGE_CODE\" as \"a1-zn-BID_PACKAGE_CODE\",  a1.\"NOTI_VERSION_NUM\" as \"a1-zn-NOTI_VERSION_NUM\", 
                        a1.\"LOCATION\" as \"a1-zn-LOCATION\",  
                        to_char(a1.\"START_SUBMISSION_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-START_SUBMISSION_DATE\",  
                        to_char(a1.\"FINISH_SUBMISSION_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-FINISH_SUBMISSION_DATE\",  
                        to_char(a1.\"CREATE_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-CREATE_DATE\",  
                        a1.\"ESTIMATE_PRICE\" as \"a1-zn-ESTIMATE_PRICE\",  a1.\"NOTI_TYPE\" as \"a1-zn-NOTI_TYPE\",a1.\"BID_TYPE\" as \"a1-zn-BID_TYPE\",
                        a1.\"COUNT_VIEW\" as \"a1-zn-COUNT_VIEW\",a1.\"COUNT_SUB\" as \"a1-zn-COUNT_SUB\" ,a1.\"FIELD\",
                        a1.\"PROCURING_CODE\",
                        a2.\"EFFECTIVE_DATE\",
                        a1.\"TYPE\"
                        from \"TBL_BID_PACKAGES\" a1 inner join \"TBL_PROCURINGS\" a2  on a1.\"PROCURING_CODE\" = a2.\"PROCURING_CODE\"
                        where (a1.\"PREQUALIFICATION_STATUS\" !=  '1' or a1.\"PREQUALIFICATION_STATUS\" is null)
                            and a1.\"FIELD\" = '" . $BUSSINESS_FIELD . "' " . $where . "
                        order by  a1.\"CREATE_DATE\" desc
                    ) a 
                    WHERE rownum < ((" . $page . " * 100) + 1 ) 
                ) WHERE r__ >= (((" . $page . "-1) * 100) + 1)";

        $query = $this->db->query($sql);
        $data =  $query->result_array();
        return $data;
    }

    public function LayTongThongKe()
    {
        $sql = "select *
                from (
                        select COUNT(a1.\"BIDER_SELECTION_ID\") as COUNT_BIDER_SELECTION
                        from \"TBL_BIDER_SELECTIONS\" a1
                        where NVL(a1.\"BID_NUM\",0) > 0 and a1.\"CREATE_DATE\" >= TO_DATE('" . date("Y-m-d") . "','yyyy-MM-dd')
                ) a1
                left join 
                (
                    select COUNT(a1.\"BID_PACKAGE_ID\") as COUNT_DMT_HN
                    from \"TBL_BID_PACKAGES\" a1 
                    inner join \"TBL_PROCURINGS\" a2  on a1.\"PROCURING_CODE\" = a2.\"PROCURING_CODE\"
                    where (a1.\"PREQUALIFICATION_STATUS\" !=  '1' or a1.\"PREQUALIFICATION_STATUS\" is null) 
                    and ( 
                        (a1.\"OPEN_DATE\" >= TO_DATE('" . date("Y-m-d") . "','yyyy-MM-dd')  and a1.\"OPEN_DATE\" <= TO_DATE('" . date('Y-m-d', strtotime(date("Y-m-d") . "+1 days")) . "','yyyy-MM-dd')) 
                        or
                        (a1.\"CLOSE_DATE\" >= TO_DATE('" . date("Y-m-d") . "','yyyy-MM-dd')  and a1.\"CLOSE_DATE\" <= TO_DATE('" . date('Y-m-d', strtotime(date("Y-m-d") . "+1 days")) . "','yyyy-MM-dd')) 
                    )
                ) a2 on 1=1
                left join (
                    select COUNT(a1.\"BID_PACKAGE_ID\") as COUNT_PHAT_HANH_HSMT_HN
                    from \"TBL_BID_PACKAGES\" a1 
                    inner join \"TBL_PROCURINGS\" a2  on a1.\"PROCURING_CODE\" = a2.\"PROCURING_CODE\"
                    where (a1.\"PREQUALIFICATION_STATUS\" !=  '1' or a1.\"PREQUALIFICATION_STATUS\" is null) 
                    and a1.\"START_SUBMISSION_DATE\" >= TO_DATE('" . date("Y-m-d") . "','yyyy-MM-dd')  and a1.\"START_SUBMISSION_DATE\" <= TO_DATE('" . date('Y-m-d', strtotime(date("Y-m-d") . "+1 days")) . "','yyyy-MM-dd')
                ) a3 on 1=1
                left join (
                    select COUNT(a1.\"BID_PACKAGE_ID\") as COUNT_DMT_NM
                    from \"TBL_BID_PACKAGES\" a1 
                    inner join \"TBL_PROCURINGS\" a2  on a1.\"PROCURING_CODE\" = a2.\"PROCURING_CODE\"
                    where (a1.\"PREQUALIFICATION_STATUS\" !=  '1' or a1.\"PREQUALIFICATION_STATUS\" is null) 
                    and ( 
                        (a1.\"OPEN_DATE\" >= TO_DATE('" . date('Y-m-d', strtotime(date("Y-m-d") . "+1 days")) . "','yyyy-MM-dd')  and a1.\"OPEN_DATE\" <= TO_DATE('" . date('Y-m-d', strtotime(date("Y-m-d") . "+2 days")) . "','yyyy-MM-dd')) 
                        or
                        (a1.\"CLOSE_DATE\" >= TO_DATE('" . date('Y-m-d', strtotime(date("Y-m-d") . "+1 days")) . "','yyyy-MM-dd')  and a1.\"CLOSE_DATE\" <= TO_DATE('" . date('Y-m-d', strtotime(date("Y-m-d") . "+2 days")) . "','yyyy-MM-dd')) 
                    )
                ) a4 on 1=1
                left join (
                    select COUNT(a1.\"BID_PACKAGE_ID\") AS COUNT_PHAT_HANH_HSMT_NM
                    from \"TBL_BID_PACKAGES\" a1 
                    inner join \"TBL_PROCURINGS\" a2  on a1.\"PROCURING_CODE\" = a2.\"PROCURING_CODE\"
                    where (a1.\"PREQUALIFICATION_STATUS\" !=  '1' or a1.\"PREQUALIFICATION_STATUS\" is null) 
                    and a1.\"START_SUBMISSION_DATE\" >= TO_DATE('" . date('Y-m-d', strtotime(date("Y-m-d") . "+1 days")) . "','yyyy-MM-dd')  and a1.\"START_SUBMISSION_DATE\" <= TO_DATE('" . date('Y-m-d', strtotime(date("Y-m-d") . "+2 days")) . "','yyyy-MM-dd') 
                ) a5 on 1=1
                left join (
                    select COUNT(a1.\"BID_PACKAGE_ID\") as COUNT_DT_HN
                    from \"TBL_BID_PACKAGES\" a1 
                    inner join \"TBL_PROCURINGS\" a2  on a1.\"PROCURING_CODE\" = a2.\"PROCURING_CODE\"
                    where (a1.\"PREQUALIFICATION_STATUS\" !=  '1' or a1.\"PREQUALIFICATION_STATUS\" is null) 
                    and a1.\"CREATE_DATE\" >= TO_DATE('" . date("Y-m-d") . "','yyyy-MM-dd')
                ) a5 on 1=1
        ";
        if (!empty($_GET['s_test'])) {
            echo $sql;
        }
        $query = $this->db->query($sql);
        $data =  $query->result_array();
        return $data;
    }

    public function BidPackages_Detail()
    {
        $_getSegment = $this->_getSegment;
        if (!empty($_getSegment[2])) {
            $_getSegment[2] = $this->db->escape_str($_getSegment[2]);
        } else {
            $_getSegment[2] = "";
        }
        $sql = "select  a1.\"BID_PACKAGE_ID\" as \"a1-zn-BID_PACKAGE_ID\",  a1.\"PACKAGE_NAME\" as \"a1-zn-PACKAGE_NAME\",  
                a1.\"NOTI_TYPE\" as \"a1-zn-NOTI_TYPE\",a1.\"BID_TYPE\" as \"a1-zn-BID_TYPE\",  a1.\"PREQUALIFICATION_STATUS\" as \"a1-zn-PREQUALIFICATION_STATUS\",  
                a1.\"BID_PACKAGE_CODE\" as \"a1-zn-BID_PACKAGE_CODE\",  a1.\"NOTI_VERSION_NUM\" as \"a1-zn-NOTI_VERSION_NUM\",  
                a1.\"ESTIMATE_PRICE\" as \"a1-zn-ESTIMATE_PRICE\",  a1.\"DOC_PRICE\" as \"a1-zn-DOC_PRICE\",  
                a1.\"FIELD\" as \"a1-zn-FIELD\",  a1.\"DETAIL_FIELD\" as \"a1-zn-DETAIL_FIELD\",  
                a1.\"FIELD_ID\" as \"a1-zn-FIELD_ID\", a1.\"CODEKH\",to_char(a1.CONTENT) as CONTENT,
                to_char(a1.\"OPEN_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-OPEN_DATE\",  
                to_char(a1.\"START_DOC_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-START_DOC_DATE\",  
                to_char(a1.\"FINISH_DOC_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-FINISH_DOC_DATE\",  
                to_char(a1.\"START_SUBMISSION_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-START_SUBMISSION_DATE\",  
                to_char(a1.\"FINISH_SUBMISSION_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-FINISH_SUBMISSION_DATE\",  
                to_char(a1.\"PRE_START_DOC_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-PRE_START_DOC_DATE\",  
                to_char(a1.\"PRE_FINISH_DOC_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-PRE_FINISH_DOC_DATE\",  
                to_char(a1.\"PRE_OPEN_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-PRE_OPEN_DATE\",  
                a1.\"GUARANTEED_AMOUNT\" as \"a1-zn-GUARANTEED_AMOUNT\",  a1.\"BID_SECURITY\" as \"a1-zn-BID_SECURITY\",  
                a1.\"PROJECT_NAME\" as \"a1-zn-PROJECT_NAME\",  a1.\"FUNDING_SOURCE\" as \"a1-zn-FUNDING_SOURCE\",  
                a2.\"PROCURING_NAME\" as \"a2-zn-PROCURING_NAME\",  a1.\"BIDER_SELECTION_ID\" as \"a2-zn-BIDER_SELECTION_ID\",  
                a1.\"BIDER_SELECTION_TYPE\" as \"a1-zn-BIDER_SELECTION_TYPE\",
                a1.\"PRE_SUBMISSION_PLACE\" as \"a1-zn-PRE_SUBMISSION_PLACE\",
                a1.\"SUBMISSION_PLACE\" as \"a1-zn-SUBMISSION_PLACE\",  a1.\"BID_TYPE\" as \"a1-zn-BID_TYPE\"  ,
                a3.\"BIDING_ID\" as \"a3-zn-BIDING_ID\",a1.\"COUNT_SUB\",a1.STAGE_BIDDING,a1.\"PROCURING_CODE\",
            from \"TBL_BID_PACKAGES\" a1 
            left join \"TBL_PROCURINGS\" a2  on a2.\"PROCURING_CODE\" = a1.\"PROCURING_CODE\" 
            left join \"TBL_BIDINGS\" a3 on a1.\"BID_PACKAGE_CODE\" = a3.\"BID_BID_PACKAGE_CODE\" and a3.\"NOTI_TYPE\" != 1
            where  '" . $_getSegment[2] . "'  = a1.\"BID_PACKAGE_ID\"";
        // left join \"TBL_BIDER_SELECTIONS\" a4 on a1.\"BID_PACKAGE_CODE\" = a4.\"BID_PACKAGE_CODE\"
        if (!empty($_GET['s_test'])) {
            echo $sql;
        }

        $_GET['ID'] = $_getSegment[2];
        $this->updateViewBidPackages();
        $query = $this->db->query($sql);
        $data =  $query->result_array();
        $arrLog = array(
            'hang-hoa' => 'Hàng Hóa',
            'tu-van' => 'Tư Vấn',
            'xay-lap' => 'Xây Lắp',
            'phi-tu-van' => 'Phi Tư Vấn',
            'hon-hop' => 'Hỗn hợp'
        );
        if (!empty($data)) {
            $data[0]['a1-zn-FIELD'] = trim($data[0]['a1-zn-FIELD']);
            $data[0]['startDate'] = $data[0]['a1-zn-START_DOC_DATE'];
            $data[0]['expiredDate'] = $data[0]['a1-zn-FINISH_DOC_DATE'];

            $data[0]['pre_startDate'] = $data[0]['a1-zn-PRE_START_DOC_DATE'];
            $data[0]['pre_expiredDate'] = $data[0]['a1-zn-PRE_FINISH_DOC_DATE'];
            if (!empty($data[0]['a3-zn-BIDING_ID'])) {
                $data[0]['PRE_BIDING_ID'] = $data[0]['a3-zn-BIDING_ID'];
            } else {
                $sql = 'select a1."BIDING_ID"
                    from "TBL_BIDINGS" a1 
                where  \'' . $data[0]['a1-zn-BID_PACKAGE_CODE'] . '\'  = a1."BID_PACKAGE_CODE"
                and rownum =1 ';
                $query = $this->db->query($sql);
                $row =  $query->row_array();
                if (!empty($row))
                    $data[0]['PRE_BIDING_ID'] = $row['BIDING_ID'];
            }

            $arrLogId = array(
                'hang-hoa' => '1',
                'tu-van' => '5',
                'xay-lap' => '3',
                'phi-tu-van' => '15',
                'hon-hop' => '10'
            );
            $data[0]['urlShare'] = 'http://muasamcong.mpi.gov.vn/goi-thau-chi-tiet?id=' . $data[0]["a1-zn-BID_PACKAGE_CODE"] . '&option[bid_turnno]=' . ($data[0]["a1-zn-NOTI_VERSION_NUM"] < 10 ? ('0' . $data[0]["a1-zn-NOTI_VERSION_NUM"]) : $data[0]["a1-zn-NOTI_VERSION_NUM"]) . '&option[bid_type]=' . (empty($arrLogId[$data[0]['a1-zn-FIELD']]) ? 0 : $arrLogId[$data[0]['a1-zn-FIELD']]) . '&option[type_jsp]=GG/EP_MPV_GGQ999.jsp&option[bid_target]=bid';

            $data[0]['a1-zn-FIELD'] = empty($arrLog[$data[0]['a1-zn-FIELD']]) ? $data[0]['a1-zn-FIELD'] : $arrLog[$data[0]['a1-zn-FIELD']];
            $data[0]['url_hosomoithau'] = 'http://muasamcong.mpi.gov.vn:8081/GG/EP_MPV_GGQ999.jsp' . ("?bid_no=" . $data[0]["a1-zn-BID_PACKAGE_CODE"] . '&bid_turnno=' . $data[0]["a1-zn-NOTI_VERSION_NUM"] . '&bid_type=1&lang=');
        }
        return $data;
    }
    public function listBidings_prequalification()
    {
        $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $BUSSINESS_FIELD = empty($_GET['BUSSINESS_FIELD']) ? 'hang-hoa' : $this->db->escape_str(trim($_GET['BUSSINESS_FIELD']));
        $where = " where a1.\"FIELD\"='" . $BUSSINESS_FIELD . "' ";
        if (!empty($_GET['keySearch'])) {
            $_GET['keySearch'] = $this->db->escape_str(trim($_GET['keySearch']));
            $where .= " and  (a1.\"PROCURING_NAME\" like '%" . $_GET['keySearch'] . "%'
                                    or a1.\"PACKAGE_NAME\" like '%" . $_GET['keySearch'] . "%'
                                    or a1.\"BID_PACKAGE_CODE\" like '%" . $_GET['keySearch'] . "%')
                                    ";
        }

        $sql = "SELECT * FROM ( 
            SELECT a.*,NVL(a.\"a1-zn-PACKAGE_NAME1\",a2.PACKAGE_NAME) as \"a1-zn-PACKAGE_NAME\", rownum r__ 
            FROM ( 
                select a1.\"BIDING_ID\" as \"a1-zn-BIDING_ID\",  a1.\"PROCURING_NAME\" as \"a1-zn-PROCURING_NAME\",  
                    a1.\"PACKAGE_NAME\" as \"a1-zn-PACKAGE_NAME1\",  a1.\"PROJECT_NAME\" as \"a1-zn-PROJECT_NAME\",  
                    to_char(a1.\"FINISH_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-FINISH_DATE\",  a1.\"VERSION\" as \"a1-zn-VERSION\",  
                    to_char(a1.\"PUBLIC_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-PUBLIC_DATE\",  a1.\"NOTI_TYPE\" as \"a1-zn-NOTI_TYPE\",  a1.\"BID_TYPE\" as \"a1-zn-BID_TYPE\",  
                    to_char(a1.UPDATE_DATE, 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-CREATE_DATE\",
                    to_char(a1.\"APPROVAL_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-APPROVAL_DATE\",  a1.\"BIDER_NAME\" as \"a1-zn-BIDER_NAME\",  a1.\"BID_PACKAGE_CODE\" as \"a1-zn-BID_PACKAGE_CODE\",
                    a1.COUNT_VIEW
                from \"TBL_BIDINGS\" a1 
                inner join (select max(a1.\"BIDING_ID\") as \"BIDING_ID\", a1.\"BID_PACKAGE_CODE\"
                    from \"TBL_BIDINGS\" a1 
                    where a1.\"NOTI_TYPE\" = '1' 
                    group by a1.\"BID_PACKAGE_CODE\") a2 on a2.\"BIDING_ID\"=a1.\"BIDING_ID\"
                " . $where . " 
                order by  NVL(a1.\"PUBLIC_DATE\",TO_DATE('1000-01-01','yyyy-MM-dd')) desc,NVL(a1.\"UPDATE_DATE\",TO_DATE('1000-01-01','yyyy-MM-dd')) desc 
            ) a 
            left join TBL_BID_PACKAGES a2 on a2.BID_PACKAGE_CODE = a.\"a1-zn-BID_PACKAGE_CODE\"
            WHERE rownum < ((" . $page . " * 100) + 1 ) 
        ) WHERE r__ >= (((" . $page . "-1) * 100) + 1)";
        $query = $this->db->query($sql);
        $data =  $query->result_array();
        if (!empty($_GET['s_test'])) {
            echo $sql;
        }
        return $data;
    }
    public function Ajax_listBiderByBidingsIdPre()
    {
        if (empty($_GET['BidingsId'])) {
            return array();
        };
        $BidingsId = $this->db->escape_str($_GET['BidingsId']);
        // $sql = 'select a1."BIDER_NAME" as "a1-zn-BIDER_NAME",
        //                 (
        //                     select  a1."BIDING_ID" 
        //                     from "TBL_BIDINGS" a1 
        //                     where  \''.$BidingsId.'\'  = a1."BID_PACKAGE_CODE" and a1."NOTI_TYPE"=0 and rownum < 2
        //                 ) as BIDING_ID
        //         from "TBL_BIDINGS" a1 
        //     where  \''.$BidingsId.'\'  = a1."BID_PACKAGE_CODE" and a1."NOTI_TYPE"=1
        //     group by a1."BIDER_NAME"';

        $sql = 'select a1."BIDER_NAME" as "a1-zn-BIDER_NAME"
                from "TBL_BIDINGS" a1 
            where  \'' . $BidingsId . '\'  = a1."BID_PACKAGE_CODE" and a1."NOTI_TYPE"=1
            group by a1."BIDER_NAME"';

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function updateViewBidings($key, $is_pre)
    {
        if ($is_pre) {
            $sql = 'update "TBL_BIDINGS" set "COUNT_VIEW"=NVL("COUNT_VIEW",0) +1 
            where NOTI_TYPE =1 and "BID_PACKAGE_CODE"=' . $key;
        } else {
            $sql = 'update "TBL_BIDINGS" set "COUNT_VIEW"=NVL("COUNT_VIEW",0) +1 
            where "BIDING_ID"=' . $key;
        }
        $this->db->query($sql);
    }
    public function listBidings_Detail()
    {
        $_getSegment = $this->_getSegment;
        $startLimit = 0;
        if (!empty($_getSegment[2])) {
            $_getSegment[2] = $this->db->escape_str($_getSegment[2]);
        } else {
            $_getSegment[2] = "";
        }
        $sql = "select ROWNUM as rnum ,  a1.\"BIDING_ID\" as \"a1-zn-BIDING_ID\",  
                    NVL(a1.\"PACKAGE_NAME\",a2.PACKAGE_NAME) as \"a1-zn-PACKAGE_NAME\",
                    a1.\"BID_PACKAGE_CODE\" as \"a1-zn-BID_PACKAGE_CODE\",  
                    a1.\"VERSION\" as \"a1-zn-VERSION\",  
                    a1.\"PROJECT_NAME\" as \"a1-zn-PROJECT_NAME\",  a1.\"PROCURING_NAME\" as \"a1-zn-PROCURING_NAME\",  
                    a1.\"BIDER_SELECTION_TYPE\" as \"a1-zn-BIDER_SELECTION_TYPE\",  
                    a1.\"PRICE_BIDING\" as \"a1-zn-PRICE_BIDING\",  a1.\"PRICE_ACCEPT\" as \"a1-zn-PRICE_ACCEPT\",  
                    a1.\"BIDER_NAME\" as \"a1-zn-BIDER_NAME\",  a1.\"EXCUTE_CONTRACT\" as \"a1-zn-EXCUTE_CONTRACT\",  
                    to_char(a1.\"APPROVAL_CERTIFICATE\") as \"a1-zn-APPROVAL_CERTIFICATE\",  
                    to_char(a1.\"APPROVAL_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-APPROVAL_DATE\",  
                    to_char(a1.\"FINISH_DATE\", 'yyyy-mm-dd hh24:mi:ss') as \"a1-zn-FINISH_DATE\",  a1.\"NOTI_TYPE\" as \"a1-zn-NOTI_TYPE\",
                    a1.\"BID_TYPE\" as \"a1-zn-BID_TYPE\",
                    to_char(a1.UPDATE_DATE, 'yyyy-mm-dd') as UPDATE_DATE,
                    to_char(a1.UPDATE_DATE, 'yyyy-mm-dd') as CREATE_DATE,
                    '' as STATUS_BID,
                    a3.CONTRACT_TYPE, a1.SELECTION_BIDER_REASON,
                    a1.CODEKH,a2.BID_PACKAGE_ID,a4.BIDER_SELECTION_ID,
                    a2.CODEKH,
                    a1.\"APPROVAL_CERTIFICATE,
                    a1.\"PUBLIC_DATE\",
                    a1.\"BIDPROJECT\",
                    a1.\"BUYER\"
                  from \"TBL_BIDINGS\" a1 
                  left join TBL_BID_PACKAGES a2 on a2.BID_PACKAGE_CODE = a1.\"BID_PACKAGE_CODE\"
                  left join TBL_PACKAGE_INFO a3 on a3.PACKAGE_NUM = a1.CODEKH
                  left join TBL_BIDER_SELECTIONS a4 on a3.CODE = a4.BIDER_SELECTION_ID
                where  '" . $_getSegment[2] . "'  = a1.\"BIDING_ID\" ";
        $query = $this->db->query($sql);
        $data =  $query->result_array();

        //get list nha thau qua vong so tuyen
        //BID_PACKAGE_CODE
        if (!empty($data) && !empty($_GET['NOTI_TYPE'])) {

            // $sql = 'select a1."BIDER_NAME" as "a1-zn-BIDER_NAME",
            //             (
            //                 select  a1."BIDING_ID" 
            //                 from "TBL_BIDINGS" a1 
            //                 where  \''.$data[0]['a1-zn-BID_PACKAGE_CODE'].'\'  = a1."BID_PACKAGE_CODE" and a1."NOTI_TYPE"=0
            //             ) as BIDING_ID,
            //             a1.BID_BUSSINESS_REGISTRATION_NUM
            //     from "TBL_BIDINGS" a1 
            // where  \''.$data[0]['a1-zn-BID_PACKAGE_CODE'].'\'  = a1."BID_PACKAGE_CODE" and a1."NOTI_TYPE"=1
            // group by a1."BIDER_NAME", a1.BID_BUSSINESS_REGISTRATION_NUM ';

            $sql = 'select a1."BIDER_NAME" as "a1-zn-BIDER_NAME",
                        a1.BUSSINESS_REGISTRATION_NUM
                from "TBL_BIDINGS" a1 
            where  \'' . $data[0]['a1-zn-BID_PACKAGE_CODE'] . '\'  = a1."BID_PACKAGE_CODE" and a1."NOTI_TYPE"=1
            group by a1."BIDER_NAME", a1.BUSSINESS_REGISTRATION_NUM ';

            $query = $this->db->query($sql);
            $data[0]['listBinder'] =  $query->result_array();

            $this->updateViewBidings($data[0]['a1-zn-BID_PACKAGE_CODE'], true);
        } else {
            $this->updateViewBidings($_getSegment[2], false);
        }
        return $data;
    }
    public function updateViewNews()
    {
        if (!empty($_GET['ID'])) {
            $ID = (int) $_GET['ID'];
            $sql = 'update "NEWS" set "COUNT_VIEW"=NVL("COUNT_VIEW",0) +1 where "ID"=' . $ID;
            // echo $sql;
            $this->db->query($sql);
            return array(
                'error' => 0,
                'msg' => 'OK',
                'data' => ''
            );
        } else {
            return array(
                'error' => 1,
                'msg' => 'ID is required',
                'data' => ''
            );
        }
    }
    public function updateViewBidPackages()
    {
        if (!empty($_GET['ID'])) {
            $ID = (int) $_GET['ID'];
            $sql = 'update "TBL_BID_PACKAGES" set "COUNT_VIEW"=NVL("COUNT_VIEW",0) +1 where "BID_PACKAGE_ID"=' . $ID;
            // echo $sql;
            $this->db->query($sql);
            return array(
                'error' => 0,
                'msg' => 'OK',
                'data' => ''
            );
        } else {
            return array(
                'error' => 1,
                'msg' => 'ID is required',
                'data' => ''
            );
        }
    }
    public function updateSubBidPackages()
    {
        if (!empty($_GET['ID']) && !empty($_GET['USER_ID'])) {
            $BID_PACKAGE_ID = (int) $_GET['ID'];
            $USER_ID = (int) $_GET['USER_ID'];
            $TYPE = isset($_GET['TYPE']) ? (int)$_GET['TYPE'] : 1;
            $STATUS = isset($_GET['STATUS']) ? (int)$_GET['STATUS'] : 1;

            if ($STATUS == 1) {
                //check exits
                $query = $this->db->select('PACKAGE_FOLLOW_ID')
                    ->where(array('USER_ID' => $USER_ID, 'BID_PACKAGE_ID' => $BID_PACKAGE_ID))
                    ->get('TBL_PACKAGE_FOLLOWS_V2');
                $res = $query->result();

                if (empty($res)) {
                    //lay BID_PACKAGE_CODE
                    if ($TYPE != 0) {
                        $sql = 'select a1.BID_PACKAGE_CODE
                                from TBL_BID_PACKAGES a1
                                where a1.BID_PACKAGE_ID = \'' . $BID_PACKAGE_ID . '\' ';
                    } else {
                        $sql = 'select a1.CODE as "BID_PACKAGE_CODE"
                                from TBL_PACKAGE_INFO a1
                                where a1.ID = \'' . $BID_PACKAGE_ID . '\' ';
                    }
                    $query = $this->db->query($sql);
                    $row =  $query->row_array();
                    // echo $sql;
                    // print_r($row);
                    $sql = 'insert into "TBL_PACKAGE_FOLLOWS_V2"("PACKAGE_FOLLOW_ID","USER_ID","BID_PACKAGE_ID","CREATE_DATE","IS_SUB_PACKAGE","BID_PACKAGE_CODE")
                            values (
                                NVL((SELECT MAX("PACKAGE_FOLLOW_ID") FROM "TBL_PACKAGE_FOLLOWS_V2"),0)+1
                                ,' . $USER_ID . ',' . $BID_PACKAGE_ID . ',sysdate,' . $TYPE . ',\'' . $row['BID_PACKAGE_CODE'] . '\'
                            )';
                    $this->db->query($sql);
                    if ($TYPE == 1) {
                        $sql = 'update "TBL_BID_PACKAGES" set "COUNT_SUB"=NVL("COUNT_SUB",0) +1 where "BID_PACKAGE_ID"=' . $BID_PACKAGE_ID;
                        $this->db->query($sql);
                    }
                }
            } else {
                // $this->db->set('IS_SUB_PACKAGE', 0);
                $this->db->where(array('USER_ID' => $USER_ID, 'BID_PACKAGE_ID' => $BID_PACKAGE_ID, 'IS_SUB_PACKAGE' => $TYPE));
                $this->db->delete('TBL_PACKAGE_FOLLOWS_V2');

                if ($TYPE == 1) {
                    $sql = 'update "TBL_BID_PACKAGES" set "COUNT_SUB"=NVL("COUNT_SUB",0) +1 where "BID_PACKAGE_ID"=' . $BID_PACKAGE_ID;
                    $this->db->query($sql);
                }
            }

            return array(
                'error' => 0,
                'msg' => 'OK',
                'data' => ''
            );
        } else {
            return array(
                'error' => 1,
                'msg' => 'USER_ID and BID_PACKAGE_ID is required',
                'data' => ''
            );
        }
    }
    public function updateViewKHLCNT()
    {
        if (!empty($_GET['ID'])) {
            $ID = (int) $_GET['ID'];
            $sql = 'update "TBL_BIDER_SELECTIONS" 
                    set "COUNT_VIEW"=NVL("COUNT_VIEW",0) +1 where "BIDER_SELECTION_ID"=' . $ID;
            // echo $sql;
            $this->db->query($sql);
            return array(
                'error' => 0,
                'msg' => 'OK',
                'data' => ''
            );
        } else {
            return array(
                'error' => 1,
                'msg' => 'ID is required',
                'data' => ''
            );
        }
    }
    public function getFollowList()
    {
        $arr = getallheaders();
        // print_r($arr);
        if (empty($arr['x-csrftoken'])) {
            return array(
                'error' => 1,
                'msg' => 'Không lấy được giá trị TOKEN truyền lên.',
                'data' => ''
            );
        }
        $token = $this->db->escape_str(trim($arr['x-csrftoken']));

        $sql = 'select  a1."ID" as "a1-zn-ID",  a1."CODE" as "a1-zn-CODE",  
            a1."PACKAGE_NAME" as "a1-zn-PACKAGE_NAME",  
            a1."BIDER_SELECTION_TYPE" as "a1-zn-BIDER_SELECTION_TYPE",  
            a1."VALUE" as "a1-zn-VALUE",  a1."INTERNET" as "a1-zn-INTERNET",  
            a1."SELECTION_TIME" as "a1-zn-SELECTION_TIME",  a1."LOCATION" as "a1-zn-LOCATION",  
            a1."FUNDING_SOURCE" as "a1-zn-FUNDING_SOURCE" ,
            a2."PACKAGE_FOLLOW_ID",a3."USER_ID"
        from "TBL_PACKAGE_INFO" a1
        inner join "TBL_PACKAGE_FOLLOWS_V2" a2 on a2."BID_PACKAGE_ID" = a1."ID"
        inner join "TBL_USERS" a3 on a3."USER_ID" = a2."USER_ID"
        where a3."TOKEN" = \'' . $token . '\' and a2."IS_SUB_PACKAGE"=0';
        // echo $sql;
        $query = $this->db->query($sql);
        $data1 =  $query->result_array();

        $sql = 'select a1."BID_PACKAGE_ID" as "a1-zn-BID_PACKAGE_ID",  a2."PROCURING_NAME" as "a2-zn-PROCURING_NAME",        
            a1."PACKAGE_NAME" as "a1-zn-PACKAGE_NAME",  a1."BID_PACKAGE_CODE" as "a1-zn-BID_PACKAGE_CODE",                      
            a1."NOTI_VERSION_NUM" as "a1-zn-NOTI_VERSION_NUM",  a2."PROVINCE" as "a1-zn-LOCATION",                      
            to_char(a1."PRE_START_DOC_DATE", \'yyyy-mm-dd hh24:mi:ss\') as "a1-zn-START_SUBMISSION_DATE",                  
            to_char(a1."PRE_FINISH_DOC_DATE", \'yyyy-mm-dd hh24:mi:ss\') as "a1-zn-FINISH_SUBMISSION_DATE",                  
            to_char(a1."CREATE_DATE", \'yyyy-mm-dd hh24:mi:ss\') as "a1-zn-CREATE_DATE",                   
            a1."BID_TYPE" as "a1-zn-BID_TYPE",                    
            a1."COUNT_VIEW" as "a1-zn-COUNT_VIEW",a1."COUNT_SUB" as "a1-zn-COUNT_SUB" ,a1."FIELD", 
            a1."ESTIMATE_PRICE" as "a1-zn-ESTIMATE_PRICE",
            to_char(a1."START_SUBMISSION_DATE", \'yyyy-mm-dd hh24:mi:ss\') as "START_SUBMISSION_DATE",
            to_char(a1."FINISH_SUBMISSION_DATE", \'yyyy-mm-dd hh24:mi:ss\') as "FINISH_SUBMISSION_DATE",
            NVL(a1."PREQUALIFICATION_STATUS",0) as "PREQUALIFICATION_STATUS"
        from "TBL_BID_PACKAGES" a1 
        inner join "TBL_PROCURINGS" a2  on a1."PROCURING_CODE" = a2."PROCURING_CODE"                  
        inner join "TBL_PACKAGE_FOLLOWS_V2" a3 on a3."BID_PACKAGE_ID" = a1."BID_PACKAGE_ID"
        inner join "TBL_USERS" a4 on a4."USER_ID" = a3."USER_ID"
        where a4."TOKEN" = \'' . $token . '\' and a3."IS_SUB_PACKAGE"=1';
        // echo '<br/>'.$sql;
        $query = $this->db->query($sql);
        $data2 =  $query->result_array();
        $res = array(
            'PACKAGE_INFO' => $data1,
            'BID_PACKAGES' => array(),
            'BID_PACKAGES_PREQUALIFICATION' => array()
        );
        foreach ($data2 as $k => $v) {
            if ($v['PREQUALIFICATION_STATUS'] == 1) {
                $res['BID_PACKAGES_PREQUALIFICATION'][] = $v;
            } else {
                $v['a1-zn-START_SUBMISSION_DATE'] = $v['START_SUBMISSION_DATE'];
                $v['a1-zn-FINISH_SUBMISSION_DATE'] = $v['FINISH_SUBMISSION_DATE'];
                $res['BID_PACKAGES'][] = $v;
            }
        }
        return array(
            'error' => 0,
            'msg' => 'OK',
            'data' => $res
        );
    }

    public function thongKeKHLCNT()
    {
        $time = '1n';
        if (!empty($_GET['time'])) {
            $time = trim($_GET['time']);
        }
        if ($time == '1t') {
            $date = getdate();
            $wday = $date['wday'];
            $week_start = date('Y-m-d', strtotime('monday this week'));
            $week_end = date_add(date_create($week_start), date_interval_create_from_date_string("6 days"));
            $week_end = date_format($week_end, "Y-m-d");
            $date = $time == '1t' ? $week_start : date("Y-m-01");

            $sql = ' select  COUNT(a1."BIDER_SELECTION_ID") as COUNT_BIDER_SELECTION, 
                            TO_CHAR(a1."CREATE_DATE",\'yyyy-MM-dd\') as "A"
            from "TBL_BIDER_SELECTIONS" a1
            where  a1."CREATE_DATE" >= TO_DATE(\'' . $week_start . '\',\'yyyy-MM-dd\')
            and  a1."CREATE_DATE" <= TO_DATE(\'' . $week_end . '\',\'yyyy-MM-dd\')
            group by TO_CHAR(a1."CREATE_DATE",\'yyyy-MM-dd\')
            order by "A" ';
        } else if ($time = '1th') {
            $date = date("Y-m-01");
            $sql = ' select  COUNT(a1."BIDER_SELECTION_ID") as COUNT_BIDER_SELECTION, 
                            TO_CHAR(a1."CREATE_DATE",\'yyyy-MM-dd\') as "A"
            from "TBL_BIDER_SELECTIONS" a1
            where  a1."CREATE_DATE" >= TO_DATE(\'' . $date . '\',\'yyyy-MM-dd\')
            group by TO_CHAR(a1."CREATE_DATE",\'yyyy-MM-dd\')
            order by "A" ';
        } else {
            $date = date('Y-01');
            $sql = ' select  COUNT(a1."BIDER_SELECTION_ID") as COUNT_BIDER_SELECTION, TO_CHAR(a1."CREATE_DATE",\'yyyy-MM\') as "A"
            from "TBL_BIDER_SELECTIONS" a1
            where  a1."CREATE_DATE" >= TO_DATE(\'' . $date . '\',\'yyyy-MM\')
            group by TO_CHAR(a1."CREATE_DATE",\'yyyy-MM\')
            order by "A" ';
        }
        $query = $this->db->query($sql);
        $res =  $query->result_array();
        $arrLabel = array();
        $j = 1;
        // print_r($res);die;
        if ($time == '1t' || $time == '1th') {
            $arr = array();
            if ($time == '1t') {
                $arrDate = array();
                for ($i = 0; $i <= 6; $i++) {
                    $date = date_add(date_create($week_start), date_interval_create_from_date_string($i . " days"));
                    $date = date_format($date, "Y-m-d");
                    $arrDate[$i] = $date;
                    $arrLabel[$i] = $i + 1;
                    $arr[$date] = 0;
                }
                foreach ($res as $r) {
                    $arr[$r['A']] = (int)$r['COUNT_BIDER_SELECTION'];
                }
                // return array_values($arr);
                return array("data" => array_values($arr), "lable" => $arrLabel, "date" => $arrDate);
            } else {
                $dateLog = date('Y-m');
                $start_d = (int)date_format(date_create($date), "d");
                $end_d = (int)date('d');
                for ($i = $start_d; $i <= $end_d; $i++) {
                    $arr[$dateLog . '-' . ($i < 10 ? '0' . $i : $i)] = 0;
                    $arrLabel[] = (string)$j;
                    $j++;
                }
                foreach ($res as $r) {
                    $arr[$r['A']] = (int)$r['COUNT_BIDER_SELECTION'];
                }
                return array("data" => array_values($arr), "lable" => $arrLabel);
            }
        } else {
            $arr = array();
            foreach ($res as $r) {
                $arr[] = (int)$r['COUNT_BIDER_SELECTION'];
                $arrLabel[] = (string)$j;
                $j++;
            }
            return array("data" => $arr, "lable" => $arrLabel);
        }
    }
    public function thongKeKHLCNT_TP()
    {
        $time = '1n';
        if (!empty($_GET['time'])) {
            $time = trim($_GET['time']);
        }

        if ($time == '1th') {
            $date = date('Y-m');
        } else {
            $date = date('Y-01');
        }

        $orderBy = '';
        if (!empty($_GET['orderBy']) && $_GET['orderBy'] == 'desc') {
            $orderBy = 'desc';
        } else {
            $orderBy = 'asc';
        }

        $internet = '';
        if(!empty($_GET['type']) && $_GET['type'] == 'ALL'){
            //SELECT ALL
            $bidType = '';
        }else {
            //SELECT INTERNET
            $bidType = 'and a1.BID_TYPE = 2';
        }

        $sql = 'select COUNT(a1."BIDER_SELECTION_ID") as COUNT_BIDER_SELECTION, 
                        a2."PROVINCE"
                    from "TBL_BIDER_SELECTIONS" a1 
                    left join "TBL_PROCURINGS" a2 on a2."PROCURING_CODE" = a1."PROCURING_CODE"
                    where a1."CREATE_DATE" >= TO_DATE(\'' . $date . '\',\'yyyy-MM\') 
                    group by a2."PROVINCE"
                    order by COUNT_BIDER_SELECTION desc';
        $query = $this->db->query($sql);
        $res = $query->result_array();
        $data = array();
        $label = array();
        $i = 0;
        $other = 0;
        foreach ($res as $r) {
            if (!empty($r['PROVINCE']) && $i <= 5) {
                $label[] = $r['PROVINCE'];
                $data[] = (int)$r['COUNT_BIDER_SELECTION'];
            } else {
                $other += (int)$r['COUNT_BIDER_SELECTION'];
            }
            $i++;
        }
        $data[] = $other;
        $label[] = 'Các tỉnh khác';
        return array("data" => $data, "lable" => $label);
    }
    public function thongKeTBMT()
    {
        $time = '1n';
        if (!empty($_GET['time'])) {
            $time = trim($_GET['time']);
        }
        if ($time == '1t' || $time == '1th') {
            $date = getdate();
            $wday = $date['wday'];
            $week_start = date('Y-m-d', strtotime('monday this week'));
            $week_end = date_add(date_create($week_start), date_interval_create_from_date_string("6 days"));
            $week_end = date_format($week_end, "Y-m-d");
            $date = $time == '1t' ? $week_start : date("Y-m-01");

            $sql = 'select COUNT(a1."BID_PACKAGE_ID") as C,TO_CHAR(a1."CREATE_DATE",\'yyyy-MM-dd\') as "A"
                from "TBL_BID_PACKAGES" a1 
                where (a1."PREQUALIFICATION_STATUS" !=  \'1\' or a1."PREQUALIFICATION_STATUS" is null) 
                    and a1."CREATE_DATE" >= TO_DATE(\'' . $week_start . '\',\'yyyy-MM-dd\')
                    and a1."CREATE_DATE" <= TO_DATE(\'' . $week_end . '\',\'yyyy-MM-dd\')
                group by TO_CHAR(a1."CREATE_DATE",\'yyyy-MM-dd\')
                order by "A" ';
        } else if ($time == '1th') {
            $date = date("Y-m-01");
            $sql = 'select COUNT(a1."BID_PACKAGE_ID") as C,TO_CHAR(a1."CREATE_DATE",\'yyyy-MM-dd\') as "A"
                from "TBL_BID_PACKAGES" a1 
                where (a1."PREQUALIFICATION_STATUS" !=  \'1\' or a1."PREQUALIFICATION_STATUS" is null) 
                    and a1."CREATE_DATE" >= TO_DATE(\'' . $date . '\',\'yyyy-MM-dd\')
                group by TO_CHAR(a1."CREATE_DATE",\'yyyy-MM-dd\')
                order by "A" ';
        } else {
            $date = date('Y-01');
            $sql = 'select COUNT(a1."BID_PACKAGE_ID") as C,TO_CHAR(a1."CREATE_DATE",\'yyyy-MM\') as "A"
                from "TBL_BID_PACKAGES" a1 
                where (a1."PREQUALIFICATION_STATUS" !=  \'1\' or a1."PREQUALIFICATION_STATUS" is null) 
                    and a1."CREATE_DATE" >= TO_DATE(\'' . $date . '\',\'yyyy-MM\')
                group by TO_CHAR(a1."CREATE_DATE",\'yyyy-MM\')
                order by "A" ';
        }
        // echo($sql);
        $query = $this->db->query($sql);
        $res =  $query->result_array();
        $arrLabel = array();
        $j = 1;
        if ($time == '1t' || $time == '1th') {
            $arr = array();
            if ($time == '1t') {
                $arrDate = array();
                for ($i = 0; $i <= 6; $i++) {
                    $date = date_add(date_create($week_start), date_interval_create_from_date_string($i . " days"));
                    $date = date_format($date, "Y-m-d");
                    $arrDate[$i] = $date;
                    $arrLabel[$i] = $i + 1;
                    $arr[$date] = 0;
                }
                foreach ($res as $r) {
                    $arr[$r['A']] = (int)$r['C'];
                }
                // return array_values($arr);
                return array("data" => array_values($arr), "lable" => $arrLabel, "date" => $arrDate);
            } else {
                $dateLog = date('Y-m');
                $start_d = (int)date_format(date_create($date), "d");
                $end_d = (int)date('d');
                for ($i = $start_d; $i <= $end_d; $i++) {
                    $arr[$dateLog . '-' . ($i < 10 ? '0' . $i : $i)] = 0;
                    $arrLabel[] = (string)$j;
                    $j++;
                }
                foreach ($res as $r) {
                    $arr[$r['A']] = (int)$r['C'];
                }
                // return array_values($arr);
                return array("data" => array_values($arr), "lable" => $arrLabel);
            }
        } else {
            $arr = array();
            foreach ($res as $r) {
                $arr[] = (int)$r['C'];
                $arrLabel[] = (string)$j;
                $j++;
            }
            // return $arr;
            return array("data" => $arr, "lable" => $arrLabel);
        }
    }
    public function thongKeTBMT_TP()
    {
        $time = '1n';
        if (!empty($_GET['time'])) {
            $time = trim($_GET['time']);
        }
        if ($time == '1th') {
            $date = date('Y-m');
        } else {
            $date = date('Y-01');
        }

        $orderBy = '';
        if (!empty($_GET['orderBy']) && $_GET['orderBy'] == 'desc') {
            $orderBy = 'desc';
        } else {
            $orderBy = 'asc';
        }

        $bidType = '';
        if(!empty($_GET['type']) && $_GET['type'] == 'ALL'){
            //SELECT ALL
            $bidType = '';
        }else {
            //SELECT INTERNET
            $bidType = 'and a1.BID_TYPE = 2';
        }

        $sql = 'select * from (
            select COUNT(a1."BID_PACKAGE_ID") as C,
                a1.LOCATION
            from "TBL_BID_PACKAGES" a1 
            where (a1."PREQUALIFICATION_STATUS" !=  \'1\' or a1."PREQUALIFICATION_STATUS" is null) 
                and a1."CREATE_DATE" >= TO_DATE(\'' . $date . '\',\'yyyy-MM\') and a1.LOCATION is not null
            '.$bidType.'
            group by a1.LOCATION
            order by "C" ' . $orderBy . '
        ) a
        where ROWNUM <= 10';

        // $sql = 'select COUNT(a1."BID_PACKAGE_ID") as C,
        //             a1.LOCATION
        //         from "TBL_BID_PACKAGES" a1 
        //         where (a1."PREQUALIFICATION_STATUS" !=  \'1\' or a1."PREQUALIFICATION_STATUS" is null) 
        //             and a1."CREATE_DATE" >= TO_DATE(\''.$date.'\',\'yyyy-MM\')
        //             a1.BID_TYPE=2
        //         group by a1.LOCATION
        //         order by "C" desc';

        $query = $this->db->query($sql);
        $res = $query->result_array();
        $data = array();
        $label = array();
        foreach ($res as $r) {
            $label[] = $r['LOCATION'];
            $data[] = (int)$r['C'];
        }

        return array("data" => $data, "lable" => $label);
    }

    public function validateAccountOrganization()
    {
        /*
        param: token, code,type,otp
        //dua token - tay user id.
        //dua vao code va type lay organ id
        check xem no da ton tai chua. neu ton tai roi thong bao loi.
        neu chua ton tai khoi tao. sen otp
        type = 'coquan | doanhnghiep'
        */
        $_POST = json_decode(file_get_contents('php://input'), true);
        $arr = getallheaders();
        if (empty($arr['x-csrftoken'])) {
            return array(
                'error' => 1,
                'msg' => 'Không lấy được giá trị TOKEN truyền lên.',
                'data' => ''
            );
        }
        $token = $this->db->escape_str(trim($arr['x-csrftoken']));

        if (!empty($_POST['code'])) {
            $code = $this->db->escape_str(trim($_POST['code']));
        }
        if (!empty($_POST['type'])) {
            $type = $this->db->escape_str(trim($_POST['type']));
        }
        if (!empty($_POST['otp'])) {
            $otp = strtoupper($this->db->escape_str(trim($_POST['otp'])));
        }

        if (empty($code) || empty($type)) {
            return array(
                'error' => 1,
                'msg' => 'Không lấy được giá trị code hoặc type truyền lên.',
                'data' => ''
            );
        }

        if (!empty($otp)) {
            return $this->validateOtp($code, $type, $otp, $token);
        } else {
            return $this->checkSendOtp($code, $type, $token);
        }
    }
    private function sendOtp($otp, $phone = '', $email = '')
    {
        if (empty($email)) {
            return array('errorCode' => 100, 'data' => array());
        }

        $this->load->config('email');
        $mailInfo = $this->config->item('mailInfo');

        $toEmail = $email;
        $OTP_CODE = $otp;

        //send mail
        $mail = new PHPMailer();
        //Khai báo gửi mail bằng SMTP
        $mail->IsSMTP();
        $mail->CharSet = "UTF-8";
        //Tắt mở kiểm tra lỗi trả về, chấp nhận các giá trị 0 1 2
        // 0 = off không thông báo bất kì gì, tốt nhất nên dùng khi đã hoàn thành.
        // 1 = Thông báo lỗi ở client
        // 2 = Thông báo lỗi cả client và lỗi ở server
        $mail->SMTPDebug  = 0;
        $mail->Debugoutput = "html"; // Lỗi trả về hiển thị với cấu trúc HTML
        $mail->Host       = "smtp.gmail.com"; //host smtp để gửi mail
        $mail->Port       = 587; // cổng để gửi mail
        $mail->SMTPSecure = "tls"; //Phương thức mã hóa thư - ssl hoặc tls
        $mail->SMTPAuth   = true; //Xác thực SMTP
        $mail->Username   = $mailInfo['smtp_user']; // Tên đăng nhập tài khoản Gmail
        $mail->Password   = "hchdexogutacmzms"; //Mật khẩu của ung dung cua gmail
        $mail->SetFrom($mailInfo['smtp_user'], "Mã xác thực từ App Mua Sắm Công"); // Thông tin người gửi
        $mail->AddReplyTo($mailInfo['smtp_user']); // Ấn định email sẽ nhận khi người dùng reply lại.
        $mail->AddAddress($toEmail); //Email của người nhận
        $mail->Subject = "Mã xác thực từ App Mua Sắm Công"; //Tiêu đề của thư
        $mail->MsgHTML('<div>Mã xác thực: ' . $OTP_CODE . '</div>'); //Nội dung của bức thư.
        if (!$mail->Send()) {
            return array('errorCode' => 1, 'data' => array());
        } else {
            return array('errorCode' => 0, 'data' => array());
        }
    }
    private function checkSendOtp($code, $type, $token)
    {
        $this->db->select('USER_ID');
        $this->db->where(array('TOKEN' => $token));
        $user = $this->db->get('TBL_USERS')->row_array();

        $Organization = array();
        $msg = 'Số đăng ký kinh doanh không tìm thấy trong hệ thống';
        if ($type == 'coquan') {
            $this->db->select('PROCURING_CODE as CODE,CURATOR_MOBI_NUM as PHONE,CURATOR_EMAIL as EMAIL');
            $this->db->where(array('PROCURING_CODE' => $code));
            $Organization = $this->db->get('TBL_PROCURINGS')->row_array();
            $msg = 'Mã cơ quan không tìm thấy trong hệ thống';
        } else if ($type == 'doanhnghiep') {
            $this->db->select('BUSSINESS_REGISTRATION_NUM as CODE,LEADER_TEL_NUM as PHONE,LEADER_EMAIL as EMAIL');
            $this->db->where(array('BUSSINESS_REGISTRATION_NUM' => $code));
            $Organization = $this->db->get('TBL_BIDERS')->row_array();
        }

        if (empty($Organization)) {
            return array(
                'error' => 1,
                'msg' => $msg,
                'data' => ''
            );
        }

        $OTP_CODE = strtoupper(substr(md5((microtime() . rand(10, 1000))), 0, 6));

        // - logic cho 1 use co the dai dien cho cả vị trí là chủ thầu và nhà thầu. nhưng mỗi loại chỉ đại điện cho 1 tổ chức duy nhất.

        $sql = 'select a1."ID"
            from AW_USER_ORGANIZATION a1
            where a1.USER_ID=\'' . $user['USER_ID'] . '\' and a1.TYPE=\'' . $type . '\'';
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $timeSend = strtotime("now");
        if (empty($row)) {
            $sql = 'insert into AW_USER_ORGANIZATION(USER_ID,ORGANIZATION_ID,OTP,TYPE,TIME_SEND_OTP,CREATE_DATE,STATUS)
            values(\'' . $user['USER_ID'] . '\',\'' . $code . '\',\'' . $OTP_CODE . '\',\'' . $type . '\',\'' . $timeSend . '\',TO_TIMESTAMP(\'' . date('Y-m-d h:i:s') . '\',\'yyyy-mm-dd hh24:mi:ss\'),0)';
            $this->db->query($sql);
        } else {
            $sql = 'update AW_USER_ORGANIZATION
            set  OTP = \'' . $OTP_CODE . '\',
                TIME_SEND_OTP=\'' . $timeSend . '\',
                ORGANIZATION_ID = \'' . $code . '\',
                STATUS = 0
            where USER_ID = \'' . $user['USER_ID'] . '\'
                and TYPE = \'' . $type . '\'';
            $this->db->query($sql);
        }

        /**
         * send otp mail or sms;
         */
        $phone = $Organization['PHONE'];
        $email = $Organization['EMAIL'];
        $this->sendOtp($OTP_CODE, $phone, $email);
        /**
         * end send otp mail or sms;
         */

        return array(
            'error' => 0,
            'msg' => 'OK',
            'data' => array('phone' => $phone, 'email' => $email)
        );
    }
    private function validateOtp($code, $type, $otp, $token)
    {
        $sql = 'select a1."ID",a1.OTP,a1."TYPE",a1.USER_ID,a1.ORGANIZATION_ID,a1.TIME_SEND_OTP
            from AW_USER_ORGANIZATION a1
            left join TBL_USERS a2 on a1.USER_ID=a2.USER_ID ' .
            ($type != 'coquan' ?
                ' inner join TBL_BIDERS a3 on a3.BUSSINESS_REGISTRATION_NUM = a1.ORGANIZATION_ID '
                :
                ' inner join TBL_PROCURINGS a4 on a4.PROCURING_CODE=a1.ORGANIZATION_ID ') .
            ' where a1.ORGANIZATION_ID = \'' . $code . '\' and a2.TOKEN=\'' . $token . '\' and a1."TYPE"=\'' . $type . '\'
                and a1.OTP = \'' . $otp . '\'
            ';
        $query = $this->db->query($sql);
        $row = $query->row_array();
        if (empty($row)) {
            return array(
                'error' => 1,
                'msg' => 'Mã OTP không khớp.',
                'data' => ''
            );
        } else {
            $ck = strtotime("now") - $row['TIME_SEND_OTP'];
            if ($ck > 3600) { //otp chi con hieu qua trong 2 phut
                $this->db->where('ID', $row['ID']);
                $this->db->update('AW_USER_ORGANIZATION', array('OTP' => null));
                return array(
                    'error' => 2,
                    'msg' => 'Thời gian xác thực đã quá hạn. Vui lòng click vào "Gửi Lại OTP" để lấy mã xác thực mới.',
                    'data' => array(
                        strtotime("now"), $row['TIME_SEND_OTP'], $ck
                    )
                );
            } else {
                $this->db->where('ID', $row['ID']);
                $this->db->update('AW_USER_ORGANIZATION', array('OTP' => null, 'STATUS' => 1));
                return array(
                    'error' => 0,
                    'msg' => 'OK',
                    'data' => array(
                        strtotime("now"), $row['TIME_SEND_OTP'], $ck
                    )
                );
            }
        }
    }

    public function GetListAppConnect()
    {
        $status = 1;
        if (!empty($_GET['status'])) {
            $status = $_GET['status'];
        }
        $sql = 'select a.ID,a.ANDROID_PACKAGE, a.IOS_PACKAGE, a.APP_NAME, a.ICON_PATCH, a.URL_APP_IOS,a.URL_APP_ANDROID,a.URL_SCHEME_IOS,a.URL_SCHEME_ANDROID,a.STATUS
            from APP_CONNECT a WHERE a.STATUS=\'' . $status . '\'
            order by APP_NAME ';
        $query = $this->db->query($sql);
        $data =  $query->result_array();
        $res = array();
        foreach ($data as $vl) {
            $res[] = array(
                'id' => $vl['ID'],
                'androidPackage' => $vl['ANDROID_PACKAGE'],
                'iosPackage' => $vl['IOS_PACKAGE'],
                'appName' => $vl['APP_NAME'],
                'iconPath' => $vl['ICON_PATCH'],
                'urlAppIos' => $vl['URL_APP_IOS'],
                'urlAppAndroid' => $vl['URL_APP_ANDROID'],
                'urlSchemeIos' => $vl['URL_SCHEME_IOS'],
                'urlSchemeAndroid' => $vl['URL_SCHEME_ANDROID'],
                'status' => $vl['STATUS']
            );
        }
        return $res;
    }
}
