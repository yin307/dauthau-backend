<!DOCTYPE html><html><head> <?php  global $_systemCookie, $_systemSession, $_getSegment; include_once (PATH_STSTEM."/application/libraries/Lib_ZN.php"); function numberFormat($number, $decimals = null, $dec_point = ".", $thousands_sep = ","){  return Lib_ZN::numberFormat($number, $decimals, $dec_point, $thousands_sep);} function find($vl,$arr){  return Lib_ZN::find($vl,$arr);} function sum($arr=array(),$key=""){  return Lib_ZN::sum($arr,$key);} function formatDate($date,$format){  return Lib_ZN::formatDate($date,$format);} $self = !empty($_SERVER["PHP_SELF"])?$_SERVER["PHP_SELF"]:$_SERVER["SCRIPT_NAME"];    $self = explode("/",$self);    $_getSegment = array();    for ($x=1;$x<=count($self);$x++){        $_getSegment[$x] = $this->db->escape_str($this->uri->segment($x));    }$_systemCookie=array();if(!empty($_COOKIE)){    $_systemCookie = $_COOKIE;} $_systemSession = $this->session->userdata();echo '<script>var $_systemCookie = '.json_encode($_systemCookie).';var $_zn = [];$_zn["clZN_dataClient"]={};</script>';foreach ($_systemCookie as $k=>$v){$ck = json_decode($v,true);if(is_array($ck)){    $_systemCookie[$k]=$ck;}}?><meta http-equiv="content-type" content="text/html; charset=utf-8" /><link href="/zeanniTheme/favicon.png" rel="shortcut icon"><meta name="viewport" content="width=device-width, initial-scale=1.0"/><script type="text/javascript" src="/zeanniTheme/js/jquery-1.9.1.js"></script><script src="/zeanniTheme/js/jquery-ui.min.js"></script><link rel="stylesheet" href="/zeanniTheme/css/jquery-ui.css"><link href="/zeanniTheme/css/font.css?time=1561421941143" type="text/css" rel="stylesheet"/><script type="text/javascript" src="/zeanniTheme/plugins/jssor.slider/jssor.slider.min.js?time=1561421941143"></script><script type="text/javascript" src="/zeanniTheme/js/zeanniLib.js?time=1561421941143"></script><link href="/zeanniTheme/css/Zn_uu_dai___chi_tiet.css?time=1561421941143" type="text/css" rel="stylesheet"/><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous"/></head><body id="content"><div class="c-uu-dai---chi-tiet-2" class_name="uu-dai---chi-tiet-2"><div class="c-uu-dai---chi-tiet-3" class_name="uu-dai---chi-tiet-3" includepage="header-4"><div style="clear: both;" class_name="clear_uu-dai---chi-tiet-3"></div><div style="clear: both;" class_name="clear_uu-dai---chi-tiet-3"></div><div style="clear: both;" class_name="clear_uu-dai---chi-tiet-3"></div><div style="clear: both;" class_name="clear_uu-dai---chi-tiet-3"></div><div class="c-header-4-2" class_name="header-4-2" header_app="1"><div class="c-header-4-3" class_name="header-4-3"><div class="c-header-4-4" class_name="header-4-4"><div class="c-header-4-6" class_name="header-4-6"><div class="c-header-4-7" class_name="header-4-7" button_back_app="1"><img src="/zeanniTheme/img/0.826618001557220692.svg" class="c-header-4-8" class_name="header-4-8"><div style="clear: both;" class_name="clear_header-4-7"></div></div><div style="clear: both;" class_name="clear_header-4-6"></div></div><div class="c-header-4-9" class_name="header-4-9"><div class="input-text    c-header-4-10" class_name="header-4-10" zn-typedata-group="" zn-from_index="0" zn-to_index="" zn-type_add="1" _varcheckc="[--NHAYK--$_GET[--NHAYD--title--NHAYD--]--NHAYK--,--NHAYK--$_GET[--NHAYD--title--NHAYD--]--NHAYK--]">Title</div><div style="clear: both;" class_name="clear_header-4-9"></div></div><div class="c-header-4-11" class_name="header-4-11" indextab="0"><div style="clear: both;" class_name="clear_header-4-11"></div></div><div style="clear: both;" class_name="clear_header-4-4"></div></div><div style="clear: both;" class_name="clear_header-4-3"></div></div><div style="clear: both;" class_name="clear_header-4-2"></div></div><div style="clear: both;" class_name="clear_content-layer"></div><div style="clear: both;" class_name="clear_uu-dai---chi-tiet-3"></div></div><div class="c-uu-dai---chi-tiet-4" class_name="uu-dai---chi-tiet-4"><div class="c-uu-dai---chi-tiet-5" class_name="uu-dai---chi-tiet-5"><div class="c-uu-dai---chi-tiet-6" class_name="uu-dai---chi-tiet-6"><div class="c-uu-dai---chi-tiet-7" class_name="uu-dai---chi-tiet-7"><img src="/zeanniTheme/img/0.172436001560253892.jpg" class="c-uu-dai---chi-tiet-8" class_name="uu-dai---chi-tiet-8"><div style="clear: both;" class_name="clear_uu-dai---chi-tiet-7"></div></div><div class="c-uu-dai---chi-tiet-9" class_name="uu-dai---chi-tiet-9"><div class="input-text    c-uu-dai---chi-tiet-11" class_name="uu-dai---chi-tiet-11">Ưu đãi 50% khi đăng ký tiện ích giá thầu dự án.</div><div style="clear: both;" class_name="clear_uu-dai---chi-tiet-9"></div></div><div class="c-uu-dai---chi-tiet-21" class_name="uu-dai---chi-tiet-21"><div class="c-uu-dai---chi-tiet-23 input-text" class_name="uu-dai---chi-tiet-23">Từ 25/6/2019 đến 25/7/2019</div><div style="clear: both;" class_name="clear_uu-dai---chi-tiet-21"></div></div><div style="clear: both;" class_name="clear_uu-dai---chi-tiet-6"></div></div><div class="c-uu-dai---chi-tiet-24 input-text" class_name="uu-dai---chi-tiet-24">- Xem thống kê giá thầu phát hành và giá thầu chúng thầu của các dự án bên mời thầu từng phát hành.&nbsp;<div>- Xem thống kê giá thầu bỏ thầu của các đối thủ cạnh tranh trong các dự án đã từng tham gia đấu thầu...</div><div>- Doanh nghiệp sẽ không cần hằng ngày phải vào trực tiếp các trang thông tin đấu thầu để tìm kiếm thông tin.</div><div>- Hệ thống sẽ tự động sàng lọc các gói thầu phù hợp với hồ sơ năng lực, lĩnh vực kinh doanh của công ty và kích hoạt chế độ gửi qua email hằng ngày ngay khi có thông tin về gói thầu phù hợp.<br></div></div><div style="clear: both;" class_name="clear_uu-dai---chi-tiet-5"></div></div><div class="c-uu-dai---chi-tiet-25" class_name="uu-dai---chi-tiet-25"><div class="c-uu-dai---chi-tiet-26" class_name="uu-dai---chi-tiet-26"><div class="input-text     c-uu-dai---chi-tiet-27" class_name="uu-dai---chi-tiet-27">Mua ngay</div><div style="clear: both;" class_name="clear_uu-dai---chi-tiet-26"></div></div><div style="clear: both;" class_name="clear_uu-dai---chi-tiet-25"></div></div><div style="clear: both;" class_name="clear_uu-dai---chi-tiet-4"></div></div><div class="c-uu-dai---chi-tiet-18" class_name="uu-dai---chi-tiet-18" includepage="footer-1"><div style="clear: both;" class_name="clear_uu-dai---chi-tiet-18"></div><div style="clear: both;" class_name="clear_uu-dai---chi-tiet-18"></div><div class="c-footer-1-150" class_name="footer-1-150" footer_app="1"><a href="/home" class="c-footer-1-163" class_name="footer-1-163"><div class="c-footer-1-151" class_name="footer-1-151"><div class="c-footer-1-152" class_name="footer-1-152"><img src="/zeanniTheme/img/0.981402001559817901.png" class="c-footer-1-173" class_name="footer-1-173"><div style="clear: both;" class_name="clear_footer-1-152"></div></div><div class="input-text  c-footer-1-154" class_name="footer-1-154">Trang chủ</div><div style="clear: both;" class_name="clear_footer-1-151"></div></div></a><a href="/uu-dai" class="c-footer-1-175" class_name="footer-1-175"><div class="c-footer-1-155" class_name="footer-1-155"><div class="c-footer-1-156" class_name="footer-1-156"><img src="/zeanniTheme/img/0.910463001559818140.png" class="c-footer-1-174" class_name="footer-1-174"><div style="clear: both;" class_name="clear_footer-1-156"></div></div><div class="input-text   c-footer-1-158" class_name="footer-1-158">Ưu đãi</div><div style="clear: both;" class_name="clear_footer-1-155"></div></div></a><a href="/tro-giup" class="c-footer-1-172" class_name="footer-1-172"><div class="c-footer-1-164" class_name="footer-1-164"><div class="c-footer-1-165" class_name="footer-1-165"><img src="/zeanniTheme/img/0.626373001557219910.svg" class="c-footer-1-166" class_name="footer-1-166"><div style="clear: both;" class_name="clear_footer-1-165"></div></div><div class="input-text    c-footer-1-167" class_name="footer-1-167">Hỗ trợ</div><div style="clear: both;" class_name="clear_footer-1-164"></div></div></a><a href="/thong-tin-ca-nhan" class="c-footer-1-171" class_name="footer-1-171"><div class="c-footer-1-159" class_name="footer-1-159"><div class="c-footer-1-160" class_name="footer-1-160"><img src="/zeanniTheme/img/0.911857001558409115.svg" class="c-footer-1-169" class_name="footer-1-169"><div style="clear: both;" class_name="clear_footer-1-160"></div></div><div class="input-text    c-footer-1-162" class_name="footer-1-162">Tài khoản</div><div style="clear: both;" class_name="clear_footer-1-159"></div></div></a><div style="clear: both;" class_name="clear_footer-1-150"></div></div><div style="clear: both;" class_name="clear_content-layer"></div><div style="clear: both;" class_name="clear_uu-dai---chi-tiet-18"></div></div><div style="clear: both;" class_name="clear_uu-dai---chi-tiet-2"></div></div><div style="clear: both;" class_name="clear_content-layer"></div><script> zLh94 = {}; zLd50 = {};/*thiet lap gia tri ui sau khi cap nhat bien client*/$.each($_systemCookie,function (i, v) {try {$_systemCookie[i]=JSON.parse(v);}catch (e) {}});zLk328();/*end: thiet lap gia tri ui sau khi cap nhat bien client*/zLg75();zLn266 = function(selectorParent){selectorParent = selectorParent || "#content";};zLm174();zLn266();zLd84();zLa111();zLa192();zLf79();$('[social_action=shareF]').attr('onclick','zLb132();');            $('[social_action=shareG]').off('click').on('click',function(){zLn293();});            $('[social_action=shareT]').off('click').on('click',function(){zLb276();});</script></body></html>