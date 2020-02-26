<?php
defined("BASEPATH") or exit("No direct script access allowed");
interface PushNotify{
  /**
   * Nội dung bắn. bắn những thông tin liên quan tới gói thầu mà nhà thầu ấn theo dõi 
   * - các nội dung push
   *      ngày bắt đầu nhận hồ sơ. ngày kết thúc nhận hồ sơ. ngày thông báo kết quả. kết quả đã được thông báo.
   *      nội dung gói thầu bị thay đổi 
   * - thông tin gói thầu đang ở 3 bảng chính. vì vậy tạo bảng log cần lưu ý.
   * - bảng log content push
   *      NAME_TABLE, 
   *      BID_PACKAGE_CODE, 
   *      TABLE_ID, 
   *      TYPE_PUSH,          : MO THAU, DONG THAU, KET QUA DAU THAU, KET QUA SO TUYEN
   *      STATUS_PUSH         : PUSH DONE. LOG DE XOA KHOI BANG LOG
   *      DATE_CREATED        : THOI GIAN LOG VAO BANG PUSH
   *      CONTENT_PUSH        :
   *      TIME_START_PUSH
   *      TIME_END_PUSH
   *      USER_PUSH_FAIL      : CHUOI USER_ID
   *      TIMES               : Số lần bắn. bắn tối da 3 lần. nếu user nào  vẫn lỗi thì ko bắn nữa 
   * - bảng log user đã được push
   *      STATUS_PUSH         :DONE,PENDING
   *      LAST_USER_ID
   */
  
