<!DOCTYPE html><html><head> <?php  global $_systemCookie, $_systemSession, $_getSegment; include_once (PATH_STSTEM."/application/libraries/Lib_ZN.php"); function numberFormat($number, $decimals = null, $dec_point = ".", $thousands_sep = ","){  return Lib_ZN::numberFormat($number, $decimals, $dec_point, $thousands_sep);} function find($vl,$arr){  return Lib_ZN::find($vl,$arr);} function sum($arr=array(),$key=""){  return Lib_ZN::sum($arr,$key);} function formatDate($date,$format){  return Lib_ZN::formatDate($date,$format);} $self = !empty($_SERVER["PHP_SELF"])?$_SERVER["PHP_SELF"]:$_SERVER["SCRIPT_NAME"];    $self = explode("/",$self);    $_getSegment = array();    for ($x=1;$x<=count($self);$x++){        $_getSegment[$x] = $this->db->escape_str($this->uri->segment($x));    }$_systemCookie=array();if(!empty($_COOKIE)){    $_systemCookie = $_COOKIE;} $_systemSession = $this->session->userdata();echo '<script>var $_systemCookie = '.json_encode($_systemCookie).';var $_zn = [];$_zn["clZN_dataClient"]={};</script>';foreach ($_systemCookie as $k=>$v){$ck = json_decode($v,true);if(is_array($ck)){    $_systemCookie[$k]=$ck;}}?><meta http-equiv="content-type" content="text/html; charset=utf-8" /><link href="/zeanniTheme/favicon.png" rel="shortcut icon"><meta name="viewport" content="width=device-width, initial-scale=1.0"/><script type="text/javascript" src="/zeanniTheme/js/jquery-1.9.1.js"></script><script src="/zeanniTheme/js/jquery-ui.min.js"></script><link rel="stylesheet" href="/zeanniTheme/css/jquery-ui.css"><link href="/zeanniTheme/css/font.css?time=1561421931353" type="text/css" rel="stylesheet"/><script type="text/javascript" src="/zeanniTheme/plugins/jssor.slider/jssor.slider.min.js?time=1561421931353"></script><script type="text/javascript" src="/zeanniTheme/js/zeanniLib.js?time=1561421931353"></script><link href="/zeanniTheme/css/Zn_thong_tin_chon_loc___chua_dk_goi.css?time=1561421931353" type="text/css" rel="stylesheet"/><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous"/></head><body id="content"><div class="c-thong-tin-chon-loc---chua-dk-goi-2" class_name="thong-tin-chon-loc---chua-dk-goi-2"><div class="c-thong-tin-chon-loc---chua-dk-goi-3" class_name="thong-tin-chon-loc---chua-dk-goi-3" includepage="header-2"><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-3"></div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-3"></div><div class="c-thong-tin-chon-loc-77" class_name="thong-tin-chon-loc-77"></div><div class="c-header-2-97" class_name="header-2-97" header_app="1"><div class="c-header-2-98" class_name="header-2-98"><div class="c-header-2-99" class_name="header-2-99"><div class="c-header-2-100" class_name="header-2-100" button_back_app="1"><div class="c-header-2-101" class_name="header-2-101"><img src="/zeanniTheme/img/0.104646001560171964.png" class="c-header-2-115" class_name="header-2-115"><div style="clear: both;" class_name="clear_header-2-101"></div></div><div style="clear: both;" class_name="clear_header-2-100"></div></div><div class="c-header-2-103" class_name="header-2-103"> <?php  $FunCode_header2104 = function ($v){GLOBAL $_systemCookie,$_systemSession,$_getSegment;if(!isset($_GET['title'])){$_GET['title']=null;}if(!isset($_GET['title'])){$_GET['title']=null;} return  (  empty  ( $_GET['title'] )  ? 'Title' : $_GET['title'] )  ; ; };$html = '';$j=1; $v = array();$html .='<div class="input-text  c-header-2-104 zn-scriptCreate" class_name="header-2-104" o_index="0">'; $getData = $FunCode_header2104($v); if(isset($getData)){ $html .= $getData; }else{ $html .='Title'; } $html .='</div>';echo $html; ?> <div class="c-header-2-109" class_name="header-2-109" overlay="1"><div class="c-header-2-111" class_name="header-2-111"><div class="c-header-2-112" class_name="header-2-112"><svg class="svg-inline--fa fa-search fa-w-16 fa-fw" aria-hidden="true" data-prefix="fas" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" set-adddatafromdb-content="" zn-valfuncode_string="" zn-valfuncodeinputvalue_string="" zn-valfuncodelabel_string=""><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z" set-adddatafromdb-content="" zn-valfuncode_string="" zn-valfuncodeinputvalue_string="" zn-valfuncodelabel_string=""></path></svg><!-- <i class="fas fa-search fa-fw"></i> --></div><input name="name_header-2_114" class="inputText    c-header-2-114" class_name="header-2-114" type="text" value="" placeholder="Bạn muốn tìm gì ?" varname="" type_varname="1"><div style="clear: both;" class_name="clear_header-2-111"></div></div><div style="clear: both;" class_name="clear_header-2-109"></div></div><div style="clear: both;" class_name="clear_header-2-103"></div></div><div class="c-header-2-105" class_name="header-2-105" indextab="0"><div class="c-header-2-106" class_name="header-2-106"><svg class="svg-inline--fa fa-search fa-w-16 fa-fw" aria-hidden="true" data-prefix="fas" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" set-adddatafromdb-content="" zn-valfuncode_string="" zn-valfuncodeinputvalue_string="" zn-valfuncodelabel_string=""><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z" set-adddatafromdb-content="" zn-valfuncode_string="" zn-valfuncodeinputvalue_string="" zn-valfuncodelabel_string=""></path></svg><!-- <i class="fas fa-search fa-fw"></i> --></div><div style="clear: both;" class_name="clear_header-2-105"></div></div><div style="clear: both;" class_name="clear_header-2-99"></div></div><div style="clear: both;" class_name="clear_header-2-98"></div></div><div style="clear: both;" class_name="clear_header-2-97"></div></div><div style="clear: both;" class_name="clear_content-layer"></div><script id="jsEventAction" type="application/javascript">if(typeof FunCongfig=="undefined"){var FunCongfig = {};} FunCongfig["header-2"] = [{"element1":".c-header-2-105","element2":[".c-header-2-109"],"eventType":"click","animationType":"showHide","callBack":["function(eventType,element1,element2,ind){ind = ind || 0; var elm2 = $($(element2)[ind]); elm2.css({'min-height':'initial','height':elm2.css('height')}); elm2.slideToggle(200);}"],"callBack2":["function(eventType,element1,element2,ind){ind = ind || 0; var elm2 = $($(element2)[ind]); elm2.css({'min-height':'initial','height':elm2.css('height')}); elm2.slideToggle(200);}"]}];</script><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-3"></div></div><div class="c-thong-tin-chon-loc---chua-dk-goi-4" class_name="thong-tin-chon-loc---chua-dk-goi-4"><div class="c-thong-tin-chon-loc---chua-dk-goi-5" class_name="thong-tin-chon-loc---chua-dk-goi-5"><div class="input-text  c-thong-tin-chon-loc---chua-dk-goi-6" class_name="thong-tin-chon-loc---chua-dk-goi-6">Tài khoản chưa đăng ký gói thông tin chọn lọc</div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-5"></div></div><div class="c-thong-tin-chon-loc---chua-dk-goi-7" class_name="thong-tin-chon-loc---chua-dk-goi-7"><div class="c-thong-tin-chon-loc---chua-dk-goi-8" class_name="thong-tin-chon-loc---chua-dk-goi-8"><img src="/zeanniTheme/img/0.725150001557720403.svg" class="c-thong-tin-chon-loc---chua-dk-goi-9" class_name="thong-tin-chon-loc---chua-dk-goi-9"><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-8"></div></div><div class="c-thong-tin-chon-loc---chua-dk-goi-10" class_name="thong-tin-chon-loc---chua-dk-goi-10"><div class="c-thong-tin-chon-loc---chua-dk-goi-11" class_name="thong-tin-chon-loc---chua-dk-goi-11"><div class="c-thong-tin-chon-loc---chua-dk-goi-12" class_name="thong-tin-chon-loc---chua-dk-goi-12"><div class="input-text c-thong-tin-chon-loc---chua-dk-goi-13" class_name="thong-tin-chon-loc---chua-dk-goi-13">Đăng ký ngay</div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-12"></div></div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-11"></div></div><div class="c-thong-tin-chon-loc---chua-dk-goi-14" class_name="thong-tin-chon-loc---chua-dk-goi-14"><div class="c-thong-tin-chon-loc---chua-dk-goi-15" class_name="thong-tin-chon-loc---chua-dk-goi-15"><div class="input-text  c-thong-tin-chon-loc---chua-dk-goi-16" class_name="thong-tin-chon-loc---chua-dk-goi-16">Đăng ký dùng thử</div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-15"></div></div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-14"></div></div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-10"></div></div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-7"></div></div><div class="c-thong-tin-chon-loc---chua-dk-goi-17" class_name="thong-tin-chon-loc---chua-dk-goi-17"><div class="input-text c-thong-tin-chon-loc---chua-dk-goi-18" class_name="thong-tin-chon-loc---chua-dk-goi-18">Dịch vụ cung cấp thông tin chọn lọc</div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-20"></div></div><div class="c-thong-tin-chon-loc---chua-dk-goi-19" class_name="thong-tin-chon-loc---chua-dk-goi-19"><div class="input-text   c-thong-tin-chon-loc---chua-dk-goi-20" class_name="thong-tin-chon-loc---chua-dk-goi-20">"Săn" thông báo mời thầu</div><div class="c-thong-tin-chon-loc---chua-dk-goi-21" class_name="thong-tin-chon-loc---chua-dk-goi-21"><div class="input-text     c-thong-tin-chon-loc---chua-dk-goi-22" class_name="thong-tin-chon-loc---chua-dk-goi-22">Tìm kiếm thông minh (tìm theo Số TBMT, tên gói thầu, bên mời thầu, Tên dự án, Nội dung chính của gói thầu) trong một ô tìm kiếm duy nhất.</div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-21"></div></div><div class="c-thong-tin-chon-loc---chua-dk-goi-23" class_name="thong-tin-chon-loc---chua-dk-goi-23"><div class="input-text      c-thong-tin-chon-loc---chua-dk-goi-24" class_name="thong-tin-chon-loc---chua-dk-goi-24">Tạo bộ lọc tìm kiếm thông tin thầu theo yêu cầu và năng lực nhà thầu</div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-23"></div></div><div class="c-thong-tin-chon-loc---chua-dk-goi-25" class_name="thong-tin-chon-loc---chua-dk-goi-25"><div class="input-text      c-thong-tin-chon-loc---chua-dk-goi-26" class_name="thong-tin-chon-loc---chua-dk-goi-26">Nhận email thông báo về gói thầu mới được đăng tải (TBMT) phù hợp điều kiện tìm kiếm (đã lưu trong bộ lọc)</div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-25"></div></div><div class="c-thong-tin-chon-loc---chua-dk-goi-27" class_name="thong-tin-chon-loc---chua-dk-goi-27"><div class="input-text      c-thong-tin-chon-loc---chua-dk-goi-28" class_name="thong-tin-chon-loc---chua-dk-goi-28">"Soi" giá gói thầu của bất kỳ gói thầu nào, kể cả các gói thầu bị ẩn giá trong thông báo mời thầu (kể cả báo đấu thầu)</div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-27"></div></div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-19"></div></div><div class="c-thong-tin-chon-loc---chua-dk-goi-29" class_name="thong-tin-chon-loc---chua-dk-goi-29"><div class="input-text    c-thong-tin-chon-loc---chua-dk-goi-30" class_name="thong-tin-chon-loc---chua-dk-goi-30">"Săn" kế hoạch lựa chọn nhà thầu</div><div class="c-thong-tin-chon-loc---chua-dk-goi-31" class_name="thong-tin-chon-loc---chua-dk-goi-31"><div class="input-text      c-thong-tin-chon-loc---chua-dk-goi-32" class_name="thong-tin-chon-loc---chua-dk-goi-32">Tìm kiếm thông minh (tìm theo Số KHLCNT, tên KHLCNT, tên dự án, bên mời thầu, chủ đầu tư) trong một ô tìm kiếm duy nhất.</div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-31"></div></div><div class="c-thong-tin-chon-loc---chua-dk-goi-33" class_name="thong-tin-chon-loc---chua-dk-goi-33"><div class="input-text       c-thong-tin-chon-loc---chua-dk-goi-34" class_name="thong-tin-chon-loc---chua-dk-goi-34">Tạo bộ lọc tìm kiếm thông tin thầu theo yêu cầu và năng lực nhà thầu</div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-33"></div></div><div class="c-thong-tin-chon-loc---chua-dk-goi-35" class_name="thong-tin-chon-loc---chua-dk-goi-35"><div class="input-text       c-thong-tin-chon-loc---chua-dk-goi-36" class_name="thong-tin-chon-loc---chua-dk-goi-36">Nhận email thông báo về gói thầu mới được đăng tải (TBMT) phù hợp điều kiện tìm kiếm (đã lưu trong bộ lọc)</div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-35"></div></div><div class="c-thong-tin-chon-loc---chua-dk-goi-37" class_name="thong-tin-chon-loc---chua-dk-goi-37"><div class="input-text       c-thong-tin-chon-loc---chua-dk-goi-38" class_name="thong-tin-chon-loc---chua-dk-goi-38">"Soi" giá gói thầu của bất kỳ gói thầu nào, kể cả các gói thầu bị ẩn giá trong thông báo mời thầu (kể cả báo đấu thầu)</div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-37"></div></div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-29"></div></div><div class="c-thong-tin-chon-loc---chua-dk-goi-39" class_name="thong-tin-chon-loc---chua-dk-goi-39"><div class="input-text  c-thong-tin-chon-loc---chua-dk-goi-40" class_name="thong-tin-chon-loc---chua-dk-goi-40">Hướng dẫn đăng ký thông tin chọn lọc</div><div class="c-thong-tin-chon-loc---chua-dk-goi-41" class_name="thong-tin-chon-loc---chua-dk-goi-41" overlay="1"><svg class="svg-inline--fa fa-arrow-right fa-w-14 fa-fw" aria-hidden="true" data-prefix="fas" data-icon="arrow-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="" set-adddatafromdb-content="" zn-valfuncode_string="" zn-valfuncodeinputvalue_string="" zn-valfuncodelabel_string=""><path fill="currentColor" d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z" set-adddatafromdb-content="" zn-valfuncode_string="" zn-valfuncodeinputvalue_string="" zn-valfuncodelabel_string=""></path></svg><!-- <i class="fas fa-arrow-right fa-fw"></i> --></div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-39"></div></div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-4"></div></div><div class="c-thong-tin-chon-loc---chua-dk-goi-42" class_name="thong-tin-chon-loc---chua-dk-goi-42" includepage="footer-1"><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-42"></div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-42"></div><div class="c-thong-tin-chon-loc-77" class_name="thong-tin-chon-loc-77"></div><div class="c-footer-1-150" class_name="footer-1-150" footer_app="1"><a href="/home" class="c-footer-1-163" class_name="footer-1-163"><div class="c-footer-1-151" class_name="footer-1-151"><div class="c-footer-1-152" class_name="footer-1-152"><img src="/zeanniTheme/img/0.981402001559817901.png" class="c-footer-1-173" class_name="footer-1-173"><div style="clear: both;" class_name="clear_footer-1-152"></div></div><div class="input-text  c-footer-1-154" class_name="footer-1-154">Trang chủ</div><div style="clear: both;" class_name="clear_footer-1-151"></div></div></a><a href="/uu-dai" class="c-footer-1-175" class_name="footer-1-175"><div class="c-footer-1-155" class_name="footer-1-155"><div class="c-footer-1-156" class_name="footer-1-156"><img src="/zeanniTheme/img/0.910463001559818140.png" class="c-footer-1-174" class_name="footer-1-174"><div style="clear: both;" class_name="clear_footer-1-156"></div></div><div class="input-text   c-footer-1-158" class_name="footer-1-158">Ưu đãi</div><div style="clear: both;" class_name="clear_footer-1-155"></div></div></a><a href="/tro-giup" class="c-footer-1-172" class_name="footer-1-172"><div class="c-footer-1-164" class_name="footer-1-164"><div class="c-footer-1-165" class_name="footer-1-165"><img src="/zeanniTheme/img/0.626373001557219910.svg" class="c-footer-1-166" class_name="footer-1-166"><div style="clear: both;" class_name="clear_footer-1-165"></div></div><div class="input-text    c-footer-1-167" class_name="footer-1-167">Hỗ trợ</div><div style="clear: both;" class_name="clear_footer-1-164"></div></div></a><a href="/thong-tin-ca-nhan" class="c-footer-1-171" class_name="footer-1-171"><div class="c-footer-1-159" class_name="footer-1-159"><div class="c-footer-1-160" class_name="footer-1-160"><img src="/zeanniTheme/img/0.911857001558409115.svg" class="c-footer-1-169" class_name="footer-1-169"><div style="clear: both;" class_name="clear_footer-1-160"></div></div><div class="input-text    c-footer-1-162" class_name="footer-1-162">Tài khoản</div><div style="clear: both;" class_name="clear_footer-1-159"></div></div></a><div style="clear: both;" class_name="clear_footer-1-150"></div></div><div style="clear: both;" class_name="clear_content-layer"></div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-42"></div></div><div style="clear: both;" class_name="clear_thong-tin-chon-loc---chua-dk-goi-2"></div></div><div style="clear: both;" class_name="clear_content-layer"></div><script> zLh94 = {}; zLd50 = {};/*thiet lap gia tri ui sau khi cap nhat bien client*/$.each($_systemCookie,function (i, v) {try {$_systemCookie[i]=JSON.parse(v);}catch (e) {}});zLk328();/*end: thiet lap gia tri ui sau khi cap nhat bien client*/zLg75();zLn266 = function(selectorParent){selectorParent = selectorParent || "#content";};zLm174();zLn266();zLd84();zLa111();zLa192();zLf79();$('[social_action=shareF]').attr('onclick','zLb132();');            $('[social_action=shareG]').off('click').on('click',function(){zLn293();});            $('[social_action=shareT]').off('click').on('click',function(){zLb276();});</script></body></html>