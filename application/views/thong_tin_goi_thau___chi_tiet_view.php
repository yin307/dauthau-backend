<!DOCTYPE html><html><head> <?php  global $_systemCookie, $_systemSession, $_getSegment; include_once (PATH_STSTEM."/application/libraries/Lib_ZN.php"); function numberFormat($number, $decimals = null, $dec_point = ".", $thousands_sep = ","){  return Lib_ZN::numberFormat($number, $decimals, $dec_point, $thousands_sep);} function find($vl,$arr){  return Lib_ZN::find($vl,$arr);} function sum($arr=array(),$key=""){  return Lib_ZN::sum($arr,$key);} function formatDate($date,$format){  return Lib_ZN::formatDate($date,$format);} $self = !empty($_SERVER["PHP_SELF"])?$_SERVER["PHP_SELF"]:$_SERVER["SCRIPT_NAME"];    $self = explode("/",$self);    $_getSegment = array();    for ($x=1;$x<=count($self);$x++){        $_getSegment[$x] = $this->db->escape_str($this->uri->segment($x));    }$_systemCookie=array();if(!empty($_COOKIE)){    $_systemCookie = $_COOKIE;} $_systemSession = $this->session->userdata();echo '<script>var $_systemCookie = '.json_encode($_systemCookie).';var $_zn = [];$_zn["clZN_dataClient"]={};</script>';foreach ($_systemCookie as $k=>$v){$ck = json_decode($v,true);if(is_array($ck)){    $_systemCookie[$k]=$ck;}}?><meta http-equiv="content-type" content="text/html; charset=utf-8" /><link href="/zeanniTheme/favicon.png" rel="shortcut icon"><meta name="viewport" content="width=device-width, initial-scale=1.0"/><script type="text/javascript" src="/zeanniTheme/js/jquery-1.9.1.js"></script><script src="/zeanniTheme/js/jquery-ui.min.js"></script><link rel="stylesheet" href="/zeanniTheme/css/jquery-ui.css"><link href="/zeanniTheme/css/font.css?time=1561421934258" type="text/css" rel="stylesheet"/><script type="text/javascript" src="/zeanniTheme/plugins/jssor.slider/jssor.slider.min.js?time=1561421934258"></script><script type="text/javascript" src="/zeanniTheme/js/zeanniLib.js?time=1561421934258"></script><link href="/zeanniTheme/css/Zn_thong_tin_goi_thau___chi_tiet.css?time=1561421934258" type="text/css" rel="stylesheet"/><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous"/></head><body id="content"><div class="c-thong-tin-goi-thau---chi-tiet-2" class_name="thong-tin-goi-thau---chi-tiet-2"><div class="c-thong-tin-goi-thau---chi-tiet-3" class_name="thong-tin-goi-thau---chi-tiet-3" includepage="header-3"><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-3"></div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-3"></div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-3"></div><div class="c-header-3-2" class_name="header-3-2" header_app="1"><div class="c-header-3-3" class_name="header-3-3"><div class="c-header-3-4" class_name="header-3-4"><div class="c-header-3-6" class_name="header-3-6" button_back_app="1"><div class="c-header-3-7" class_name="header-3-7"><img src="/zeanniTheme/img/0.826618001557220692.svg" class="c-header-3-8" class_name="header-3-8"><div style="clear: both;" class_name="clear_header-3-7"></div></div><div style="clear: both;" class_name="clear_header-3-6"></div></div><div class="c-header-3-9" class_name="header-3-9"> <?php  $FunCode_header310 = function ($v){GLOBAL $_systemCookie,$_systemSession,$_getSegment;if(!isset($_GET['title'])){$_GET['title']=null;}if(!isset($_GET['title'])){$_GET['title']=null;} return  (  empty  ( $_GET['title'] )  ? 'Title' : $_GET['title'] )  ; ; };$html = '';$j=1; $v = array();$html .='<div class="input-text   c-header-3-10 zn-scriptCreate" class_name="header-3-10" o_index="0">'; $getData = $FunCode_header310($v); if(isset($getData)){ $html .= $getData; }else{ $html .='Title'; } $html .='</div>';echo $html; ?> <div style="clear: both;" class_name="clear_header-3-9"></div></div><div class="c-header-3-16" class_name="header-3-16" indextab="0"><div class="c-header-3-17" class_name="header-3-17" button_share_app="1"><img src="/zeanniTheme/img/0.330281001559818807.png" class="c-header-3-19" class_name="header-3-19"><div style="clear: both;" class_name="clear_header-3-17"></div></div><div style="clear: both;" class_name="clear_header-3-16"></div></div><div style="clear: both;" class_name="clear_header-3-4"></div></div><div style="clear: both;" class_name="clear_header-3-3"></div></div><div style="clear: both;" class_name="clear_header-3-2"></div></div><div style="clear: both;" class_name="clear_content-layer"></div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-3"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-4" class_name="thong-tin-goi-thau---chi-tiet-4"> <?php  $FunCode_thongtingoithauchitiet150 = function ($v){GLOBAL $_systemCookie,$_systemSession,$_getSegment; if  ( $v["a1-zn-PREQUALIFICATION_STATUS"]== 1  )  {  return "Thông báo mời thầu sơ tuyển" ;  }  else  {  return "Thông báo mời thầu" ;  } ; }; $FunCode_thongtingoithauchitiet153 = function ($v){GLOBAL $_systemCookie,$_systemSession,$_getSegment; return  ( $v["a1-zn-BID_PACKAGE_CODE"] . " - " .  (  empty  ( $v["a1-zn-NOTI_VERSION_NUM"] )  ? "00" : $v["a1-zn-NOTI_VERSION_NUM"] )  )  ; ; }; $FunCode_thongtingoithauchitiet156 = function ($v){GLOBAL $_systemCookie,$_systemSession,$_getSegment; return  (  numberFormat  ( $v["a1-zn-ESTIMATE_PRICE"] ,  0  ,  '.'  , "," )  . " VNĐ" )  ; ; }; $FunCode_thongtingoithauchitiet159 = function ($v){GLOBAL $_systemCookie,$_systemSession,$_getSegment; return  (  numberFormat  ( $v["a1-zn-DOC_PRICE"] ,  0  ,  '.'  , "," )  . " VNĐ" )  ; ; }; $FunCode_thongtingoithauchitiet165 = function ($v){GLOBAL $_systemCookie,$_systemSession,$_getSegment; if  (  empty  ( $v["a1-zn-NOTI_VERSION_NUM"] )  )  {  return "Đăng lần đầu" ;  }  else  {  return "Có chỉnh sửa" ;  } ; };$FunPr_thongtingoithauchitiet180 = function ($v){GLOBAL $_systemCookie,$_systemSession,$_getSegment; return  ( "?bid_no=" . $v["a1-zn-BID_PACKAGE_CODE"] . '&rnno=' . $v["a1-zn-NOTI_VERSION_NUM"] . '&bid_type=1&lang=' )  ; ; }; $FunCode_thongtingoithauchitiet183 = function ($v){GLOBAL $_systemCookie,$_systemSession,$_getSegment; return  (  numberFormat  ( $v["a1-zn-GUARANTEED_AMOUNT"] ,  0  ,  '.'  , "," )  . " VNĐ" )  ; ; };$html = ''; if(!empty($BidPackages_Detail[0])){ $j1=1; $v1 = $BidPackages_Detail[0];$html .='<div class="c-thong-tin-goi-thau---chi-tiet-5 zn-scriptCreate" class_name="thong-tin-goi-thau---chi-tiet-5" o_index="1"><div class="c-thong-tin-goi-thau---chi-tiet-6" class_name="thong-tin-goi-thau---chi-tiet-6"><div class="c-thong-tin-goi-thau---chi-tiet-7" class_name="thong-tin-goi-thau---chi-tiet-7"><div class="c-thong-tin-goi-thau---chi-tiet-8" class_name="thong-tin-goi-thau---chi-tiet-8"></div><div class="c-thong-tin-goi-thau---chi-tiet-9" class_name="thong-tin-goi-thau---chi-tiet-9" overlay="1"><div class="c-thong-tin-goi-thau---chi-tiet-10" class_name="thong-tin-goi-thau---chi-tiet-10"><div class="c-thong-tin-goi-thau---chi-tiet-11" class_name="thong-tin-goi-thau---chi-tiet-11"><img src="/zeanniTheme/img/0.401820001560240481.png" class="c-thong-tin-goi-thau---chi-tiet-248" class_name="thong-tin-goi-thau---chi-tiet-248"><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-11"></div></div><div class="input-text c-thong-tin-goi-thau---chi-tiet-13" class_name="thong-tin-goi-thau---chi-tiet-13">Kế hoạch lựa chọn nhà thầu</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-10"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-14" class_name="thong-tin-goi-thau---chi-tiet-14"><div class="c-thong-tin-goi-thau---chi-tiet-15" class_name="thong-tin-goi-thau---chi-tiet-15"><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-43"></div><img src="/zeanniTheme/img/0.414760001560240497.png" class="c-thong-tin-goi-thau---chi-tiet-249" class_name="thong-tin-goi-thau---chi-tiet-249"><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-15"></div></div><div class="input-text  c-thong-tin-goi-thau---chi-tiet-17" class_name="thong-tin-goi-thau---chi-tiet-17">Thông báo mời thầu</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-42"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-18" class_name="thong-tin-goi-thau---chi-tiet-18"><div class="c-thong-tin-goi-thau---chi-tiet-19" class_name="thong-tin-goi-thau---chi-tiet-19"><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-33"></div><img src="/zeanniTheme/img/0.041193001560240511.png" class="c-thong-tin-goi-thau---chi-tiet-250" class_name="thong-tin-goi-thau---chi-tiet-250"><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-19"></div></div><div class="input-text  c-thong-tin-goi-thau---chi-tiet-21" class_name="thong-tin-goi-thau---chi-tiet-21">Kết quả lựa chọn nhà thầu</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-32"></div></div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-9"></div></div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-7"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-22" class_name="thong-tin-goi-thau---chi-tiet-22"><div class="input-text       c-thong-tin-goi-thau---chi-tiet-23" class_name="thong-tin-goi-thau---chi-tiet-23" zn-group="BidPackages_Detail">'.$v1['a1-zn-PACKAGE_NAME'].'</div><div class="c-thong-tin-goi-thau---chi-tiet-256" class_name="thong-tin-goi-thau---chi-tiet-256" overlay="1"><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-38"></div><div class="c-thong-tin-goi-thau---chi-tiet-257" class_name="thong-tin-goi-thau---chi-tiet-257" overlay="1"><div class="input-text      c-thong-tin-goi-thau---chi-tiet-258" class_name="thong-tin-goi-thau---chi-tiet-258">Điện tử</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-38"></div></div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-256"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-26" class_name="thong-tin-goi-thau---chi-tiet-26"><div class="c-thong-tin-goi-thau---chi-tiet-27" class_name="thong-tin-goi-thau---chi-tiet-27"><svg class="svg-inline--fa fa-star fa-w-18 fa-fw" aria-hidden="true" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="" set-adddatafromdb-content="" zn-valfuncode_string="" zn-valfuncodeinputvalue_string="" zn-valfuncodelabel_string=""><path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z" set-adddatafromdb-content="" zn-valfuncode_string="" zn-valfuncodeinputvalue_string="" zn-valfuncodelabel_string=""></path></svg><!-- <i class="fas fa-star fa-fw"></i> --></div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-40"></div></div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-47"></div></div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-6"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-126" class_name="thong-tin-goi-thau---chi-tiet-126"><div class="c-thong-tin-goi-thau---chi-tiet-142" class_name="thong-tin-goi-thau---chi-tiet-142"><div class="c-thong-tin-goi-thau---chi-tiet-230" class_name="thong-tin-goi-thau---chi-tiet-230"><div class="c-thong-tin-goi-thau---chi-tiet-236" class_name="thong-tin-goi-thau---chi-tiet-236"><div class="c-thong-tin-goi-thau---chi-tiet-237" class_name="thong-tin-goi-thau---chi-tiet-237"><div class="c-thong-tin-goi-thau---chi-tiet-238" class_name="thong-tin-goi-thau---chi-tiet-238"><div class="c-thong-tin-goi-thau---chi-tiet-239" class_name="thong-tin-goi-thau---chi-tiet-239" overlay="1"><img src="/zeanniTheme/img/0.419575001559992403.png" class="c-thong-tin-goi-thau---chi-tiet-241" class_name="thong-tin-goi-thau---chi-tiet-241"><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-239"></div></div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-238"></div></div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-237"></div></div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-236"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-242" class_name="thong-tin-goi-thau---chi-tiet-242"><div class="c-thong-tin-goi-thau---chi-tiet-243" class_name="thong-tin-goi-thau---chi-tiet-243"><div class="input-text  c-thong-tin-goi-thau---chi-tiet-244" class_name="thong-tin-goi-thau---chi-tiet-244">150 Ngày</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-243"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-246" class_name="thong-tin-goi-thau---chi-tiet-246"><div class="input-text   c-thong-tin-goi-thau---chi-tiet-247" class_name="thong-tin-goi-thau---chi-tiet-247">23h : 40p : 30s</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-246"></div></div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-242"></div></div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-230"></div></div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-142"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-148" class_name="thong-tin-goi-thau---chi-tiet-148"><div class="input-text      c-thong-tin-goi-thau---chi-tiet-149" class_name="thong-tin-goi-thau---chi-tiet-149">Loại thông báo:</div><div class="input-text      c-thong-tin-goi-thau---chi-tiet-150" class_name="thong-tin-goi-thau---chi-tiet-150" zn-group="BidPackages_Detail">'; $getData = $FunCode_thongtingoithauchitiet150($v1); if(isset($getData)){ $html .= $getData; }else{ $html .='Thông báo mời thầu'; } $html .='</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-174"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-151" class_name="thong-tin-goi-thau---chi-tiet-151"><div class="input-text       c-thong-tin-goi-thau---chi-tiet-152" class_name="thong-tin-goi-thau---chi-tiet-152">Số thông báo:</div><div class="input-text       c-thong-tin-goi-thau---chi-tiet-153" class_name="thong-tin-goi-thau---chi-tiet-153" zn-group="BidPackages_Detail">'; $getData = $FunCode_thongtingoithauchitiet153($v1); if(isset($getData)){ $html .= $getData; }else{ $html .='20190427895 - 00'; } $html .='</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-171"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-154" class_name="thong-tin-goi-thau---chi-tiet-154"><div class="input-text          c-thong-tin-goi-thau---chi-tiet-155" class_name="thong-tin-goi-thau---chi-tiet-155">Giá gói thầu:</div><div class="input-text          c-thong-tin-goi-thau---chi-tiet-156" class_name="thong-tin-goi-thau---chi-tiet-156" zn-group="BidPackages_Detail">'; $getData = $FunCode_thongtingoithauchitiet156($v1); if(isset($getData)){ $html .= $getData; }else{ $html .='972.000.000 vnđ'; } $html .='</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-154"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-157" class_name="thong-tin-goi-thau---chi-tiet-157"><div class="input-text           c-thong-tin-goi-thau---chi-tiet-158" class_name="thong-tin-goi-thau---chi-tiet-158">Giá bán:</div><div class="input-text           c-thong-tin-goi-thau---chi-tiet-159" class_name="thong-tin-goi-thau---chi-tiet-159" zn-group="BidPackages_Detail">'; $getData = $FunCode_thongtingoithauchitiet159($v1); if(isset($getData)){ $html .= $getData; }else{ $html .='0 vnđ'; } $html .='</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-157"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-160" class_name="thong-tin-goi-thau---chi-tiet-160"><div class="input-text      c-thong-tin-goi-thau---chi-tiet-161" class_name="thong-tin-goi-thau---chi-tiet-161">Lĩnh vực thông báo:</div><div class="input-text      c-thong-tin-goi-thau---chi-tiet-162" class_name="thong-tin-goi-thau---chi-tiet-162" zn-group="BidPackages_Detail">'.$v1['a1-zn-FIELD'].'</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-160"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-163" class_name="thong-tin-goi-thau---chi-tiet-163"><div class="input-text       c-thong-tin-goi-thau---chi-tiet-164" class_name="thong-tin-goi-thau---chi-tiet-164">Hình thức thông báo:</div><div class="input-text       c-thong-tin-goi-thau---chi-tiet-165" class_name="thong-tin-goi-thau---chi-tiet-165" zn-group="BidPackages_Detail">'; $getData = $FunCode_thongtingoithauchitiet165($v1); if(isset($getData)){ $html .= $getData; }else{ $html .='Đăng lần đầu'; } $html .='</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-163"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-166" class_name="thong-tin-goi-thau---chi-tiet-166"><div class="input-text       c-thong-tin-goi-thau---chi-tiet-167" class_name="thong-tin-goi-thau---chi-tiet-167">Nội dung:</div><div class="input-text       c-thong-tin-goi-thau---chi-tiet-168" class_name="thong-tin-goi-thau---chi-tiet-168" zn-group="BidPackages_Detail">'.$v1['a1-zn-FIELD'].'</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-48"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-169" class_name="thong-tin-goi-thau---chi-tiet-169"><div class="input-text       c-thong-tin-goi-thau---chi-tiet-170" class_name="thong-tin-goi-thau---chi-tiet-170">Thời gian bán hồ sơ:</div><div class="input-text       c-thong-tin-goi-thau---chi-tiet-171" class_name="thong-tin-goi-thau---chi-tiet-171" zn-group="BidPackages_Detail">'.$v1['a1-zn-START_DOC_DATE'].'</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-169"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-172" class_name="thong-tin-goi-thau---chi-tiet-172"><div class="input-text       c-thong-tin-goi-thau---chi-tiet-173" class_name="thong-tin-goi-thau---chi-tiet-173">Thời điểm mở thầu:</div><div class="input-text       c-thong-tin-goi-thau---chi-tiet-174" class_name="thong-tin-goi-thau---chi-tiet-174" zn-group="BidPackages_Detail">'.$v1['a1-zn-FINISH_DOC_DATE'].'</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-172"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-175" class_name="thong-tin-goi-thau---chi-tiet-175"><div class="input-text        c-thong-tin-goi-thau---chi-tiet-176" class_name="thong-tin-goi-thau---chi-tiet-176">Số người theo gói thầu:</div><div class="input-text        c-thong-tin-goi-thau---chi-tiet-177" class_name="thong-tin-goi-thau---chi-tiet-177">10</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-175"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-178" class_name="thong-tin-goi-thau---chi-tiet-178"><div class="input-text        c-thong-tin-goi-thau---chi-tiet-179" class_name="thong-tin-goi-thau---chi-tiet-179">Số hồ sơ mời thầu</div><a class="zn-a" href="http://muasamcong.mpi.gov.vn:8081/GG/EP_MPV_GGQ999.jsp/'.$FunPr_thongtingoithauchitiet180($v1).'"><div class="input-text        c-thong-tin-goi-thau---chi-tiet-180" class_name="thong-tin-goi-thau---chi-tiet-180" zn-group="BidPackages_Detail" _funparam=" return  ( --NHAYK--?bid_no=--NHAYK-- .--NHAYD----NHAYD--. $v[--NHAYK--a1-zn-BID_PACKAGE_CODE--NHAYK--] .--NHAYD----NHAYD--. --NHAYD--&rnno=--NHAYD-- .--NHAYD----NHAYD--. $v[--NHAYK--a1-zn-NOTI_VERSION_NUM--NHAYK--] .--NHAYD----NHAYD--. --NHAYD--&bid_type=1&lang=--NHAYD-- )  ; " onlyvarclientpr="0">Xem chi tiết</div></a><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-178"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-181" class_name="thong-tin-goi-thau---chi-tiet-181"><div class="input-text            c-thong-tin-goi-thau---chi-tiet-182" class_name="thong-tin-goi-thau---chi-tiet-182">Số tiền đảm bảo dự thầu:</div><div class="input-text            c-thong-tin-goi-thau---chi-tiet-183" class_name="thong-tin-goi-thau---chi-tiet-183" zn-group="BidPackages_Detail">'; $getData = $FunCode_thongtingoithauchitiet183($v1); if(isset($getData)){ $html .= $getData; }else{ $html .='972.000.000 vnđ'; } $html .='</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-181"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-184" class_name="thong-tin-goi-thau---chi-tiet-184"><div class="input-text        c-thong-tin-goi-thau---chi-tiet-185" class_name="thong-tin-goi-thau---chi-tiet-185">Hình thức đảm bảo:</div><div class="input-text        c-thong-tin-goi-thau---chi-tiet-186" class_name="thong-tin-goi-thau---chi-tiet-186" zn-group="BidPackages_Detail">'.$v1['a1-zn-BID_SECURITY'].'</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-184"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-187" class_name="thong-tin-goi-thau---chi-tiet-187"><div class="input-text        c-thong-tin-goi-thau---chi-tiet-188" class_name="thong-tin-goi-thau---chi-tiet-188">Thuộc dự án:</div><div class="input-text        c-thong-tin-goi-thau---chi-tiet-189" class_name="thong-tin-goi-thau---chi-tiet-189" zn-group="BidPackages_Detail">'.$v1['a2-zn-PROCURING_NAME'].'</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-187"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-190" class_name="thong-tin-goi-thau---chi-tiet-190"><div class="input-text         c-thong-tin-goi-thau---chi-tiet-191" class_name="thong-tin-goi-thau---chi-tiet-191">Nguồn vốn:</div><div class="input-text         c-thong-tin-goi-thau---chi-tiet-192" class_name="thong-tin-goi-thau---chi-tiet-192" zn-group="BidPackages_Detail">'.$v1['a1-zn-FUNDING_SOURCE'].'</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-190"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-193" class_name="thong-tin-goi-thau---chi-tiet-193"><div class="input-text          c-thong-tin-goi-thau---chi-tiet-194" class_name="thong-tin-goi-thau---chi-tiet-194">Bên mời thầu:</div><div class="input-text          c-thong-tin-goi-thau---chi-tiet-195" class_name="thong-tin-goi-thau---chi-tiet-195" zn-group="BidPackages_Detail">'.$v1['a2-zn-PROCURING_NAME'].'</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-193"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-196" class_name="thong-tin-goi-thau---chi-tiet-196"><div class="input-text           c-thong-tin-goi-thau---chi-tiet-197" class_name="thong-tin-goi-thau---chi-tiet-197">Hình thức lựa chọn nhà thầu:</div><div class="input-text           c-thong-tin-goi-thau---chi-tiet-198" class_name="thong-tin-goi-thau---chi-tiet-198" zn-group="BidPackages_Detail">'.$v1['a1-zn-BIDER_SELECTION_TYPE'].'</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-196"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-199" class_name="thong-tin-goi-thau---chi-tiet-199"><div class="input-text            c-thong-tin-goi-thau---chi-tiet-200" class_name="thong-tin-goi-thau---chi-tiet-200">Địa điểm:</div><div class="input-text            c-thong-tin-goi-thau---chi-tiet-201" class_name="thong-tin-goi-thau---chi-tiet-201">Website:&nbsp;</div><div class="input-text              c-thong-tin-goi-thau---chi-tiet-202" class_name="thong-tin-goi-thau---chi-tiet-202">http://muasamcong.mpi.gov.vn</div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-199"></div></div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-126"></div></div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-5"></div></div>';echo $html; } ?> <div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-4"></div></div><div class="c-thong-tin-goi-thau---chi-tiet-80" class_name="thong-tin-goi-thau---chi-tiet-80" includepage="footer-1"><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-80"></div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-80"></div><div class="c-footer-1-150" class_name="footer-1-150" footer_app="1"><a href="/home" class="c-footer-1-163" class_name="footer-1-163"><div class="c-footer-1-151" class_name="footer-1-151"><div class="c-footer-1-152" class_name="footer-1-152"><img src="/zeanniTheme/img/0.981402001559817901.png" class="c-footer-1-173" class_name="footer-1-173"><div style="clear: both;" class_name="clear_footer-1-152"></div></div><div class="input-text  c-footer-1-154" class_name="footer-1-154">Trang chủ</div><div style="clear: both;" class_name="clear_footer-1-151"></div></div></a><a href="/uu-dai" class="c-footer-1-175" class_name="footer-1-175"><div class="c-footer-1-155" class_name="footer-1-155"><div class="c-footer-1-156" class_name="footer-1-156"><img src="/zeanniTheme/img/0.910463001559818140.png" class="c-footer-1-174" class_name="footer-1-174"><div style="clear: both;" class_name="clear_footer-1-156"></div></div><div class="input-text   c-footer-1-158" class_name="footer-1-158">Ưu đãi</div><div style="clear: both;" class_name="clear_footer-1-155"></div></div></a><a href="/tro-giup" class="c-footer-1-172" class_name="footer-1-172"><div class="c-footer-1-164" class_name="footer-1-164"><div class="c-footer-1-165" class_name="footer-1-165"><img src="/zeanniTheme/img/0.626373001557219910.svg" class="c-footer-1-166" class_name="footer-1-166"><div style="clear: both;" class_name="clear_footer-1-165"></div></div><div class="input-text    c-footer-1-167" class_name="footer-1-167">Hỗ trợ</div><div style="clear: both;" class_name="clear_footer-1-164"></div></div></a><a href="/thong-tin-ca-nhan" class="c-footer-1-171" class_name="footer-1-171"><div class="c-footer-1-159" class_name="footer-1-159"><div class="c-footer-1-160" class_name="footer-1-160"><img src="/zeanniTheme/img/0.911857001558409115.svg" class="c-footer-1-169" class_name="footer-1-169"><div style="clear: both;" class_name="clear_footer-1-160"></div></div><div class="input-text    c-footer-1-162" class_name="footer-1-162">Tài khoản</div><div style="clear: both;" class_name="clear_footer-1-159"></div></div></a><div style="clear: both;" class_name="clear_footer-1-150"></div></div><div style="clear: both;" class_name="clear_content-layer"></div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-80"></div></div><div style="clear: both;" class_name="clear_thong-tin-goi-thau---chi-tiet-2"></div></div><div style="clear: both;" class_name="clear_content-layer"></div><script> zLh94 = {}; zLd50 = {};/*thiet lap gia tri ui sau khi cap nhat bien client*/$.each($_systemCookie,function (i, v) {try {$_systemCookie[i]=JSON.parse(v);}catch (e) {}});zLk328();/*end: thiet lap gia tri ui sau khi cap nhat bien client*/zLg75();zLn266 = function(selectorParent){selectorParent = selectorParent || "#content";};zLm174();zLn266();zLd84();zLa111();zLa192();zLf79();$('[social_action=shareF]').attr('onclick','zLb132();');            $('[social_action=shareG]').off('click').on('click',function(){zLn293();});            $('[social_action=shareT]').off('click').on('click',function(){zLb276();});</script></body></html>