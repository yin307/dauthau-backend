<?php
defined("BASEPATH") or exit("No direct script access allowed");
class Zeanni extends CI_Controller
{
    private $base_url;
    private $USER_ID=0;
    function __construct()
    {
        parent::__construct();
        $this->base_url = base_url();
        $this->load->model("Zeanni_model", "Zeanni");
        $this->load->model("Paging_model", "Paging");
        $this->load->model("PushNotify_model", "PushNotify");

        $this->checkToken();
    }

    private function checkToken(){
        $arr = getallheaders();
        if(!empty($arr['x-csrftoken'])){
            $token = $this->db->escape_str(trim($arr['x-csrftoken']));    
            $this->db->select('a.USER_ID');
            $this->db->from('TBL_USERS a');
            $this->db->where(array('TOKEN'=>$token));
            $row = $this->db->get()->row_array();
            if(empty($row)){
                $data = array("errCode" => 300, "msg" => 'Token hết hạn', "data" => array());
                echo json_encode($data);
                die;
            }
            $this->USER_ID=$row['USER_ID'];
        }
    }
    //push notification
    public function searchContentPush1(){
        
        $kieu=1;
        if(!empty($_GET['kieu'])){
            $kieu = (int)$_GET['kieu'];
        }
        
        $arr = array(
            1=>'thay_doi_thong_tin_gt',
            /*
                thay đổi thông tin gói thầu trong đăng thong báo thầu
                - kiểm tra cho gói thầu đăng thông báo sơ tuyển http://dauthau2.zdoday.com/searchContentPush1?kieu=1&laSoTuyen=1
                - kiểm tra cho gói thầu đăng thông báo thầu http://dauthau2.zdoday.com/searchContentPush1?kieu=1

                - kịch bản test: 
                    Mở link trên trên trình duyệt. 
                    Search theo giá trị BID_PACKAGE_CODE ở màn hình tương ứng (thông tin gói thầu, thông tin gói thầu sơ tuyển).
                    click follows đợi push


            */
            2=>'thay_doi_thong_tin_gt',
            /*
                hay đổi thông tin gói thầu con trong kế hoạch lựa chọn nhà thầu
                - http://dauthau2.zdoday.com/searchContentPush1?kieu=2

                - kịch bản test: 
                    Mở link trên trên trình duyệt. 
                    Search theo giá trị CODE ở màn hình kế hoạch lựa chọn nhà thầu. follows gói thầu con có tên PACKAGE_NAME tương ứng
                    click follows đợi push
            */
            3=>'thong_bao_thau',
            /*
                thông báo mời thầu chính thức của gói thầu con trong khlcnt
                - kiểm tra cho gói thầu đăng thông báo sơ tuyển http://dauthau2.zdoday.com/searchContentPush1?kieu=3&laSoTuyen=1
                - kiểm tra cho gói thầu đăng thông báo thầu http://dauthau2.zdoday.com/searchContentPush1?kieu=3

                - kịch bản test: 
                    Mở link trên trên trình duyệt. 
                    Search theo giá trị BID_PACKAGE_CODE ở màn hình tương ứng (thông tin gói thầu, thông tin gói thầu sơ tuyển).
                    click vào chi tiết gói thầu. click ngược lại liên kết về chi tiết kế hoạch lựa chọn nhà thầu.
                    click follows gói thầu con tương ứng và đợi push
            */
            4=>'dong_thau',
            /*
                đóng bán hồ sơ dự thầu (bắn trước 1 ngày)
                - kiểm tra cho gói thầu đăng thông báo sơ tuyển http://dauthau2.zdoday.com/searchContentPush1?kieu=4&laSoTuyen=1
                - kiểm tra cho gói thầu đăng thông báo thầu http://dauthau2.zdoday.com/searchContentPush1?kieu=4
                
                - kịch bản test: 
                    Mở link trên trên trình duyệt. 
                    Search theo giá trị BID_PACKAGE_CODE ở màn hình tương ứng (thông tin gói thầu, thông tin gói thầu sơ tuyển).
                    click follows đợi push
            */
            5=>'thong_bao_ket_qua',
            /*
                gói thầu trong thông báo thầu. được công bố kết quả nhà thầu trúng thầu
                - kiểm tra cho kết quả sơ tuyển http://dauthau2.zdoday.com/searchContentPush1?kieu=5&laSoTuyen=1
                - kiểm tra cho ket quả thầu http://dauthau2.zdoday.com/searchContentPush1?kieu=5

                - kịch bản test: 
                    Mở link trên trên trình duyệt. 
                    Search theo giá trị BID_PACKAGE_CODE ở màn hình tương ứng (thông tin gói thầu, thông tin gói thầu sơ tuyển).
                    click follows đợi push
            */
            6=>'mo_ban_ho_so_thau', 
            /*
                mở bán hồ sơ thầu
                - kiểm tra cho kết quả sơ tuyển http://dauthau2.zdoday.com/searchContentPush1?kieu=6&laSoTuyen=1
                - kiểm tra cho ket quả thầu http://dauthau2.zdoday.com/searchContentPush1?kieu=6

                - kịch bản test: 
                    Mở link trên trên trình duyệt. 
                    Search theo giá trị BID_PACKAGE_CODE ở màn hình tương ứng (thông tin gói thầu, thông tin gói thầu sơ tuyển).
                    click follows đợi push
             */
            7=>'mo_thau',
            /*
                đã có văn bản mở thầu 
                - kiểm tra cho kết quả sơ tuyển http://dauthau2.zdoday.com/searchContentPush1?kieu=7&laSoTuyen=1
                - kiểm tra cho ket quả thầu http://dauthau2.zdoday.com/searchContentPush1?kieu=7

                - kịch bản test: 
                    Mở link trên trên trình duyệt. 
                    Search theo giá trị BID_PACKAGE_CODE ở màn hình tương ứng (thông tin gói thầu, thông tin gói thầu sơ tuyển).
                    click follows đợi push
             */
        );
        
        $where = ' a1.TYPE_PUSH = \''.$arr[$kieu].'\' ';
        if(!empty($_GET['laSoTuyen']) && $kieu!=2 ){
            $where .= ' and a2.PREQUALIFICATION_STATUS = 1 ';
        }
        else if($kieu!=2 ){
            $where .= ' and (a2.PREQUALIFICATION_STATUS != 1 or a2.PREQUALIFICATION_STATUS is null)';
        }
        if($kieu!=2 ){
            $sql = 'select a1.name_table,a1.bid_package_code,a1.type_push,to_char(a1.time_start_push, \'yyyy-mm-dd hh24:mi:ss\') as time_start_push,a1.noti_version_num_log
            from CONTENT_PUSH a1
            inner join TBL_BID_PACKAGES a2 on a2.bid_package_code=a1.bid_package_code
            where a1.STATUS_PUSH is null and '.$where;
        }
        else{
            $sql = 'select a1.name_table,a1.bid_package_code,a1.type_push,to_char(a1.time_start_push, \'yyyy-mm-dd hh24:mi:ss\') as time_start_push,a1.noti_version_num_log,
                a2.CODE,a2.PACKAGE_NAME
            from CONTENT_PUSH a1
            inner join TBL_PACKAGE_INFO a2 on a2.PACKAGE_NUM=a1.bid_package_code
            where a1.STATUS_PUSH is null and a1.type_push = \'thay_doi_thong_tin_gt\' ';
        }
        $query = $this->db->query($sql);
        $data1 =  $query->result_array();
        echo '<pre>';
        print_r($data1);
        echo '</pre>';
    }