  /**
   * DB log được nội dung cần push luôn. 
   *  - thời gian bắt đầu push. 
   *  - thời gian push thực.
   *  - header
   *  - text content push luu dang text object
   *  - url điều hướng 
   *  - tyle_push: kiểm tra type để biết nhưng kiểu user được nhận.
   *  - key: để liên kết với các bảng gốc. BID_CODE ..... 
   */
  public function scanContentPush();
  public function logContentPushByUser();
  public function clearTableContentLogPush();
  public function getContentPush();
  public function getUserPush($item);
  public function pushNotify();
  public function sendMessage($include_player_ids,$content,$url,$headings='Mua Sắm Công');
}
class PushNotify_model extends CI_Model implements PushNotify{
  function __construct()
  {
      parent::__construct();
      $this->load->database();
      $this->base_url = base_url();
  }
  public function scanContentPush(){
    /**
     * lay 1 tieng 1 lan.
     * 0h hang ngay clear du lieu bang CONTENT_PUSH
     *
     * table TBL_PACKAGE_INFO
     * - lấy thông tin khi thay đổi.
     * - lấy thông tin khi gói thầu chính thức được thông báo mời thầu.
     * - tự đông cho theo dõi thông tin thông báo mời thâu. => sẽ nhận được các luồng cơ bản
     *
     * lấy những gói thầu mới được thông báo.
     * taọ thêm 1 cột VERSION_LOG. log lai trang thai hien tai cua cac goi thau.
     * select goi thau thay doi chi can lay nhung thang VERSION > 0 va VERSION_LOG != VERSION
     * 1. Phần thông báo mời thấu (các gói thầu theo dõi trong KHLCNT, Thông báo sơ tuyển + Thông báo đầu thầu) khi có sửa đổi, đính chính lại thông tin gì thì cái Mã TBMT thay đổi thì a bắt thông báo về có Nội dung "Gói thầu có số TBMT là … đã thay đổi thành số TVMT là: …."

     * 2. Thời điểm đấu thầu
     * Push thời gian  Đăng tải/ phát hành thì câu thông báo Ví dụ:  "Gói thầu có Số TBMT là …. sẽ đóng thầu vào lúc (mấy giờ ngày bao nhiêu)"

     * 3. Phần Kết quả thì thông báo:
     * Gói thầu ………. đã đăng tải kết quả
     */
    
    $call=1;
    if(!empty($_GET['call'])){
        $call = (int)$_GET['call'];
    }
    echo $call;

    //scan cac goi thau co cap nhat hay doi - bang TBL_BID_PACKAGES
    //gói thầu được gia hạn thời điểm đóng thầu - khi vession thay đổi + thời gian đống thầu thay đổi (FINISH_SUBMISSION_DATE,PRE_FINISH_DOC_DATE) -> gia hạn thời gian đóng thầu
    if($call==1){
      //sử lý gia hạn thời điểm đóng thầu 
        $where = 'where (a1.NOTI_VERSION_NUM > 0 and a1.NOTI_VERSION_NUM != a1.NOTI_VERSION_NUM_LOG 
                    and ( 
                      (a1.PREQUALIFICATION_STATUS=1 and a1.PRE_FINISH_DOC_DATE != a1.PRE_FINISH_DOC_DATE_LOG and a1.PRE_FINISH_DOC_DATE_LOG is not null) 
                      or 
                      ((a1.PREQUALIFICATION_STATUS!=1 or a1.PREQUALIFICATION_STATUS is null) and  a1.FINISH_SUBMISSION_DATE != a1.FINISH_SUBMISSION_DATE_LOG and a1.FINISH_SUBMISSION_DATE_LOG is not null) 
                    )) ';
        $sql = 'INSERT INTO CONTENT_PUSH("NAME_TABLE","BID_PACKAGE_CODE","TABLE_ID","TYPE_PUSH","DATE_CREATED",
            "CONTENT_PUSH","TIME_START_PUSH","TIME_END_PUSH","TIMES","NOTI_VERSION_NUM_LOG","URL","HEADER")
            select 
                \'TBL_BID_PACKAGES\' as NAME_TABLE,
                a1.BID_PACKAGE_CODE,
                a1.BID_PACKAGE_ID as TABLE_ID,
                \'gia_han_thoi_diem_dong_thau\' as TYPE_PUSH,
                SYSDATE as DATE_CREATED,
                CONCAT(\'Số TBMT: \',
                  CONCAT(a1.BID_PACKAGE_CODE,
                    CONCAT(\' - \',
                      CONCAT(case when a1.NOTI_VERSION_NUM_LOG<10 then CONCAT(\'0\',a1.NOTI_VERSION_NUM_LOG) else a1.NOTI_VERSION_NUM_LOG end,
                        CONCAT(\'__.__ Tên gói thầu: \',
                          CONCAT(a1.PACKAGE_NAME,
                            CONCAT(\'__.__ Thời điểm đóng thầu mới:\',case when a1.PREQUALIFICATION_STATUS=1 then to_char(a1.PRE_FINISH_DOC_DATE, \'dd-mm-yyyy hh24:mi\') else to_char(a1.FINISH_SUBMISSION_DATE, \'dd-mm-yyyy hh24:mi\') end))))))) as CONTENT_PUSH,
                SYSDATE as TIME_START_PUSH,
                null as TIME_END_PUSH,
                0 as TIMES,
                a1.NOTI_VERSION_NUM,
                case when a1.PREQUALIFICATION_STATUS=1 then CONCAT(\'/thong_tin_goi_thau_so_tuyen_chi_tiet/\',a1.BID_PACKAGE_ID) else CONCAT(\'/thong_tin_goi_thau___chi_tiet/\',a1.BID_PACKAGE_ID) end as "URL",
                \'Gia hạn thời điểm đóng thầu!\' as "HEADER"
            from TBL_BID_PACKAGES a1 '.$where;
        $this->db->query($sql);
        //update NOTI_VERSION_NUM_LOG, PRE_FINISH_DOC_DATE_LOG, FINISH_SUBMISSION_DATE_LOG
        $sql = 'update TBL_BID_PACKAGES a1
                  set NOTI_VERSION_NUM_LOG=NOTI_VERSION_NUM,
                  PRE_FINISH_DOC_DATE_LOG = PRE_FINISH_DOC_DATE,
                  FINISH_SUBMISSION_DATE_LOG = FINISH_SUBMISSION_DATE
                '.$where;
        $this->db->query($sql);
        //update PRE_FINISH_DOC_DATE_LOG and FINISH_SUBMISSION_DATE_LOG cho cho lan dau 
        $sql = 'update TBL_BID_PACKAGES a1
                  set PRE_FINISH_DOC_DATE_LOG = PRE_FINISH_DOC_DATE,
                  FINISH_SUBMISSION_DATE_LOG = FINISH_SUBMISSION_DATE
                where (a1.PREQUALIFICATION_STATUS=1 and a1.PRE_FINISH_DOC_DATE_LOG is null) 
                or 
                ((a1.PREQUALIFICATION_STATUS!=1 or a1.PREQUALIFICATION_STATUS is null) and a1.FINISH_SUBMISSION_DATE_LOG is null)  ';
        $this->db->query($sql);
      //end: sử lý gia hạn thời điểm đóng thầu 
      
      //cap nhat hay doi khác
        $where = 'where a1.NOTI_VERSION_NUM > 0 and a1.NOTI_VERSION_NUM != a1.NOTI_VERSION_NUM_LOG';
        $sql = 'INSERT INTO CONTENT_PUSH("NAME_TABLE","BID_PACKAGE_CODE","TABLE_ID","TYPE_PUSH","DATE_CREATED",
            "CONTENT_PUSH","TIME_START_PUSH","TIME_END_PUSH","TIMES","NOTI_VERSION_NUM_LOG","URL","HEADER")
            select 
                \'TBL_BID_PACKAGES\' as NAME_TABLE,
                a1.BID_PACKAGE_CODE,
                a1.BID_PACKAGE_ID as TABLE_ID,
                \'thay_doi_thong_tin_gt\' as TYPE_PUSH,
                SYSDATE as DATE_CREATED,
                CONCAT(\'Số TBMT: \',CONCAT(a1.BID_PACKAGE_CODE,CONCAT(\' - \',CONCAT(case when a1.NOTI_VERSION_NUM_LOG<10 then CONCAT(\'0\',a1.NOTI_VERSION_NUM_LOG) else a1.NOTI_VERSION_NUM_LOG end,CONCAT(\'__.__ Tên gói thầu: \',a1.PACKAGE_NAME))))) as CONTENT_PUSH,
                SYSDATE as TIME_START_PUSH,
                null as TIME_END_PUSH,
                0 as TIMES,
                a1.NOTI_VERSION_NUM,
                case when a1.PREQUALIFICATION_STATUS=1 then CONCAT(\'/thong_tin_goi_thau_so_tuyen_chi_tiet/\',a1.BID_PACKAGE_ID) else CONCAT(\'/thong_tin_goi_thau___chi_tiet/\',a1.BID_PACKAGE_ID) end as "URL",
                case when a1.PREQUALIFICATION_STATUS=1 then \'Thông báo sơ tuyển thay đổi!\' else \'Thông báo mời thầu thay đổi!\' end as "HEADER"
            from TBL_BID_PACKAGES a1 
            '.$where;
        $this->db->query($sql);

        //update NOTI_VERSION_NUM_LOG
        $sql = 'update TBL_BID_PACKAGES 
                  set NOTI_VERSION_NUM_LOG=NOTI_VERSION_NUM
                '.$where;
        $this->db->query($sql);
      //end: cap nhat hay doi khác
    }
    //scan cac goi thau con trong khlcnt co cap nhat hay doi - TBL_PACKAGE_INFO
    // bỏ trường hợp này. vì dữ liệu ko có cập nhật thay đổi cho gói thầu con. mà chỉ cập nhật cho toàn kế hoạch lựa chọn nhà thầu.
    else if($call==2){
        return false;  
    }
    // dang thau chinh thuc - thong_bao_thau - TBL_BID_PACKAGES
    else if($call==3){
        $sql = 'INSERT INTO CONTENT_PUSH("NAME_TABLE","BID_PACKAGE_CODE","TABLE_ID","TYPE_PUSH","DATE_CREATED",
            "CONTENT_PUSH","TIME_START_PUSH","TIME_END_PUSH","TIMES","NOTI_VERSION_NUM_LOG","URL","HEADER")
            
            select \'TBL_BID_PACKAGES\' as NAME_TABLE,
              a1.BID_PACKAGE_CODE,
              a1.BID_PACKAGE_ID as TABLE_ID,
              \'thong_bao_thau\' as TYPE_PUSH,
              SYSDATE as DATE_CREATED,
              CONCAT(\'Số TBMT: \',
                CONCAT(a1.BID_PACKAGE_CODE,
                  CONCAT(\' - \',
                    CONCAT(case when a1.NOTI_VERSION_NUM_LOG<10 then CONCAT(\'0\',a1.NOTI_VERSION_NUM_LOG) else a1.NOTI_VERSION_NUM_LOG end,
                      CONCAT(\'__.__ Tên gói thầu: \',a1.PACKAGE_NAME))))) as CONTENT_PUSH,
              SYSDATE as TIME_START_PUSH,
              null as TIME_END_PUSH,
              0 as TIMES,
              a1.NOTI_VERSION_NUM,
              case when a1.PREQUALIFICATION_STATUS=1 then CONCAT(\'/thong_tin_goi_thau_so_tuyen_chi_tiet/\',a1.BID_PACKAGE_ID) else CONCAT(\'/thong_tin_goi_thau___chi_tiet/\',a1.BID_PACKAGE_ID) end as "URL",
              \'Đăng tải thông báo mời thầu!\' as "HEADER"
            from TBL_BID_PACKAGES a1
            inner join TBL_PACKAGE_INFO a3 on a3.CODE = a1.CODEKH
            left join CONTENT_PUSH a2 on a2.NAME_TABLE=\'TBL_BID_PACKAGES\' and a2.BID_PACKAGE_CODE=a1."BID_PACKAGE_CODE" and a2.TYPE_PUSH=\'thong_bao_thau\'
            where a2.ID is null and a1."CREATE_DATE" > TO_DATE(\''.date("Y-m-d").'\',\'yyyy-MM-dd\') and a1.PACKAGE_NAME = a3.PACKAGE_NAME';
        $this->db->query($sql);
    }
    //lấy những gói thầu chuẩn bị đóng thầu. dong_thau - TBL_BID_PACKAGES
    else if($call==4){
        //lấy những gói thầu chuẩn bị đóng thầu. (gói chinh thuc)
        $sql = 'INSERT INTO CONTENT_PUSH("NAME_TABLE","BID_PACKAGE_CODE","TABLE_ID","TYPE_PUSH","DATE_CREATED",
            "CONTENT_PUSH","TIME_START_PUSH","TIME_END_PUSH","TIMES","NOTI_VERSION_NUM_LOG","URL","HEADER")
            
            select \'TBL_BID_PACKAGES\' as NAME_TABLE,
                a1."BID_PACKAGE_CODE",
                a1."BID_PACKAGE_ID" as TABLE_ID,
                \'dong_thau\' as "TYPE_PUSH",
                SYSDATE as DATE_CREATED,
                CONCAT(\'Số TBMT: \',
                  CONCAT(a1.BID_PACKAGE_CODE,
                    CONCAT(\' - \',
                      CONCAT(case when a1.NOTI_VERSION_NUM_LOG<10 then CONCAT(\'0\',a1.NOTI_VERSION_NUM_LOG) else a1.NOTI_VERSION_NUM_LOG end,
                        CONCAT(\'__.__ Tên gói thầu: \',
                          CONCAT(a1.PACKAGE_NAME,
                            CONCAT(\'__.__ Thời điểm đóng thầu: \',to_char(a1.FINISH_SUBMISSION_DATE, \'dd-mm-yyyy hh24:mi\') ))))))) as CONTENT_PUSH,
                a1."FINISH_SUBMISSION_DATE" as TIME_START_PUSH,
                null as TIME_END_PUSH,
                0 as TIMES,
                a1.NOTI_VERSION_NUM,
                CONCAT(\'/thong_tin_goi_thau___chi_tiet/\',a1.BID_PACKAGE_ID) as "URL",
                \'Đóng thầu!\' as "HEADER"
            from "TBL_BID_PACKAGES" a1 
            left join CONTENT_PUSH a2 on a2.NAME_TABLE=\'TBL_BID_PACKAGES\' and a2.BID_PACKAGE_CODE=a1."BID_PACKAGE_CODE" and a2.TYPE_PUSH=\'dong_thau\'
            where (a1."PREQUALIFICATION_STATUS" !=  \'1\' or a1."PREQUALIFICATION_STATUS" is null) 
              and a2.ID is null
              and a1."FINISH_SUBMISSION_DATE" <= TO_DATE(\''.date('Y-m-d',strtotime(date("Y-m-d") . "+1 days")).'\',\'yyyy-MM-dd\') and a1."FINISH_SUBMISSION_DATE" >= TO_DATE(\''.date('Y-m-d').'\',\'yyyy-MM-dd\')';
        $this->db->query($sql);

        
        //lấy những gói thầu chuẩn bị đóng thầu. (gói sơ tuyển)
        $sql = 'INSERT INTO CONTENT_PUSH("NAME_TABLE","BID_PACKAGE_CODE","TABLE_ID","TYPE_PUSH","DATE_CREATED",
        "CONTENT_PUSH","TIME_START_PUSH","TIME_END_PUSH","TIMES","NOTI_VERSION_NUM_LOG","URL","HEADER")
        
        select \'TBL_BID_PACKAGES\' as TBL_BID_PACKAGES,
          a1."BID_PACKAGE_CODE",
          a1."BID_PACKAGE_ID" as TABLE_ID,
          \'dong_thau\' as "TYPE_PUSH",
          SYSDATE as DATE_CREATED,
          CONCAT(\'Số TBMT: \',
            CONCAT(a1.BID_PACKAGE_CODE,
              CONCAT(\' - \',
                CONCAT(case when a1.NOTI_VERSION_NUM_LOG<10 then CONCAT(\'0\',a1.NOTI_VERSION_NUM_LOG) else a1.NOTI_VERSION_NUM_LOG end,
                  CONCAT(\'__.__ Tên gói thầu: \',
                    CONCAT(a1.PACKAGE_NAME,
                      CONCAT(\'__.__ Thời điểm đóng thầu: \',to_char(a1.PRE_FINISH_DOC_DATE, \'dd-mm-yyyy hh24:mi\') ))))))) as CONTENT_PUSH,
          a1."PRE_FINISH_DOC_DATE" as TIME_START_PUSH,
          null as TIME_END_PUSH,
          0 as TIMES,
          a1.NOTI_VERSION_NUM,
          CONCAT(\'/thong_tin_goi_thau_so_tuyen_chi_tiet/\',a1.BID_PACKAGE_ID) as "URL",
          \'Đóng thầu!\' as "HEADER"
        from "TBL_BID_PACKAGES" a1 
        left join CONTENT_PUSH a2 on a2.NAME_TABLE=\'TBL_BID_PACKAGES\' and a2.BID_PACKAGE_CODE=a1."BID_PACKAGE_CODE" and a2.TYPE_PUSH=\'dong_thau\'
        where (a1."PREQUALIFICATION_STATUS" =  \'1\') 
          and a2.ID is null
          and a1."PRE_FINISH_DOC_DATE" <= TO_DATE(\''.date('Y-m-d',strtotime(date("Y-m-d") . "+1 days")).'\',\'yyyy-MM-dd\') and a1."PRE_FINISH_DOC_DATE" >= TO_DATE(\''.date('Y-m-d').'\',\'yyyy-MM-dd\')';
        $this->db->query($sql);
    }
    // lấy những gói thầu đã được công bố kết quả - thong_bao_ket_qua - TBL_BIDINGS
    else if($call==5){
        $sql = 'INSERT INTO CONTENT_PUSH("NAME_TABLE","BID_PACKAGE_CODE","TABLE_ID","TYPE_PUSH","DATE_CREATED",
            "CONTENT_PUSH","TIME_START_PUSH","TIME_END_PUSH","TIMES","NOTI_VERSION_NUM_LOG","URL","HEADER")

            select \'TBL_BIDINGS\' as NAME_TABLE,
                a1.BID_PACKAGE_CODE,
                a1.BIDING_ID as TABLE_ID,
                \'thong_bao_ket_qua\' as TYPE_PUSH,
                SYSDATE as DATE_CREATED,
                CONCAT(\'Số TBMT: \',
                  CONCAT(a1.BID_PACKAGE_CODE,
                    CONCAT(\' - \',
                      CONCAT(case when a1.VERSION<10 then CONCAT(\'0\',TO_CHAR(a1.VERSION)) else TO_CHAR(a1.VERSION) end,
                        CONCAT(\'__.__ Tên gói thầu: \',
                          CONCAT(a1.PACKAGE_NAME,
                          case when a1.NOTI_TYPE=1 then \'\' else CONCAT(\'__.__ Nhà thầu trúng thầu: \',TO_CHAR(a1.BIDER_NAME) ) end )))))) as CONTENT_PUSH,
                SYSDATE as TIME_START_PUSH,
                null as TIME_END_PUSH,
                0 as TIMES,
                a1.VERSION,
                case when a1.NOTI_TYPE=1 then CONCAT(\'/ket_qua_dau_thau_so_tuyen_chi_tiet/\',a1.BIDING_ID) else CONCAT(\'/ket_qua_dau_thau___chi_tiet/\',a1.BIDING_ID) end as "URL",
                case when a1.NOTI_TYPE=1 then \'Kết quả sơ tuyển!\' else \'Kết quả lựa chọn nhà thầu!\' end as "HEADER"
            from TBL_BIDINGS a1
            inner join TBL_BID_PACKAGES a2 on a2.BID_PACKAGE_CODE = a1.BID_PACKAGE_CODE
            left join CONTENT_PUSH a3 on a3.NAME_TABLE=\'TBL_BIDINGS\' and a3.BID_PACKAGE_CODE=a1."BID_PACKAGE_CODE" and a3.TYPE_PUSH=\'thong_bao_ket_qua\'
            where a1.PUBLIC_DATE >= TO_DATE(\''.date("Y-m-d").'\',\'yyyy-MM-dd\') and a3."ID" is null';
        $this->db->query($sql);
    }
    //lấy những gói thầu được mở ban hs thầu hôm nay . mo_ban_ho_so_thau - TBL_BID_PACKAGES
    else if($call==6){
      //lấy những gói thầu được mở ban hs thầu hôm nay . cac goi thau chinh thuc
      $sql = 'INSERT INTO CONTENT_PUSH("NAME_TABLE","BID_PACKAGE_CODE","TABLE_ID","TYPE_PUSH","DATE_CREATED",
            "CONTENT_PUSH","TIME_START_PUSH","TIME_END_PUSH","TIMES","NOTI_VERSION_NUM_LOG","URL","HEADER")
            
            select \'TBL_BID_PACKAGES\' as NAME_TABLE,
                a1."BID_PACKAGE_CODE",
                a1."BID_PACKAGE_ID" as TABLE_ID,
                \'mo_ban_ho_so_thau\' as "TYPE_PUSH",
                SYSDATE as DATE_CREATED,
                CONCAT(\'Số TBMT: \',
                  CONCAT(a1.BID_PACKAGE_CODE,
                    CONCAT(\' - \',
                      CONCAT(case when a1.NOTI_VERSION_NUM_LOG<10 then CONCAT(\'0\',a1.NOTI_VERSION_NUM_LOG) else a1.NOTI_VERSION_NUM_LOG end,
                        CONCAT(\'__.__ Tên gói thầu: \',
                          CONCAT(a1.PACKAGE_NAME,
                            CONCAT(\'__.__ Thời gian phát hành: \',to_char(a1.START_SUBMISSION_DATE, \'dd-mm-yyyy hh24:mi\') ))))))) as CONTENT_PUSH,
                a1."START_SUBMISSION_DATE" as TIME_START_PUSH,
                null as TIME_END_PUSH,
                0 as TIMES,
                a1.NOTI_VERSION_NUM,
                CONCAT(\'/thong_tin_goi_thau___chi_tiet/\',a1.BID_PACKAGE_ID) as "URL",
                case when a1.BID_TYPE=1 then \'Phát hành hồ sơ mời thầu!\' else \'Đăng tải và phát hành hồ sơ mời thầu!\' end as "HEADER"
            from "TBL_BID_PACKAGES" a1 
            left join CONTENT_PUSH a2 on a2.NAME_TABLE=\'TBL_BID_PACKAGES\' and a2.BID_PACKAGE_CODE=a1."BID_PACKAGE_CODE" and a2.TYPE_PUSH=\'mo_ban_ho_so_thau\'
            where (a1."PREQUALIFICATION_STATUS" !=  \'1\' or a1."PREQUALIFICATION_STATUS" is null) 
              and a2.ID is null
              and a1."START_SUBMISSION_DATE" <= TO_DATE(\''.date('Y-m-d',strtotime(date("Y-m-d") . "+1 days")).'\',\'yyyy-MM-dd\') and a1."START_SUBMISSION_DATE" >= TO_DATE(\''.date('Y-m-d').'\',\'yyyy-MM-dd\')';
        $this->db->query($sql);

        //lấy những gói thầu được mở ban hs thầu hôm nay . cac goi thau so tuyen
        $sql = 'INSERT INTO CONTENT_PUSH("NAME_TABLE","BID_PACKAGE_CODE","TABLE_ID","TYPE_PUSH","DATE_CREATED",
            "CONTENT_PUSH","TIME_START_PUSH","TIME_END_PUSH","TIMES","NOTI_VERSION_NUM_LOG","URL","HEADER")
            
            select \'TBL_BID_PACKAGES\' as TBL_BID_PACKAGES,
                a1."BID_PACKAGE_CODE",
                a1."BID_PACKAGE_ID" as TABLE_ID,
                \'mo_ban_ho_so_thau\' as "TYPE_PUSH",
                SYSDATE as DATE_CREATED,
                CONCAT(\'Số TBMT: \',
                  CONCAT(a1.BID_PACKAGE_CODE,
                    CONCAT(\' - \',
                      CONCAT(case when a1.NOTI_VERSION_NUM_LOG<10 then CONCAT(\'0\',a1.NOTI_VERSION_NUM_LOG) else a1.NOTI_VERSION_NUM_LOG end,
                        CONCAT(\'__.__ Tên gói thầu: \',
                          CONCAT(a1.PACKAGE_NAME,
                            CONCAT(\'__.__ Thời gian phát hành: \',to_char(a1.PRE_START_DOC_DATE, \'dd-mm-yyyy hh24:mi\') ))))))) as CONTENT_PUSH,
                a1."PRE_START_DOC_DATE" as TIME_START_PUSH,
                null as TIME_END_PUSH,
                0 as TIMES,
                a1.NOTI_VERSION_NUM,
                CONCAT(\'/thong_tin_goi_thau_so_tuyen_chi_tiet/\',a1.BID_PACKAGE_ID) as "URL",
                case when a1.BID_TYPE=1 then \'Phát hành hồ sơ mời thầu!\' else \'Đăng tải và phát hành hồ sơ mời thầu!\' end as "HEADER"
              from "TBL_BID_PACKAGES" a1 
              left join CONTENT_PUSH a2 on a2.NAME_TABLE=\'TBL_BID_PACKAGES\' and a2.BID_PACKAGE_CODE=a1."BID_PACKAGE_CODE" and a2.TYPE_PUSH=\'mo_ban_ho_so_thau\'
              where (a1."PREQUALIFICATION_STATUS" !=  \'1\' or a1."PREQUALIFICATION_STATUS" is null) 
                and a2.ID is null
                and a1."PRE_START_DOC_DATE" <= TO_DATE(\''.date('Y-m-d',strtotime(date("Y-m-d") . "+1 days")).'\',\'yyyy-MM-dd\') 
                and a1."PRE_START_DOC_DATE" >= TO_DATE(\''.date('Y-m-d').'\',\'yyyy-MM-dd\')';
        $this->db->query($sql);
    }
    //lay nhung goi thau co thong bao mo thau hom nay. PRIORITY = 1 (ưu tiên cao nhất) - mo_thau - TBL_BID_PACKAGES
    else if($call==7){
        //log thoi gian bắt đầu push sau 2 phut 
        //khi quest ban push thì ưu tiên theo 1.PRIORITY, thằng có thời gian start push trước và sắp sếp tăng dâng. start push < now 
        // - lay nhung thang thong bao mo thau
        $sql = 'INSERT INTO CONTENT_PUSH("NAME_TABLE","BID_PACKAGE_CODE","TABLE_ID","TYPE_PUSH","DATE_CREATED",
            "CONTENT_PUSH","TIME_START_PUSH","TIME_END_PUSH","TIMES","NOTI_VERSION_NUM_LOG","PRIORITY","URL","HEADER")
            
            select \'TBL_BID_PACKAGES\' as NAME_TABLE,
              a1."BID_PACKAGE_CODE",
              a1."BID_PACKAGE_ID" as TABLE_ID,
              \'mo_thau\' as "TYPE_PUSH",
              SYSDATE as DATE_CREATED,
              CONCAT(\'Số TBMT: \',
                CONCAT(a1.BID_PACKAGE_CODE,
                  CONCAT(\' - \',
                    CONCAT(case when a1.NOTI_VERSION_NUM_LOG<10 then CONCAT(\'0\',a1.NOTI_VERSION_NUM_LOG) else a1.NOTI_VERSION_NUM_LOG end,
                      CONCAT(\'__.__ Tên gói thầu: \',
                        CONCAT(a1.PACKAGE_NAME,
                          CONCAT(\'__.__ Thời điểm mở thầu: \',to_char(a1.OPEN_DATE, \'dd-mm-yyyy hh24:mi\') ))))))) as CONTENT_PUSH,
              OPEN_DATE as TIME_START_PUSH,
              null as TIME_END_PUSH,
              0 as TIMES,
              a1.NOTI_VERSION_NUM,
              1 as PRIORITY,
              CONCAT(\'/thong_tin_goi_thau___chi_tiet/\',a1.BID_PACKAGE_ID) as "URL",
              case when a1.STAGE_BIDDING=\'Một giai đoạn một túi hồ sơ\' or a1.STAGE_BIDDING is null then \'Mở thầu!\' else \'Mở hồ sơ đề xuất tài chính!\' end as "HEADER"
            from "TBL_BID_PACKAGES" a1 
            left join CONTENT_PUSH a2 on a2.NAME_TABLE=\'TBL_BID_PACKAGES\' and a2.BID_PACKAGE_CODE=a1."BID_PACKAGE_CODE" and a2.TYPE_PUSH=\'mo_thau\'
            where (a1."PREQUALIFICATION_STATUS" !=  \'1\' or a1."PREQUALIFICATION_STATUS" is null) 
              and a2.ID is null
              and a1."OPEN_DATE" <= TO_DATE(\''.date('Y-m-d',strtotime(date("Y-m-d") . "+1 days")).'\',\'yyyy-MM-dd\') and a1."OPEN_DATE" >= TO_DATE(\''.date('Y-m-d').'\',\'yyyy-MM-dd\')';
        $this->db->query($sql);

        // - lay nhung thang thong bao mo thau so tuyen 
        $sql = 'INSERT INTO CONTENT_PUSH("NAME_TABLE","BID_PACKAGE_CODE","TABLE_ID","TYPE_PUSH","DATE_CREATED",
            "CONTENT_PUSH","TIME_START_PUSH","TIME_END_PUSH","TIMES","NOTI_VERSION_NUM_LOG","PRIORITY","URL","HEADER")
            
            select \'TBL_BID_PACKAGES\' as TBL_BID_PACKAGES,
              a1."BID_PACKAGE_CODE",
              a1."BID_PACKAGE_ID" as TABLE_ID,
              \'mo_thau\' as "TYPE_PUSH",
              SYSDATE as DATE_CREATED,
              CONCAT(\'Số TBMT: \',
                CONCAT(a1.BID_PACKAGE_CODE,
                  CONCAT(\' - \',
                    CONCAT(case when a1.NOTI_VERSION_NUM_LOG<10 then CONCAT(\'0\',a1.NOTI_VERSION_NUM_LOG) else a1.NOTI_VERSION_NUM_LOG end,
                      CONCAT(\'__.__ Tên gói thầu: \',
                        CONCAT(a1.PACKAGE_NAME,
                          CONCAT(\'__.__ Thời điểm mở thầu: \',to_char(a1.PRE_OPEN_DATE, \'dd-mm-yyyy hh24:mi\') ))))))) as CONTENT_PUSH,
              PRE_OPEN_DATE as TIME_START_PUSH,
              null as TIME_END_PUSH,
              0 as TIMES,
              a1.NOTI_VERSION_NUM,
              1 as PRIORITY,
              CONCAT(\'/thong_tin_goi_thau_so_tuyen_chi_tiet/\',a1.BID_PACKAGE_ID) as "URL",
              case when a1.STAGE_BIDDING=\'Một giai đoạn một túi hồ sơ\' or a1.STAGE_BIDDING is null then \'Mở thầu!\' else \'Mở hồ sơ đề xuất tài chính!\' end as "HEADER"
            from "TBL_BID_PACKAGES" a1 
            left join CONTENT_PUSH a2 on a2.NAME_TABLE=\'TBL_BID_PACKAGES\' and a2.BID_PACKAGE_CODE=a1."BID_PACKAGE_CODE" and a2.TYPE_PUSH=\'mo_thau\'
            where a1."PREQUALIFICATION_STATUS" =  \'1\' 
              and a2.ID is null
              and a1."PRE_OPEN_DATE" <= TO_DATE(\''.date('Y-m-d',strtotime(date("Y-m-d") . "+1 days")).'\',\'yyyy-MM-dd\') and a1."PRE_OPEN_DATE" >= TO_DATE(\''.date('Y-m-d').'\',\'yyyy-MM-dd\')';
        $this->db->query($sql);
        //PRE_OPEN_DATE
    }
    //gói thầu bị hủy BID_CANCEL_DATE is not null, va chua luu vao bang CONTENT_PUSH
    else if($call==8){
      $sql = 'INSERT INTO CONTENT_PUSH("NAME_TABLE","BID_PACKAGE_CODE","TABLE_ID","TYPE_PUSH","DATE_CREATED",
          "CONTENT_PUSH","TIME_START_PUSH","TIME_END_PUSH","TIMES","NOTI_VERSION_NUM_LOG","URL","HEADER")
          
          select \'TBL_BID_PACKAGES\' as NAME_TABLE,
            a1."BID_PACKAGE_CODE",
            a1."BID_PACKAGE_ID" as TABLE_ID,
            \'huy_thau\' as "TYPE_PUSH",
            SYSDATE as DATE_CREATED,
            CONCAT(\'Số TBMT: \',
              CONCAT(a1.BID_PACKAGE_CODE,
                CONCAT(\' - \',
                  CONCAT(case when a1.NOTI_VERSION_NUM_LOG<10 then CONCAT(\'0\',a1.NOTI_VERSION_NUM_LOG) else a1.NOTI_VERSION_NUM_LOG end,
                    CONCAT(\'__.__ Tên gói thầu: \',
                      CONCAT(a1.PACKAGE_NAME,
                        CONCAT(\'__.__ Lý do huỷ thầu: \',a1.BID_CANCEL_REASON ))))))) as CONTENT_PUSH,
            SYSDATE as TIME_START_PUSH,
            null as TIME_END_PUSH,
            0 as TIMES,
            a1.NOTI_VERSION_NUM,
            case when a1.PREQUALIFICATION_STATUS=1 then CONCAT(\'/thong_tin_goi_thau_so_tuyen_chi_tiet/\',a1.BID_PACKAGE_ID) else CONCAT(\'/thong_tin_goi_thau___chi_tiet/\',a1.BID_PACKAGE_ID) end as "URL",
            \'Huỷ thầu!\' as "HEADER"
          from "TBL_BID_PACKAGES" a1 
          left join CONTENT_PUSH a2 on a2.NAME_TABLE=\'TBL_BID_PACKAGES\' and a2.BID_PACKAGE_CODE=a1."BID_PACKAGE_CODE" and a2.TYPE_PUSH=\'huy_thau\'
          where a2.ID is null
            and a1.BID_CANCEL_DATE is not null';
      $this->db->query($sql);
    }
    //"Yêu cầu làm rõ Hồ sơ mời thầu!" - Chỉ đối vơi Bên mời thầu
    else if($call == 9){
      $sql = 'INSERT INTO CONTENT_PUSH("NAME_TABLE","BID_PACKAGE_CODE","TABLE_ID","TYPE_PUSH","DATE_CREATED",
          "CONTENT_PUSH","TIME_START_PUSH","TIME_END_PUSH","TIMES","NOTI_VERSION_NUM_LOG","URL","HEADER")
          
          select \'TBL_QUESTION\' as NAME_TABLE,
            a1."BID_CODE",
            a1."ID" as TABLE_ID,
            \'lam_ro_ho_so_moi_thau\' as "TYPE_PUSH",
            SYSDATE as DATE_CREATED,
            CONCAT(\'Số TBMT: \',
              CONCAT(a1.BID_CODE,
                CONCAT(\' - \',
                  CONCAT(a1.BID_VERSION,
                    CONCAT(\'__.__ Tên gói thầu: \',
                      CONCAT(a3.PACKAGE_NAME,
                        CONCAT(\'__.__ Nhà thầu yêu cầu: \',TO_CHAR(a4.BIDER_NAME) ))))))) as CONTENT_PUSH,
            SYSDATE as TIME_START_PUSH,
            null as TIME_END_PUSH,
            0 as TIMES,
            a3.NOTI_VERSION_NUM,
            \'/home\' as "URL",
            \'Yêu cầu làm rõ Hồ sơ mời thầu!\' as "HEADER"
          from TBL_QUESTION a1
          inner join "TBL_BID_PACKAGES" a3 on a3.BID_PACKAGE_CODE = a1.BID_CODE
          left join "TBL_BIDERS" a4 on a4.BUSSINESS_REGISTRATION_NUM = a1.biz_code
          left join CONTENT_PUSH a5 on a5.NAME_TABLE=\'TBL_QUESTION\' and a5.TABLE_ID=a1."ID" and a5.TYPE_PUSH=\'lam_ro_ho_so_moi_thau\'
          where a5."ID" is null and a1.QUESTION_TYPE = \'HSMT\'';
      $this->db->query($sql);
    }
    //"Yêu cầu làm rõ Hồ sơ dự thầu!" - Chỉ đối với nhà thầu
    else if($call == 10){
      $sql = 'INSERT INTO CONTENT_PUSH("NAME_TABLE","BID_PACKAGE_CODE","TABLE_ID","TYPE_PUSH","DATE_CREATED",
          "CONTENT_PUSH","TIME_START_PUSH","TIME_END_PUSH","TIMES","NOTI_VERSION_NUM_LOG","URL","HEADER")
          
          select \'TBL_QUESTION\' as NAME_TABLE,
            a1."BID_CODE",
            a1."ID" as TABLE_ID,
            \'lam_ro_ho_so_du_thau\' as "TYPE_PUSH",
            SYSDATE as DATE_CREATED,
            CONCAT(\'Số TBMT: \',
              CONCAT(a1.BID_CODE,
                CONCAT(\' - \',
                  CONCAT(a1.BID_VERSION,
                    CONCAT(\'__.__ Tên gói thầu: \',
                      CONCAT(a3.PACKAGE_NAME,
                        CONCAT(\'__.__ Bên mời thầu: \',TO_CHAR(a4.PROCURING_NAME) ))))))) as CONTENT_PUSH,
            SYSDATE as TIME_START_PUSH,
            null as TIME_END_PUSH,
            0 as TIMES,
            a3.NOTI_VERSION_NUM,
            \'/home\' as "URL",
            \'Yêu cầu làm rõ Hồ sơ dự thầu!\' as "HEADER"
          from TBL_QUESTION a1
          inner join "TBL_BID_PACKAGES" a3 on a3.BID_PACKAGE_CODE = a1.BID_CODE
          left join "TBL_PROCURINGS" a4 on a3."PROCURING_CODE" = a4."PROCURING_CODE"
          left join CONTENT_PUSH a5 on a5.NAME_TABLE=\'TBL_QUESTION\' and a5.TABLE_ID=a1."ID" and a5.TYPE_PUSH=\'lam_ro_ho_so_du_thau\'
          where a5."ID" is null and a1.QUESTION_TYPE = \'HSDT\'';
      $this->db->query($sql);
    }
    //"Trả lời làm rõ Hồ sơ mời thầu!" - Chỉ đối với nhà thầu. tất cả mọi người theo dõ gói thầu đều nhận được push
    else if($call == 11){
      $sql = 'INSERT INTO CONTENT_PUSH("NAME_TABLE","BID_PACKAGE_CODE","TABLE_ID","TYPE_PUSH","DATE_CREATED",
          "CONTENT_PUSH","TIME_START_PUSH","TIME_END_PUSH","TIMES","NOTI_VERSION_NUM_LOG","URL","HEADER")
          
          select \'TBL_ANSWER\' as NAME_TABLE,
            a1."BID_CODE",
            a1."ID" as TABLE_ID,
            \'tra_loi_lam_ro_ho_so_moi_thau\' as "TYPE_PUSH",
            SYSDATE as DATE_CREATED,
            CONCAT(\'Số TBMT: \',
              CONCAT(a1.BID_CODE,
                CONCAT(\' - \',
                  CONCAT(a1.BID_VERSION,
                    CONCAT(\'__.__ Tên gói thầu: \',
                      CONCAT(a3.PACKAGE_NAME,
                        CONCAT(\'__.__ Bên mời thầu: \',TO_CHAR(a4.PROCURING_NAME) ))))))) as CONTENT_PUSH,
            SYSDATE as TIME_START_PUSH,
            null as TIME_END_PUSH,
            0 as TIMES,
            a3.NOTI_VERSION_NUM,
            \'/home\' as "URL",
            \'Trả lời làm rõ Hồ sơ mời thầu!\' as "HEADER"
          from TBL_ANSWER a1
          inner join "TBL_BID_PACKAGES" a3 on a3.BID_PACKAGE_CODE = a1.BID_CODE
          left join "TBL_PROCURINGS" a4 on a3."PROCURING_CODE" = a4."PROCURING_CODE"
          left join CONTENT_PUSH a5 on a5.NAME_TABLE=\'TBL_ANSWER\' and a5.TABLE_ID=a1."ID" and a5.TYPE_PUSH=\'tra_loi_lam_ro_ho_so_moi_thau\'
          where a5."ID" is null and a1.ANSWER_TYPE = \'HSMT\'';
      $this->db->query($sql);
    }
    //"trả lời làm rõ Hồ sơ dự thầu!" - Chỉ đối với bên mời thầu
    else if($call == 12){
      $sql = 'INSERT INTO CONTENT_PUSH("NAME_TABLE","BID_PACKAGE_CODE","TABLE_ID","TYPE_PUSH","DATE_CREATED",
          "CONTENT_PUSH","TIME_START_PUSH","TIME_END_PUSH","TIMES","NOTI_VERSION_NUM_LOG","URL","HEADER")
          
          select \'TBL_ANSWER\' as TBL_BID_PACKAGES,
            a1."BID_CODE",
            a1."ID" as TABLE_ID,
            \'tra_loi_lam_ro_ho_so_du_thau\' as "TYPE_PUSH",
            SYSDATE as DATE_CREATED,
            CONCAT(\'Số TBMT: \',
              CONCAT(a1.BID_CODE,
                CONCAT(\' - \',
                  CONCAT(a1.BID_VERSION,
                    CONCAT(\'__.__ Tên gói thầu: \',
                      CONCAT(a3.PACKAGE_NAME,
                        CONCAT(\'__.__ Nhà thầu làm rõ: \',TO_CHAR(a4.BIDER_NAME) ))))))) as CONTENT_PUSH,
            SYSDATE as TIME_START_PUSH,
            null as TIME_END_PUSH,
            0 as TIMES,
            a3.NOTI_VERSION_NUM,
            \'/home\' as "URL",
            \'Trả lời làm rõ Hồ sơ dự thầu!\' as "HEADER"
          from TBL_ANSWER a1
          inner join "TBL_BID_PACKAGES" a3 on a3.BID_PACKAGE_CODE = a1.BID_CODE
          left join "TBL_BIDERS" a4 on a4.BUSSINESS_REGISTRATION_NUM = a1.biz_code
          left join CONTENT_PUSH a5 on a5.NAME_TABLE=\'TBL_ANSWER\' and a5.TABLE_ID=a1."ID" and a5.TYPE_PUSH=\'tra_loi_lam_ro_ho_so_du_thau\'
          where a5."ID" is null and a1.ANSWER_TYPE = \'HSDT\'';
      $this->db->query($sql);
    }
    //Phê duyệt đăng ký Nhà thầu!" - Chỉ đối với nhà thầu
    // else if($call == 17){
    //   $sql = 'INSERT INTO CONTENT_PUSH("NAME_TABLE","BID_PACKAGE_CODE","TABLE_ID","TYPE_PUSH","DATE_CREATED",
    //       "CONTENT_PUSH","TIME_START_PUSH","TIME_END_PUSH","TIMES","NOTI_VERSION_NUM_LOG","URL","HEADER")

          
    //       '
    // }
  }
  public function logContentPushByUser(){
    $sql = "INSERT INTO AW_USERS_CONTENT_PUSH(USER_ID,CONTENT_PUSH_ID,PACKAGE_NAME,URL,STATUS_VIEW)
      select a1.USER_ID,a1.ID,a1.PACKAGE_NAME,a1.URL,0 as STATUS_VIEW
      from (
       select a.ID,a2.USER_ID,a3.PACKAGE_NAME,
          (CASE 
               WHEN a3.PREQUALIFICATION_STATUS=1 THEN '/thong_tin_goi_thau_so_tuyen_chi_tiet/' 
               WHEN a3.PREQUALIFICATION_STATUS!=1 THEN '/thong_tin_goi_thau___chi_tiet/' 
               ELSE '' 
           END
           ) as URL
       from CONTENT_PUSH a
       inner join TBL_PACKAGE_FOLLOWS_V2 a2 on a2.BID_PACKAGE_CODE = a.BID_PACKAGE_CODE 
       left join TBL_BID_PACKAGES a3 on a3.BID_PACKAGE_ID = a.TABLE_ID  
       where a.STATUS_PUSH =1 and a.NAME_TABLE='TBL_BID_PACKAGES'
      
       UNION
      
       select a.ID,a2.USER_ID,a3.PACKAGE_NAME,
          '/khlcnt___chi_tiet_goi_thau/' as URL
       from CONTENT_PUSH a
       inner join TBL_PACKAGE_FOLLOWS_V2 a2 on a2.BID_PACKAGE_CODE = a.BID_PACKAGE_CODE 
       left join TBL_PACKAGE_INFO a3 on a3.ID = a.TABLE_ID  
       where a.STATUS_PUSH =1 and a.NAME_TABLE='TBL_PACKAGE_INFO'

       UNION
      
       select a.ID,a2.USER_ID,a3.PACKAGE_NAME,
          (CASE 
               WHEN a3.NOTI_TYPE=1 THEN '/ket_qua_dau_thau_so_tuyen_chi_tiet/' 
               WHEN a3.NOTI_TYPE!=1 THEN '/ket_qua_dau_thau___chi_tiet/' 
               ELSE '' 
           END
           ) as URL
       from CONTENT_PUSH a
       inner join TBL_PACKAGE_FOLLOWS_V2 a2 on a2.BID_PACKAGE_CODE = a.BID_PACKAGE_CODE 
       left join TBL_BIDINGS a3 on a3.BIDING_ID = a.TABLE_ID  
       where a.STATUS_PUSH =1 and a.NAME_TABLE='TBL_BIDINGS'
      ) a1
      left join AW_USERS_CONTENT_PUSH a2 on a1.id = a2.content_push_id and a1.USER_ID = a2.user_id
      where a2.id is null";
      $this->db->query($sql);
  }
  public function clearTableContentLogPush(){
    // nhung thang cuối ngày mà chưa push. thì update STATUS_PUSH = 2. để ko quest push nữa. nhưng ko xóa, vì có nhiều thằng check tồn tại trong bảng để scall content push
    $sql = 'update CONTENT_PUSH set STATUS_PUSH=2 where STATUS_PUSH is null';
    // //chi xoa nhung thang chua duoc push. thang nao duoc push thi luu lai con sau de view trong lich su
    // $sql = 'delete from CONTENT_PUSH where STATUS_PUSH is null';
    $this->db->query($sql);
  }
  public function getContentPush(){
    
  }
  public function getUserPush($item){
    $include_player_ids = array();
    $arrCk = array(
      'lam_ro_ho_so_moi_thau','tra_loi_lam_ro_ho_so_moi_thau','lam_ro_ho_so_du_thau',
      'tra_loi_lam_ro_ho_so_du_thau','bao_cao_danh_gia_ho_so_du_thau'
    );

    if($item['TYPE_PUSH']=='lam_ro_ho_so_moi_thau' || $item['TYPE_PUSH']=='lam_ro_ho_so_du_thau'){
      // BIZ_SUPPLIER_CD
      $sql = 'select a5.DEVICES_ID
      from CONTENT_PUSH a1
      left join TBL_QUESTION a3 on a3.id = a1.table_id
      left join AW_USER_ORGANIZATION a4 on '.
      ($item['TYPE_PUSH']=='lam_ro_ho_so_moi_thau'?'a4.organization_id = a3.ORG_CODE':'a4.organization_id = a3.BIZ_SUPPLIER_CD')
      .' left join TBL_USERS a5 on a5.USER_ID = a4.USER_ID
      where a5.DEVICES_ID is not null and a1.NAME_TABLE = \'TBL_QUESTION\' and a1.ID = '.$item['ID'];
      $query = $this->db->query($sql);
      $res =  $query->result_array();
      foreach ($res as $vl){
        $include_player_ids[]=$vl['DEVICES_ID'];
      }
    }
    else if($item['TYPE_PUSH']=='tra_loi_lam_ro_ho_so_moi_thau' || $item['TYPE_PUSH']=='tra_loi_lam_ro_ho_so_du_thau'){
      //BIZ_CODE đơn vị khởi tạo câu hỏi (mã cơ quan hoặc số đăng ký kinh doanh)
      $sql = 'select a5.DEVICES_ID
      from CONTENT_PUSH a1
      left join TBL_ANSWER a2 on a2.id = a1.table_id
      left join TBL_QUESTION a3 on a3.id = a2.question_id
      left join AW_USER_ORGANIZATION a4 on a4.organization_id = a3.BIZ_CODE 
      left join TBL_USERS a5 on a5.USER_ID = a4.USER_ID
      where a5.DEVICES_ID is not null and a1.NAME_TABLE = \'TBL_ANSWER\' and a1.ID = '.$item['ID'];
      $query = $this->db->query($sql);
      $res =  $query->result_array();
      foreach ($res as $vl){
        $include_player_ids[]=$vl['DEVICES_ID'];
      }
    }

    if(!in_array($item['TYPE_PUSH'],$arrCk) || $item['TYPE_PUSH']=='tra_loi_lam_ro_ho_so_moi_thau'){
      $sql = ' select a3.DEVICES_ID
      from TBL_USERS a3 
      inner join TBL_PACKAGE_FOLLOWS_V2 a2 on a2.USER_ID = a3.USER_ID 
      left join AW_TYPE_PUSH b1 on b1.KEY_TYPE = \''.$item['TYPE_PUSH'].'\'
      left join AW_USERS_TYPE_PUSH b2 on b2.type_push_id=b1.id and b2.user_id = a2.user_id 
      where a3.DEVICES_ID is not null and (b2.send_push is null or b2.send_push=1) and a2.BID_PACKAGE_CODE = \''.$item['BID_PACKAGE_CODE'].'\' 
            and (b2.send_push is null or b2.send_push=1)';
      $query = $this->db->query($sql);
      $res =  $query->result_array();
      
      foreach ($res as $vl){
          $include_player_ids[]=$vl['DEVICES_ID'];
      }  
    }
    
    return $include_player_ids;
  }
  public function pushNotify(){
        
    /* call push
     * bắn cho all user theo device id,
     * check điều kiện push hoàn thành.
     *      với bắn thông báo có quyết định thầu, gói thầu đã được công bố hay đã có kết quả mời thầu+ có sự thay đổi. thì bắn xong log xong luôn để xóa
     *      bắn đến ngày hạn nộp hồ sơ cũng chỉ bắng 1 lần mà giới hạn bắn tới lúc hết nhận
     *      - tự tăng id
     */
    $where = '';
    $headings = 'Mua Sắm Công';
    if(!empty($_GET['TYPE_PUSH'])){
        $where = " and a.TYPE_PUSH = '".$this->db->escape_str(trim($_GET['TYPE_PUSH']))."' ";
    }
    
    $sql = 'SELECT a.* 
          FROM ( 
              select a.*,a2.USER_ID
              from CONTENT_PUSH a
              left join TBL_PACKAGE_FOLLOWS_V2 a2 on a2.BID_PACKAGE_CODE = a.BID_PACKAGE_CODE
              left join AW_TYPE_PUSH b1 on b1.KEY_TYPE = a.TYPE_PUSH
              left join AW_USERS_TYPE_PUSH b2 on b2.type_push_id=b1.id and b2.user_id = a2.user_id
              where (a2.USER_ID is not null or 
                a.TYPE_PUSH in (\'lam_ro_ho_so_moi_thau\',\'tra_loi_lam_ro_ho_so_moi_thau\',\'lam_ro_ho_so_du_thau\',\'tra_loi_lam_ro_ho_so_du_thau\',\'bao_cao_danh_gia_ho_so_du_thau\'))
                and (b2.send_push is null or b2.send_push=1) and a.STATUS_PUSH is null 
                '.$where.'
              order by a.priority , a.time_start_push
          ) a
          where ROWNUM < 2';
    $query = $this->db->query($sql);
    $res =  $query->result_array();
    // print_r($res);
    if(empty($res)){
        return;
    }

    $res[0]['NOTI_VERSION_NUM_LOG'] = empty($res[0]['NOTI_VERSION_NUM_LOG'])?'00':($res[0]['NOTI_VERSION_NUM_LOG']<10?('0'.$res[0]['NOTI_VERSION_NUM_LOG']):$res[0]['NOTI_VERSION_NUM_LOG']);
    //danh dau da push
    $this->db->where('ID',$res[0]['ID']);
    $this->db->update('CONTENT_PUSH',array('STATUS_PUSH'=>1));
    
    $include_player_ids = $this->getUserPush($res[0]);
    // $include_player_ids = array('2bc78208-8a99-42f3-9e94-d9b34ad5290e');
    // print_r($include_player_ids);
    if(empty($include_player_ids)){
      return false;
    }
    $headings = $res[0]['HEADER'];
    $url = $res[0]['URL'];
    $content = preg_replace("/(__.__)/", ".", $res[0]['CONTENT_PUSH']);
    
    
    $response = $this->sendMessage($include_player_ids,$content,$url,$headings);
    $return["allresponses"] = $response;
    $return = json_encode($return);

    $data = json_decode($response, true);
    // print_r($data);
    $id = $data['id'];
    // print_r($id);
    // print("\n\nJSON received:\n");
    // print($return);
    // print("\n");
  }
  public function sendMessage($include_player_ids,$content,$url,$headings='Mua Sắm Công'){
		$content = array(
      "en" => $content
		);
		
		$fields = array(
			'app_id' => "359d4968-225d-4e33-ba21-1d63c0fb8b34",
      // 'included_segments' => array('9484b018-8c55-4cc5-810b-537607f4c6da'),
      'include_player_ids'=>$include_player_ids, //array('0fab97ac-8455-4081-babd-770999834d22'),//array('02fba03b-4000-4fd3-b0e1-f4eff361e17d'),
			'data' => array(
			  "url"=>$url
      ),
      'contents' => $content,
      'headings'=>array("en" => $headings),
      //'big_picture'=>'http://dauthau2.zdoday.com/zeanniTheme/img/0.525014001557203885.png',
      //'ios_attachments'=>'http://dauthau2.zdoday.com/zeanniTheme/img/0.525014001557203885.png'
		);
		
		$fields = json_encode($fields);
    // print("\nJSON sent:\n");
    // print($fields);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8','Authorization: Basic YmJlNjZhNTUtNDRlMi00MjgzLTlkOWQtODFlZTlhZjQ1ODhk'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response;
  }
  
  public function getNotify(){
    $arr = getallheaders();
    if(empty($arr['x-csrftoken'])){
        return array();
    }
    $token = $this->db->escape_str(trim($arr['x-csrftoken']));
    $sql = "select USER_ID
    from TBL_USERS 
    where TOKEN = '".$token."'";
    $query = $this->db->query($sql);
    $row =  $query->row_array();
    if(empty($row))
        return array();

    $sql="update AW_USERS_CONTENT_PUSH
    set STATUS_VIEW = 2
    where USER_ID='".$row['USER_ID']."' and STATUS_VIEW=0";
    $this->db->query($sql);

    $sql = "select * from (
        select a.NAME_TABLE,a.TABLE_ID,a.BID_PACKAGE_CODE,a.TYPE_PUSH,
            to_char(a.DATE_CREATED, 'dd-mm-yyyy hh24:mi') as DATE_CREATED,
            a1.PACKAGE_NAME as \"NAME\", a.ID,NVL(a.NOTI_VERSION_NUM_LOG,0) as NOTI_VERSION_NUM_LOG,
            a.URL,a.HEADER,a1.STATUS_VIEW,a1.ID as U_CP_ID,a.CONTENT_PUSH
        from CONTENT_PUSH a
        inner join AW_USERS_CONTENT_PUSH a1 on a1.CONTENT_PUSH_ID = a.ID
        where a1.USER_ID='".$row['USER_ID']."' and a.HEADER is not null
        order by a.ID desc
    ) a
    where ROWNUM <= 300";
    $query = $this->db->query($sql);
    $res =  $query->result_array();
    $data = array();
    foreach($res as $v){
      $views=array(
        array(
            'title'=>$v['HEADER'],
            'content'=>''
        ),
      );
      $cp = explode("__.__", $v['CONTENT_PUSH']);
      foreach($cp as $vl){
        $arr = explode(':', $vl, 2);
        $views[] = array(
          'title'=>trim($arr[0]).':',
          'content'=>empty($arr[1])?'':trim($arr[1])
        );
      }

      $views[] = array(
        'content'=>$v['DATE_CREATED'],
        'type'=>'date'
      );

      $data[]= array(
        'STATUS_VIEW'=>$v['STATUS_VIEW'],
        'URL'=>$v['URL'],
        'TABLE_ID'=>$v['TABLE_ID'],
        'U_CP_ID'=>$v['U_CP_ID'],
        'VIEWS'=>$views
      );
      
    }
    return $data;
  }
}