    public function searchContentPush(){
        /**
         * lay 1 tieng 1 lan.
         * 0h hang ngay clear du lieu bang CONTENT_PUSH
         *
         * table TBL_PACKAGE_INFO
         * - lấy thông tin khi thay đổi.
         * - lấy thông tin khi gói thầu chính thức được thông báo mời thầu.
         * - tự đông cho theo dõi thông tin thông báo mời thâu. => sẽ nhận được các luồng cơ bản
         *
         *
         */
        // lấy những gói thầu mới được thông báo.
        // taọ thêm 1 cột VERSION_LOG. log lai trang thai hien tai cua cac goi thau.
        // select goi thau thay doi chi can lay nhung thang VERSION > 0 va VERSION_LOG != VERSION

        $call=1;
        if(!empty($_GET['call'])){
            $call = (int)$_GET['call'];
        }

        if($call==1){
            //scan cac goi thau co cap nhat hay doi
            $sql = 'select \'TBL_BID_PACKAGES\' as NAME_TABLE,
                    a1.BID_PACKAGE_CODE,
                    a1."FIELD",
                    (CASE WHEN a1."PREQUALIFICATION_STATUS"=\'1\' THEN \'YES\' ELSE \'NO\' END) as "LA_SO_TUYEN",
                    a1.BID_PACKAGE_ID as TABLE_ID,
                    \'thay_doi_thong_tin_gt\' as TYPE_PUSH,
                    SYSDATE as DATE_CREATED,
                    \'\' as CONTENT_PUSH,
                    SYSDATE as TIME_START_PUSH,
                    null as TIME_END_PUSH,
                    0 as TIMES    
                from TBL_BID_PACKAGES a1 
                where a1.NOTI_VERSION_NUM > 0 and a1.NOTI_VERSION_NUM != a1.NOTI_VERSION_NUM_LOG';
        }
        else if($call==2){
            //scan cac goi thau con trong khlcnt co cap nhat hay doi
            $sql = 'select \'TBL_PACKAGE_INFO\' as NAME_TABLE,
                    a1.PACKAGE_NUM,
                    a1.CODE,a1.PACKAGE_NAME,
                    a1.ID as TABLE_ID,
                    \'thay_doi_thong_tin_gt\' as TYPE_PUSH,
                    SYSDATE as DATE_CREATED,
                    \'\' as CONTENT_PUSH,
                    SYSDATE as TIME_START_PUSH,
                    null as TIME_END_PUSH,
                    0 as TIMES
                from TBL_PACKAGE_INFO a1 
                where a1."VERSION" > 0 and a1."VERSION" != a1.VERSION_LOG';
        }
        else if($call==3){
            $sql = 'select \'TBL_BID_PACKAGES\' as NAME_TABLE,
                    a1.BID_PACKAGE_CODE,
                    a1."FIELD",
                    (CASE WHEN a1."PREQUALIFICATION_STATUS"=\'1\' THEN \'YES\' ELSE \'NO\' END) as "LA_SO_TUYEN",
                    a1.BID_PACKAGE_ID as TABLE_ID,
                    \'thong_bao_thau\' as TYPE_PUSH,
                    SYSDATE as DATE_CREATED,
                    \'\' as CONTENT_PUSH,
                    SYSDATE as TIME_START_PUSH,
                    null as TIME_END_PUSH,
                    0 as TIMES
                from TBL_BID_PACKAGES a1
                inner join TBL_PACKAGE_INFO a3 on a3.CODE = a1.CODEKH
                where a1."CREATE_DATE" > TO_DATE(\''.date('Y-m-d',strtotime(date("Y-m-d") . "+1 days")).'\',\'yyyy-MM-dd\') and a1.PACKAGE_NAME = a3.PACKAGE_NAME';
        }
        else if($call==4){
            //lấy những gói thầu chuẩn bị đóng thầu.
            $sql = 'select \'TBL_BID_PACKAGES\' as TBL_BID_PACKAGES,
                    a1."BID_PACKAGE_CODE",
                    a1."FIELD",
                    (CASE WHEN a1."PREQUALIFICATION_STATUS"=\'1\' THEN \'YES\' ELSE \'NO\' END) as "LA_SO_TUYEN",
                    a1."BID_PACKAGE_ID" as TABLE_ID,
                    \'dong_thau\' as "TYPE_PUSH",
                    SYSDATE as DATE_CREATED,
                    to_char(a1."FINISH_SUBMISSION_DATE", \'yyyy-mm-dd hh24:mi:ss\') as CONTENT_PUSH,
                    SYSDATE as TIME_START_PUSH,
                    a1."FINISH_SUBMISSION_DATE" as TIME_END_PUSH,
                    0 as TIMES
                    from "TBL_BID_PACKAGES" a1 
                    left join CONTENT_PUSH a2 on a2.NAME_TABLE=\'TBL_BID_PACKAGES\' and a2.BID_PACKAGE_CODE=a1."BID_PACKAGE_CODE" and a2.TYPE_PUSH=\'dong_thau\'
                    where (a1."PREQUALIFICATION_STATUS" !=  \'1\' or a1."PREQUALIFICATION_STATUS" is null) 
                      and a2.ID is null
                      and a1."FINISH_SUBMISSION_DATE" <= TO_DATE(\''.date('Y-m-d',strtotime(date("Y-m-d") . "+3 days")).'\',\'yyyy-MM-dd\') and a1."FINISH_SUBMISSION_DATE" >= TO_DATE(\''.date('Y-m-d',strtotime(date("Y-m-d") . "+2 days")).'\',\'yyyy-MM-dd\')';
        }
        else if($call==5){
            // lấy những gói thầu đã được công bố kết quả
            $sql = 'select \'TBL_BIDINGS\' as NAME_TABLE,
                    a1.BID_PACKAGE_CODE,
                    a2."FIELD",
                    (CASE WHEN a1."NOTI_TYPE"=\'1\' THEN \'YES\' ELSE \'NO\' END) as "LA_SO_TUYEN",
                    a1.BIDING_ID as TABLE_ID,
                    \'thong_bao_ket_qua\' as TYPE_PUSH,
                    SYSDATE as DATE_CREATED,
                    \'\' as CONTENT_PUSH,
                    SYSDATE as TIME_START_PUSH,
                    null as TIME_END_PUSH,
                    0 as TIMES
                from TBL_BIDINGS a1
                inner join TBL_BID_PACKAGES a2 on a2.BID_PACKAGE_CODE = a1.BID_PACKAGE_CODE
                left join CONTENT_PUSH a3 on a3.NAME_TABLE=\'TBL_BIDINGS\' and a3.BID_PACKAGE_CODE=a1."BID_PACKAGE_CODE" and a3.TYPE_PUSH=\'thong_bao_ket_qua\'
                where a1.PUBLIC_DATE >= TO_DATE(\''.date('Y-m-d',strtotime(date("Y-m-d") . "+1 days")).'\',\'yyyy-MM-dd\') and a3."ID" is null';
        }
        else if($call==6){
            //lấy những gói thầu được mở thầu hôm nay .
            $sql = 'select \'TBL_BID_PACKAGES\' as TBL_BID_PACKAGES,
                    a1."BID_PACKAGE_CODE",
                    a1."FIELD",
                    (CASE WHEN a1."PREQUALIFICATION_STATUS"=\'1\' THEN \'YES\' ELSE \'NO\' END) as "LA_SO_TUYEN",
                    a1."BID_PACKAGE_ID" as TABLE_ID,
                    \'mo_ban_ho_so_thau\' as "TYPE_PUSH",
                    SYSDATE as DATE_CREATED,
                    \'\' as CONTENT_PUSH,
                    SYSDATE as TIME_START_PUSH,
                    null as TIME_END_PUSH,
                    0 as TIMES
                    from "TBL_BID_PACKAGES" a1 
                    left join CONTENT_PUSH a2 on a2.NAME_TABLE=\'TBL_BID_PACKAGES\' and a2.BID_PACKAGE_CODE=a1."BID_PACKAGE_CODE" and a2.TYPE_PUSH=\'mo_ban_ho_so_thau\'
                    where (a1."PREQUALIFICATION_STATUS" !=  \'1\' or a1."PREQUALIFICATION_STATUS" is null) 
                      and a2.ID is null
                      and a1."START_SUBMISSION_DATE" <= TO_DATE(\''.date('Y-m-d',strtotime(date("Y-m-d") . "+1 days")).'\',\'yyyy-MM-dd\') and a1."START_SUBMISSION_DATE" >= TO_DATE(\''.date('Y-m-d').'\',\'yyyy-MM-dd\')';
        }
        $query = $this->db->query($sql);
        $data1 =  $query->result_array();
        echo '<pre>';
        print_r($data1);
        echo '</pre>';
    }

    public function clearTableContentLogPush(){
        $this->PushNotify->clearTableContentLogPush();
    }
    public function scanContentPushV2(){
        $this->PushNotify->scanContentPush();
    }
    public function logContentPushByUser(){
        $this->PushNotify->logContentPushByUser();
    }
    public function pushNotifyV2(){
        $this->PushNotify->pushNotify();
    }
    public function testPush(){
        $content = '123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 ';
        $response = $this->PushNotify->sendMessage(array('0b9c931f-d621-4fb6-ac94-ffe218985050','ab185b84-52ae-4178-8268-40f09882a562','0f624d66-b424-46c4-8da7-8793c017c09f'),$content,'/thong_tin_goi_thau___chi_tiet/346968');
        $return["allresponses"] = $response;
        $return = json_encode($return);

        $data = json_decode($response, true);
        print_r($data);
        $id = $data['id'];
        print_r($id);

        print("\n\nJSON received:\n");
        print($return);
        print("\n");
    }

    public function sendMail(){
        
    }
    
    public function Ajax_checkMailExist(){
        // $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $data = $this->Zeanni->checkMailExist();
        echo json_encode($data);
    }
    public function Ajax_sendMaXacThuc(){
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $res = $this->Zeanni->sendMaXacThuc();
        if($res['errorCode']!=0){
            $arr = array(1=>'Có lỗi khi gửi mã');
            $data = array("errCode" => 1, "msg" => $arr[$res['errorCode']], "data" => array("data" => array(), "lable" => array()));
        }
        else{
            $data["data"]["data"] = $res['data'];
        }
        echo json_encode($data);
    }
    
    public function Ajax_xacthuccode(){
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $res = $this->Zeanni->xacthuccode();
        if($res['errorCode']!=0){
            $arr = array(1=>'Không lấy được mã xác thực',2=>'Mã xác thực không đúng');
            $data = array("errCode" => 1, "msg" => $arr[$res['errorCode']], "data" => array("data" => array(), "lable" => array()));
        }
        else{
            $data["data"]["data"] = $res['data'];
        }
        echo json_encode($data);
    }
    public function Ajax_sendOTP_CODE(){
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $res = $this->Zeanni->sendOTP_CODE();
        if($res['errorCode']!=0){
            $arr = array(1=>'Email không tồn tại trong hệ thống',2=>'Vui lòng nhập email');
            $data = array("errCode" => 1, "msg" => $arr[$res['errorCode']], "data" => array("data" => array(), "lable" => array()));
        }
        else{
            $data["data"]["data"] = $res['data'];
        }
        echo json_encode($data);
    }
    
    public function Ajax_forgotPassword(){
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $res = $this->Zeanni->forgotPassword();
        if($res['errorCode']!=0){
            $arr = array(1=>'Vui lòng điền đầy đủ mã xác thực và mật khẩu',2=>'Mã xác thực không đúng');
            $data = array("errCode" => 1, "msg" => $arr[$res['errorCode']], "data" => array("data" => array(), "lable" => array()));
        }
        else{
            $data["data"]["data"] = $res['data'];
            $data["data"]["packageFollows"] = $res['packageFollows'];
        }
        echo json_encode($data);
    }

    public function Ajax_getUserInfo(){
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array(),"packageFollows"=>array() ));
        $res = $this->Zeanni->getUserInfo();
        if($res['errorCode']!=0){
            $arr = array("1"=>'Không nhận được giá trị TOKEN',"2"=>'Phiên đăng nhập đã bị hết hạn.');
            $data = array("errCode" => 1, "msg" => $arr[$res['errorCode']], "data" => array("data" => array(), "lable" => array()));
        }
        else{
            $data["data"]["data"] = $res['data'];
            $data["data"]["packageFollows"] = $res['packageFollows'];
        }
        echo json_encode($data);
    }
    public function Ajax_login(){
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array(),"packageFollows"=>array() ));
        $res = $this->Zeanni->login();
        if($res['errorCode']!=0){
            $arr = array(1 => 'Vui lòng điền đầy đủ email và mật khẩu',2=>'Email hoặc mật khẩu không đúng');
            $data = array("errCode" => 1, "msg" => $arr[$res['errorCode']], "data" => array("data" => array(), "lable" => array()));
        }
        else{
            $data["data"]["data"] = $res['data'];
            $data["data"]["packageFollows"] = $res['packageFollows'];
        }
        echo json_encode($data);
    }
    public function Ajax_register(){
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $res = $this->Zeanni->register();
        if($res['errorCode']!=0){
            $arr = array(1=>'Vui lòng điền đầy đủ tên, email và mật khẩu',2=>'Email không đúng định dạng',3=>'Tài khoản đã tồn tại');
            $data = array("errCode" => 1, "msg" => $arr[$res['errorCode']], "data" => array("data" => array(), "lable" => array()));
        }
        else{
            $data["data"]["data"] = $res['data'];
        }
        echo json_encode($data);
    }
    public function loginFacebook(){
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array(),"packageFollows"=>array() ));
        $res = $this->Zeanni->loginFacebook();
        if($res['errorCode']!=0){
            $arr = array(1=>'Vui lòng điền đầy đủ email, social_id và full_name',2=>'Email không đúng định dạng',3=>'social_id không đúng');
            $data = array("errCode" => 1, "msg" => $arr[$res['errorCode']], "data" => array("data" => array(), "lable" => array()));
        }
        else{
            $data["data"]["data"] = $res['data'];
            $data["data"]["packageFollows"] = $res['packageFollows'];
        }
        echo json_encode($data);
    }

    public function GetListLocation(){
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $data["data"]["data"] = $this->Zeanni->GetListLocation();
        echo json_encode($data);
    }

    public function Ajax_GetListNews()
    {
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $res = $this->Zeanni->GetListNews();
        $data["data"]["data"] = $res['data'];
        $data["data"]["newsHighlights"] = $res['newsHighlights'];
        echo json_encode($data);
    }
    public function Ajax_NewsDetail()
    {
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $data["data"]["data"] = $this->Zeanni->NewsDetail();
        echo json_encode($data);
    }
    public function Ajax_newsInvolve()
    {
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $data["data"]["data"] = $this->Zeanni->newsInvolve();
        echo json_encode($data);
    }
    public function Ajax_listBiders()
    {
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $data["data"]["data"] = $this->Zeanni->listBiders();
        echo json_encode($data);
    }
    public function Ajax_detailBiders()
    {
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $data["data"]["data"] = $this->Zeanni->detailBiders();
        echo json_encode($data);
    }
    public function Ajax_listProcurings()
    {
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $data["data"]["data"] = $this->Zeanni->listProcurings();
        echo json_encode($data);
    }
    public function Ajax_procuringsDetail()
    {
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $data["data"]["data"] = $this->Zeanni->procuringsDetail();
        echo json_encode($data);
    }
    public function Ajax_listBiderSelections()
    {
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $data["data"]["data"] = $this->Zeanni->listBiderSelections();
        echo json_encode($data);
    }
    public function Ajax_biderSelectionsDetail()
    {
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $data["data"]["data"] = $this->Zeanni->biderSelectionsDetail();
        echo json_encode($data);
    }
    public function Ajax_biderSelections_packageInfo()
    {
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $data["data"]["data"] = $this->Zeanni->biderSelections_packageInfo();
        echo json_encode($data);
    }
    public function Ajax_packageInfo_detail()
    {
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $data["data"]["data"] = $this->Zeanni->packageInfo_detail();
        echo json_encode($data);
    }
    public function Ajax_listBidings()
    {
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $data["data"]["data"] = $this->Zeanni->listBidings();
        echo json_encode($data);
    }
    public function Ajax_listBidPackages_prequalification()
    {
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $data["data"]["data"] = $this->Zeanni->listBidPackages_prequalification();
        echo json_encode($data);
    }
    public function Ajax_listBidPackages()
    {
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $data["data"]["data"] = $this->Zeanni->listBidPackages();
        echo json_encode($data);
    }
    public function Ajax_BidPackages_Detail()
    {
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $data["data"]["data"] = $this->Zeanni->BidPackages_Detail();
        echo json_encode($data);
    }
    public function Ajax_listBidings_prequalification()
    {
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $data["data"]["data"] = $this->Zeanni->listBidings_prequalification();
        echo json_encode($data);
    }
    public function Ajax_listBiderByBidingsIdPre()
    {
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $data["data"]["data"] = $this->Zeanni->Ajax_listBiderByBidingsIdPre();
        echo json_encode($data);
    }
    public function Ajax_listBidings_Detail()
    {
        $data = array("errCode" => 0, "msg" => "ok", "data" => array("data" => array(), "lable" => array()));
        $data["data"]["data"] = $this->Zeanni->listBidings_Detail();
        // print_r($data);
        echo json_encode($data);
    }
    public function Ajax_updateViewNews()
    {
        $res = $this->Zeanni->updateViewNews();
        if($res['error']!=0){
            $data = array("errCode" => 1, "msg" => $res['msg'], "data" => array("data" => array(), "lable" => array()));
        }
        else{
            $data = array("errCode" => 0, "msg" => '0k', "data" => array("data" => array(), "lable" => array()));
        }
        echo json_encode($data);
    }
    public function Ajax_updateViewBidPackages()
    {
        $res = $this->Zeanni->updateViewBidPackages();
        if($res['error']!=0){
            $data = array("errCode" => 1, "msg" => $res['msg'], "data" => array("data" => array(), "lable" => array()));
        }
        else{
            $data = array("errCode" => 0, "msg" => '0k', "data" => array("data" => array(), "lable" => array()));
        }

        echo json_encode($data);
    }
    public function Ajax_updateSubBidPackages()
    {
        $res = $this->Zeanni->updateSubBidPackages();
        if($res['error']!=0){
            $data = array("errCode" => 1, "msg" => $res['msg'], "data" => array("data" => array(), "lable" => array()));
        }
        else{
            $data = array("errCode" => 0, "msg" => '0k', "data" => array("data" => array(), "lable" => array()));
        }
        echo json_encode($data);
    }

    public function Ajax_getFollowList()
    {
        $res = $this->Zeanni->getFollowList();
        if($res['error']!=0){
            $data = array("errCode" => 1, "msg" => $res['msg'], "data" => array("data" => getallheaders(), "lable" => array()));
        }
        else{
            $data = array("errCode" => 0, "msg" => '0k', "data" => array("data" => $res['data'], "lable" => array()));
        }
        echo json_encode($data);
    }

    public function Ajax_LayTongThongKe()
    {
        $res = $this->Zeanni->LayTongThongKe();
        $data = array("errCode" => 0, "msg" => '0k', "data" => array("data" => $res, "lable" => array()));
        echo json_encode($data);
    }
    public function Ajax_TopNhaThauDuThau()
    {
        $res = $this->Zeanni->TopNhaThauDuThau();
        $data = array("errCode" => 0, "msg" => '0k', "data" => array("data" => $res, "lable" => array()));
        echo json_encode($data);
    }
    public function Ajax_thongKeTBMT()
    {
        $res = $this->Zeanni->thongKeTBMT();
        $data = array("errCode" => 0, "msg" => '0k', "data" => array("data" => $res, "lable" => array()));
        echo json_encode($data);
    }
    public function Ajax_thongKeTBMT_TP()
    {
        $res = $this->Zeanni->thongKeTBMT_TP();
        $data = array("errCode" => 0, "msg" => '0k', "data" => array("data" => $res, "lable" => array()));
        echo json_encode($data);
    }
    public function Ajax_thongKeKHLCNT()
    {
        $res = $this->Zeanni->thongKeKHLCNT();
        $data = array("errCode" => 0, "msg" => '0k', "data" => array("data" => $res, "lable" => array()));
        echo json_encode($data);
    }
    public function Ajax_thongKeKHLCNT_TP()
    {
        $res = $this->Zeanni->thongKeKHLCNT_TP();
        $data = array("errCode" => 0, "msg" => '0k', "data" => array("data" => $res, "lable" => array()));
        echo json_encode($data);
    }
    public function Ajax_getNotify(){
        $res = $this->PushNotify->getNotify();
        $data = array("errCode" => 0, "msg" => '0k', "data" => array("data" => $res, "lable" => array()));
        echo json_encode($data);
    }
    public function deleteNotify(){
        if(!empty($this->USER_ID) && !empty($_GET['U_CP_ID'])){
            $U_CP_ID = (int)$_GET['U_CP_ID'];
            $this->db->where(array('ID'=>$U_CP_ID,'USER_ID'=>$this->USER_ID));
            $this->db->delete('AW_USERS_CONTENT_PUSH');
            $data = array("errCode" => 0, "msg" => '0k', "data" => array());
        }
        else{
            $data = array("errCode" => 1, "msg" => 'error', "data" => array());
        }
        echo json_encode($data);
    }
    public function Ajax_updateUserInfo(){
        $res = $this->Zeanni->updateUserInfo();
        $data = array("errCode" => 0, "msg" => '0k', "data" => array("data" => $res, "lable" => array()));
        echo json_encode($data);
    }
    public function Ajax_validateAccount(){
        $res = $this->Zeanni->validateAccountOrganization();
        $data = array("errCode" => 0, "msg" => '0k', "data" => array("data" => $res, "lable" => array()));
        echo json_encode($data);
    }
    public function Ajax_getCountContentPush(){
        $arr = getallheaders();
        if(empty($arr['x-csrftoken'])){
            $data = array("errCode" => 0, "msg" => '0k', "data" => 0);
            echo json_encode($data);
            return false;
        }
        $token = $this->db->escape_str(trim($arr['x-csrftoken']));
        $sql = "select USER_ID
        from TBL_USERS 
        where TOKEN = '".$token."'";
        $query = $this->db->query($sql);
        $row =  $query->row_array();
        if(empty($row)){
            $data = array("errCode" => 0, "msg" => '0k', "data" => 0);
            echo json_encode($data);
            return false;
        }

        $sql = "select count(a1.CONTENT_PUSH_ID) as COUNT
        from AW_USERS_CONTENT_PUSH a1
                where a1.STATUS_VIEW='0' and a1.USER_ID='".$row['USER_ID']."'";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $data = array("errCode" => 0, "msg" => '0k', "data" => $row['COUNT']);
        echo json_encode($data);
    }
    public function Ajax_updateStatusNotify(){
        $arr = getallheaders();
        $id = 0;
        if(!empty($_GET['id'])){
            $id=(int)$_GET['id'];
        }
        if(empty($arr['x-csrftoken']) || empty($id)){
            return array();
        }
        $token = $this->db->escape_str(trim($arr['x-csrftoken']));
        $sql = "select USER_ID
        from TBL_USERS 
        where TOKEN = '".$token."'";
        $query = $this->db->query($sql);
        $row =  $query->row_array();
        if(empty($row)){
            $data = array("errCode" => 300, "msg" => 'Token hết hạn', "data" => '');
            echo json_encode($data);
            die;
        }

        $sql = "update AW_USERS_CONTENT_PUSH
                set STATUS_VIEW = 1
            where USER_ID='".$row['USER_ID']."' and ID=".$id;
        $this->db->query($sql);
        $data = array("errCode" => 0, "msg" => '0k', "data" => '');
        echo json_encode($data);
    }
    public function Ajax_getConfigSendPush(){
        $id = $this->Zeanni->getUserId();
        if($id==-1){
            $data = array("errCode" => 0, "msg" => '0k', "data" => array(),'id'=>$id);
            echo json_encode($data);
            die;
        }

        $sql = "select a1.*,NVL(a2.send_push,1) as send_push
        from AW_TYPE_PUSH a1
        left join AW_USERS_TYPE_PUSH a2 on a2.type_push_id=a1.id and a2.user_id='".$id."' 
         order by a1.INDEX_SORT asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        $data = array("errCode" => 0, "msg" => '0k', "data" => $data);
        echo json_encode($data);
    }
    public function Ajax_updateConfigSendPush(){
        $id = 0;
        if(!empty($_GET['id'])){
            $id=(int)$_GET['id'];
        }
        if(isset($_GET['status'])){
            $status=$_GET['status']==1?1:0;
        }
        
        if(empty($id)){
            $id = (int)$_POST['id'];
        }
        if(empty($status)){
            $status = (int)$_POST['id'];
        }

        $UserId = $this->Zeanni->getUserId();
        if($UserId==-1 || !isset($status) || empty($id)){
            $data = array("errCode" => 1, "msg" => 'Error', "data" => array());
            echo json_encode($data);
            die;
        }

        $sql = 'select ID, user_id from AW_USERS_TYPE_PUSH where type_push_id='.$id.' and user_id='.$UserId;
        $query = $this->db->query($sql);
        $row = $query->row_array();
        if(!empty($row)){
            $sql = "update AW_USERS_TYPE_PUSH
                set SEND_PUSH = ".$status."
            where USER_ID='".$UserId."' and type_push_id=".$id;
        }
        else{
            $sql = "insert into AW_USERS_TYPE_PUSH(SEND_PUSH,type_push_id,user_id)
                values(".$status.",".$id.",'".$UserId."')";
        }
        
        $this->db->query($sql);
        $data = array("errCode" => 0, "msg" => '0k', "data" => $sql);
        echo json_encode($data);
    }

    public function Ajax_getListAppConnect(){
        $res = $this->Zeanni->GetListAppConnect();
        $data = array("errCode" => 0, "msg" => '0k', "data" => array("data" => $res, "lable" => array()));
        echo json_encode($data);
    }

}
