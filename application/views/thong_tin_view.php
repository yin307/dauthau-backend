<!DOCTYPE html><html><head> <?php  global $_systemCookie, $_systemSession, $_getSegment; include_once (PATH_STSTEM."/application/libraries/Lib_ZN.php"); function numberFormat($number, $decimals = null, $dec_point = ".", $thousands_sep = ","){  return Lib_ZN::numberFormat($number, $decimals, $dec_point, $thousands_sep);} function find($vl,$arr){  return Lib_ZN::find($vl,$arr);} function sum($arr=array(),$key=""){  return Lib_ZN::sum($arr,$key);} function formatDate($date,$format){  return Lib_ZN::formatDate($date,$format);} $self = !empty($_SERVER["PHP_SELF"])?$_SERVER["PHP_SELF"]:$_SERVER["SCRIPT_NAME"];    $self = explode("/",$self);    $_getSegment = array();    for ($x=1;$x<=count($self);$x++){        $_getSegment[$x] = $this->db->escape_str($this->uri->segment($x));    }$_systemCookie=array();if(!empty($_COOKIE)){    $_systemCookie = $_COOKIE;} $_systemSession = $this->session->userdata();echo '<script>var $_systemCookie = '.json_encode($_systemCookie).';var $_zn = [];$_zn["clZN_dataClient"]={};</script>';foreach ($_systemCookie as $k=>$v){$ck = json_decode($v,true);if(is_array($ck)){    $_systemCookie[$k]=$ck;}}?><meta http-equiv="content-type" content="text/html; charset=utf-8" /><link href="/zeanniTheme/favicon.png" rel="shortcut icon"><meta name="viewport" content="width=device-width, initial-scale=1.0"/><script type="text/javascript" src="/zeanniTheme/js/jquery-1.9.1.js"></script><script src="/zeanniTheme/js/jquery-ui.min.js"></script><link rel="stylesheet" href="/zeanniTheme/css/jquery-ui.css"><link href="/zeanniTheme/css/font.css?time=1561421930155" type="text/css" rel="stylesheet"/><script type="text/javascript" src="/zeanniTheme/plugins/jssor.slider/jssor.slider.min.js?time=1561421930155"></script><script type="text/javascript" src="/zeanniTheme/js/zeanniLib.js?time=1561421930155"></script><link href="/zeanniTheme/css/Zn_thong_tin.css?time=1561421930155" type="text/css" rel="stylesheet"/><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous"/></head><body id="content"><div class="c-thong-tin-2" class_name="thong-tin-2"><div class="c-thong-tin-3" class_name="thong-tin-3" includepage="header-2"><div style="clear: both;" class_name="clear_thong-tin-3"></div><div style="clear: both;" class_name="clear_thong-tin-3"></div><div class="c-header-2-97" class_name="header-2-97" header_app="1"><div class="c-header-2-98" class_name="header-2-98"><div class="c-header-2-99" class_name="header-2-99"><div class="c-header-2-100" class_name="header-2-100" button_back_app="1"><div class="c-header-2-101" class_name="header-2-101"><img src="/zeanniTheme/img/0.104646001560171964.png" class="c-header-2-115" class_name="header-2-115"><div style="clear: both;" class_name="clear_header-2-101"></div></div><div style="clear: both;" class_name="clear_header-2-100"></div></div><div class="c-header-2-103" class_name="header-2-103"> <?php  $FunCode_header2104 = function ($v){GLOBAL $_systemCookie,$_systemSession,$_getSegment;if(!isset($_GET['title'])){$_GET['title']=null;}if(!isset($_GET['title'])){$_GET['title']=null;} return  (  empty  ( $_GET['title'] )  ? 'Title' : $_GET['title'] )  ; ; };$html = '';$j=1; $v = array();$html .='<div class="input-text  c-header-2-104 zn-scriptCreate" class_name="header-2-104" o_index="0">'; $getData = $FunCode_header2104($v); if(isset($getData)){ $html .= $getData; }else{ $html .='Title'; } $html .='</div>';echo $html; ?> <div class="c-header-2-109" class_name="header-2-109" overlay="1"><div class="c-header-2-111" class_name="header-2-111"><div class="c-header-2-112" class_name="header-2-112"><svg class="svg-inline--fa fa-search fa-w-16 fa-fw" aria-hidden="true" data-prefix="fas" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" set-adddatafromdb-content="" zn-valfuncode_string="" zn-valfuncodeinputvalue_string="" zn-valfuncodelabel_string=""><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z" set-adddatafromdb-content="" zn-valfuncode_string="" zn-valfuncodeinputvalue_string="" zn-valfuncodelabel_string=""></path></svg><!-- <i class="fas fa-search fa-fw"></i> --></div><input name="name_header-2_114" class="inputText    c-header-2-114" class_name="header-2-114" type="text" value="" placeholder="Bạn muốn tìm gì ?" varname="" type_varname="1"><div style="clear: both;" class_name="clear_header-2-111"></div></div><div style="clear: both;" class_name="clear_header-2-109"></div></div><div style="clear: both;" class_name="clear_header-2-103"></div></div><div class="c-header-2-105" class_name="header-2-105" indextab="0"><div class="c-header-2-106" class_name="header-2-106"><svg class="svg-inline--fa fa-search fa-w-16 fa-fw" aria-hidden="true" data-prefix="fas" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" set-adddatafromdb-content="" zn-valfuncode_string="" zn-valfuncodeinputvalue_string="" zn-valfuncodelabel_string=""><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z" set-adddatafromdb-content="" zn-valfuncode_string="" zn-valfuncodeinputvalue_string="" zn-valfuncodelabel_string=""></path></svg><!-- <i class="fas fa-search fa-fw"></i> --></div><div style="clear: both;" class_name="clear_header-2-105"></div></div><div style="clear: both;" class_name="clear_header-2-99"></div></div><div style="clear: both;" class_name="clear_header-2-98"></div></div><div style="clear: both;" class_name="clear_header-2-97"></div></div><div style="clear: both;" class_name="clear_content-layer"></div><script id="jsEventAction" type="application/javascript">if(typeof FunCongfig=="undefined"){var FunCongfig = {};} FunCongfig["header-2"] = [{"element1":".c-header-2-105","element2":[".c-header-2-109"],"eventType":"click","animationType":"showHide","callBack":["function(eventType,element1,element2,ind){ind = ind || 0; var elm2 = $($(element2)[ind]); elm2.css({'min-height':'initial','height':elm2.css('height')}); elm2.slideToggle(200);}"],"callBack2":["function(eventType,element1,element2,ind){ind = ind || 0; var elm2 = $($(element2)[ind]); elm2.css({'min-height':'initial','height':elm2.css('height')}); elm2.slideToggle(200);}"]}];</script><div style="clear: both;" class_name="clear_thong-tin-3"></div></div><div class="c-thong-tin-33" class_name="thong-tin-33"><div class="c-thong-tin-46" class_name="thong-tin-46"><div class="c-thong-tin-47" class_name="thong-tin-47"><div class="input-text c-thong-tin-48" class_name="thong-tin-48">Lựa chọn của bạn</div><div style="clear: both;" class_name="clear_thong-tin-47"></div></div><div class="c-thong-tin-49" class_name="thong-tin-49"><div class="c-thong-tin-50" class_name="thong-tin-50"><div class="c-thong-tin-51" class_name="thong-tin-51"><img src="/zeanniTheme/img/0.897286001559136695.svg" class="c-thong-tin-52" class_name="thong-tin-52"><div style="clear: both;" class_name="clear_thong-tin-51"></div></div><div class="input-text c-thong-tin-53" class_name="thong-tin-53">Kế hoạch lựa chọn nhà thầu</div><div style="clear: both;" class_name="clear_thong-tin-50"></div></div><div class="c-thong-tin-54" class_name="thong-tin-54"><div class="c-thong-tin-55" class_name="thong-tin-55"><img src="/zeanniTheme/img/0.910657001559136722.svg" class="c-thong-tin-56" class_name="thong-tin-56"><div style="clear: both;" class_name="clear_thong-tin-55"></div></div><div class="input-text  c-thong-tin-57" class_name="thong-tin-57">Thông báo mời thầu sơ tuyển</div><div style="clear: both;" class_name="clear_thong-tin-54"></div></div><div class="c-thong-tin-259" class_name="thong-tin-259"><div class="c-thong-tin-260" class_name="thong-tin-260"><img src="/zeanniTheme/img/0.408533001559136754.svg" class="c-thong-tin-261" class_name="thong-tin-261"><div style="clear: both;" class_name="clear_thong-tin-260"></div></div><div class="input-text   c-thong-tin-262" class_name="thong-tin-262">Thông báo mời thầu</div><div style="clear: both;" class_name="clear_thong-tin-259"></div></div><div class="c-thong-tin-58" class_name="thong-tin-58"><div class="c-thong-tin-59" class_name="thong-tin-59"><img src="/zeanniTheme/img/0.700456001559183253.svg" class="c-thong-tin-60" class_name="thong-tin-60"><div style="clear: both;" class_name="clear_thong-tin-59"></div></div><div class="input-text   c-thong-tin-61" class_name="thong-tin-61">Kết quả sơ tuyển</div><div style="clear: both;" class_name="clear_thong-tin-58"></div></div><div class="c-thong-tin-263" class_name="thong-tin-263"><div class="c-thong-tin-264" class_name="thong-tin-264"><img src="/zeanniTheme/img/0.263501001559183293.svg" class="c-thong-tin-265" class_name="thong-tin-265"><div style="clear: both;" class_name="clear_thong-tin-264"></div></div><div class="input-text    c-thong-tin-266" class_name="thong-tin-266">Kết quả đấu thầu</div><div style="clear: both;" class_name="clear_thong-tin-263"></div></div><div style="clear: both;" class_name="clear_thong-tin-49"></div></div><div style="clear: both;" class_name="clear_thong-tin-46"></div></div><div class="c-thong-tin-267" class_name="thong-tin-267"><div class="c-thong-tin-268" class_name="thong-tin-268"><div class="input-text  c-thong-tin-269" class_name="thong-tin-269">Top mời thầu</div><a href="/tra-cuu-nha-thau" class="c-thong-tin-270" class_name="thong-tin-270"><div class="c-thong-tin-271" class_name="thong-tin-271"><div class="input-text c-thong-tin-272" class_name="thong-tin-272">Xem thêm</div><div class="c-thong-tin-273" class_name="thong-tin-273"><img src="/zeanniTheme/img/0.924155001557205392.svg" class="c-thong-tin-274" class_name="thong-tin-274"><div style="clear: both;" class_name="clear_thong-tin-273"></div></div><div style="clear: both;" class_name="clear_thong-tin-271"></div></div></a><div style="clear: both;" class_name="clear_thong-tin-268"></div></div><div class="c-thong-tin-275" class_name="thong-tin-275"><div class="c-thong-tin-276" class_name="thong-tin-276"><div class="c-thong-tin-277" class_name="thong-tin-277"><a href="/nha-thau---chi-tiet" class="c-thong-tin-278" class_name="thong-tin-278"><div class="c-thong-tin-279" class_name="thong-tin-279"><div class="c-thong-tin-280" class_name="thong-tin-280" overlay="1"><div class="c-thong-tin-281" class_name="thong-tin-281" overlay="1"><div class="input-text    c-thong-tin-282" class_name="thong-tin-282">Công ty điện lực Sơn La</div><div style="clear: both;" class_name="clear_thong-tin-281"></div></div><div style="clear: both;" class_name="clear_thong-tin-280"></div></div><img src="/zeanniTheme/img/0.189281001559177227.png" class="c-thong-tin-283" class_name="thong-tin-283"><div style="clear: both;" class_name="clear_thong-tin-279"></div></div></a><a href="/nha-thau---chi-tiet" class="c-thong-tin-284" class_name="thong-tin-284"><div class="c-thong-tin-285" class_name="thong-tin-285"><div class="c-thong-tin-286" class_name="thong-tin-286" overlay="1"><div class="c-thong-tin-287" class_name="thong-tin-287" overlay="1"><div class="input-text     c-thong-tin-288" class_name="thong-tin-288">Công ty cổ phần xi măng vicem...</div><div style="clear: both;" class_name="clear_thong-tin-287"></div></div><div style="clear: both;" class_name="clear_thong-tin-286"></div></div><img src="/zeanniTheme/img/0.292430001559177272.png" class="c-thong-tin-289" class_name="thong-tin-289"><div style="clear: both;" class_name="clear_thong-tin-285"></div></div></a><a href="/nha-thau---chi-tiet" class="c-thong-tin-290" class_name="thong-tin-290"><div class="c-thong-tin-291" class_name="thong-tin-291"><div class="c-thong-tin-292" class_name="thong-tin-292" overlay="1"><div class="c-thong-tin-293" class_name="thong-tin-293" overlay="1"><div class="input-text      c-thong-tin-294" class_name="thong-tin-294">Ban Quản lý dự án đầu tư ...</div><div style="clear: both;" class_name="clear_thong-tin-293"></div></div><div style="clear: both;" class_name="clear_thong-tin-292"></div></div><img src="/zeanniTheme/img/0.876999001559177303.png" class="c-thong-tin-295" class_name="thong-tin-295"><div style="clear: both;" class_name="clear_thong-tin-291"></div></div></a><div style="clear: both;" class_name="clear_thong-tin-277"></div></div><div style="clear: both;" class_name="clear_thong-tin-276"></div></div><div style="clear: both;" class_name="clear_thong-tin-275"></div></div><div style="clear: both;" class_name="clear_thong-tin-267"></div></div><div class="c-thong-tin-183" class_name="thong-tin-183"><div class="c-thong-tin-184" class_name="thong-tin-184"><div class="input-text   c-thong-tin-185" class_name="thong-tin-185">Top lĩnh vực đấu thầu</div><a href="/thong-bao-moi-thau" class="c-thong-tin-242" class_name="thong-tin-242"><div class="c-thong-tin-186" class_name="thong-tin-186"><div class="input-text  c-thong-tin-187" class_name="thong-tin-187">Xem thêm</div><div class="c-thong-tin-188" class_name="thong-tin-188"><img src="/zeanniTheme/img/0.924155001557205392.svg" class="c-thong-tin-189" class_name="thong-tin-189"><div style="clear: both;" class_name="clear_thong-tin-188"></div></div><div style="clear: both;" class_name="clear_thong-tin-186"></div></div></a><div style="clear: both;" class_name="clear_thong-tin-184"></div></div><div class="c-thong-tin-190" class_name="thong-tin-190"><div class="c-thong-tin-191" class_name="thong-tin-191"><div class="c-thong-tin-192" class_name="thong-tin-192"><a href="/thong-bao-moi-thau" class="c-thong-tin-243" class_name="thong-tin-243"><div class="c-thong-tin-208" class_name="thong-tin-208"><div class="c-thong-tin-209" class_name="thong-tin-209"><img src="/zeanniTheme/img/0.404602001559184620.png" class="c-thong-tin-296" class_name="thong-tin-296"><div style="clear: both;" class_name="clear_thong-tin-209"></div></div><div class="c-thong-tin-210 input-text" class_name="thong-tin-210">Xây dựng</div><div style="clear: both;" class_name="clear_thong-tin-208"></div></div></a><a href="/thong-bao-moi-thau" class="c-thong-tin-244" class_name="thong-tin-244"><div class="c-thong-tin-212" class_name="thong-tin-212"><div class="c-thong-tin-213" class_name="thong-tin-213"><img src="/zeanniTheme/img/0.327180001559185056.png" class="c-thong-tin-297" class_name="thong-tin-297"><div style="clear: both;" class_name="clear_thong-tin-213"></div></div><div class="input-text c-thong-tin-215" class_name="thong-tin-215">Giáo dục</div><div style="clear: both;" class_name="clear_thong-tin-212"></div></div></a><a href="/thong-bao-moi-thau" class="c-thong-tin-245" class_name="thong-tin-245"><div class="c-thong-tin-217" class_name="thong-tin-217"><div class="c-thong-tin-218" class_name="thong-tin-218"><img src="/zeanniTheme/img/0.120163001559185171.png" class="c-thong-tin-298" class_name="thong-tin-298"><div style="clear: both;" class_name="clear_thong-tin-218"></div></div><div class="input-text  c-thong-tin-220" class_name="thong-tin-220">Công nghệ</div><div style="clear: both;" class_name="clear_thong-tin-217"></div></div></a><a href="/thong-bao-moi-thau" class="c-thong-tin-246" class_name="thong-tin-246"><div class="c-thong-tin-226" class_name="thong-tin-226"><div class="c-thong-tin-227" class_name="thong-tin-227"><img src="/zeanniTheme/img/0.120163001559185171.png" class="c-thong-tin-228" class_name="thong-tin-228"><div style="clear: both;" class_name="clear_thong-tin-227"></div></div><div class="input-text   c-thong-tin-229" class_name="thong-tin-229">Vận tải</div><div style="clear: both;" class_name="clear_thong-tin-226"></div></div></a><a href="/thong-bao-moi-thau" class="c-thong-tin-247" class_name="thong-tin-247"><div class="c-thong-tin-222" class_name="thong-tin-222"><div class="c-thong-tin-223" class_name="thong-tin-223"><img src="/zeanniTheme/img/0.120163001559185171.png" class="c-thong-tin-224" class_name="thong-tin-224"><div style="clear: both;" class_name="clear_thong-tin-223"></div></div><div class="input-text   c-thong-tin-225" class_name="thong-tin-225">Bất động sản</div><div style="clear: both;" class_name="clear_thong-tin-222"></div></div></a><div style="clear: both;" class_name="clear_thong-tin-192"></div></div><div style="clear: both;" class_name="clear_thong-tin-191"></div></div><div style="clear: both;" class_name="clear_thong-tin-190"></div></div><div style="clear: both;" class_name="clear_thong-tin-183"></div></div><div class="c-thong-tin-299" class_name="thong-tin-299"><div class="c-thong-tin-300" class_name="thong-tin-300"><div class="input-text     c-thong-tin-301" class_name="thong-tin-301">Tin tức đấu thầu</div><div style="clear: both;" class_name="clear_thong-tin-300"></div></div><div class="c-thong-tin-302" class_name="thong-tin-302"><a href="/chi-tiet-tin-tuc" class="c-thong-tin-303" class_name="thong-tin-303"><div class="c-thong-tin-304" class_name="thong-tin-304"><div class="c-thong-tin-305" class_name="thong-tin-305"><img src="/zeanniTheme/img/0.430722001559187054.png" class="c-thong-tin-306" class_name="thong-tin-306"><div style="clear: both;" class_name="clear_thong-tin-305"></div></div><div class="c-thong-tin-307" class_name="thong-tin-307"><div class="input-text   c-thong-tin-308" class_name="thong-tin-308">Nghi vấn nhà thầu không nghiêm túc khi dự thầu</div><div class="c-thong-tin-309" class_name="thong-tin-309"><div class="c-thong-tin-310" class_name="thong-tin-310"><img src="/zeanniTheme/img/0.157225001557217390.svg" class="c-thong-tin-311" class_name="thong-tin-311"><div style="clear: both;" class_name="clear_thong-tin-310"></div></div><div class="input-text   c-thong-tin-312" class_name="thong-tin-312">1,190</div><div style="clear: both;" class_name="clear_thong-tin-309"></div></div><div style="clear: both;" class_name="clear_thong-tin-307"></div></div><div style="clear: both;" class_name="clear_thong-tin-304"></div></div></a><a href="/chi-tiet-tin-tuc" class="c-thong-tin-313" class_name="thong-tin-313"><div class="c-thong-tin-314" class_name="thong-tin-314"><div class="c-thong-tin-315" class_name="thong-tin-315"><img src="/zeanniTheme/img/0.293031001559187076.png" class="c-thong-tin-316" class_name="thong-tin-316"><div style="clear: both;" class_name="clear_thong-tin-315"></div></div><div class="c-thong-tin-317" class_name="thong-tin-317"><div class="input-text    c-thong-tin-318" class_name="thong-tin-318">EVN: 4.500 gói đấu thầu qua mạng</div><div class="c-thong-tin-319" class_name="thong-tin-319"><div class="c-thong-tin-320" class_name="thong-tin-320"><img src="/zeanniTheme/img/0.157225001557217390.svg" class="c-thong-tin-321" class_name="thong-tin-321"><div style="clear: both;" class_name="clear_thong-tin-320"></div></div><div class="input-text    c-thong-tin-322" class_name="thong-tin-322">1,190</div><div style="clear: both;" class_name="clear_thong-tin-319"></div></div><div style="clear: both;" class_name="clear_thong-tin-317"></div></div><div style="clear: both;" class_name="clear_thong-tin-314"></div></div></a><a href="/chi-tiet-tin-tuc" class="c-thong-tin-323" class_name="thong-tin-323"><div class="c-thong-tin-324" class_name="thong-tin-324"><div class="c-thong-tin-325" class_name="thong-tin-325"><img src="/zeanniTheme/img/0.563563001559187101.png" class="c-thong-tin-326" class_name="thong-tin-326"><div style="clear: both;" class_name="clear_thong-tin-325"></div></div><div class="c-thong-tin-327" class_name="thong-tin-327"><div class="input-text     c-thong-tin-328" class_name="thong-tin-328">Đà Nẵng, Sơn La, Hòa Bình dẫn đầu về đấu thầu qua mạng</div><div class="c-thong-tin-329" class_name="thong-tin-329"><div class="c-thong-tin-330" class_name="thong-tin-330"><img src="/zeanniTheme/img/0.157225001557217390.svg" class="c-thong-tin-331" class_name="thong-tin-331"><div style="clear: both;" class_name="clear_thong-tin-330"></div></div><div class="input-text     c-thong-tin-332" class_name="thong-tin-332">1,190</div><div style="clear: both;" class_name="clear_thong-tin-329"></div></div><div style="clear: both;" class_name="clear_thong-tin-327"></div></div><div style="clear: both;" class_name="clear_thong-tin-324"></div></div></a><a href="/chi-tiet-tin-tuc" class="c-thong-tin-333" class_name="thong-tin-333"><div class="c-thong-tin-334" class_name="thong-tin-334"><div class="c-thong-tin-335" class_name="thong-tin-335"><img src="/zeanniTheme/img/0.264585001559187157.png" class="c-thong-tin-336" class_name="thong-tin-336"><div style="clear: both;" class_name="clear_thong-tin-335"></div></div><div class="c-thong-tin-337" class_name="thong-tin-337"><div class="input-text      c-thong-tin-338" class_name="thong-tin-338">Đấu thầu qua mạng: Lợi ích và hiệu quả nhiều mặt</div><div class="c-thong-tin-339" class_name="thong-tin-339"><div class="c-thong-tin-340" class_name="thong-tin-340"><img src="/zeanniTheme/img/0.157225001557217390.svg" class="c-thong-tin-341" class_name="thong-tin-341"><div style="clear: both;" class_name="clear_thong-tin-340"></div></div><div class="input-text      c-thong-tin-342" class_name="thong-tin-342">1,190</div><div style="clear: both;" class_name="clear_thong-tin-339"></div></div><div style="clear: both;" class_name="clear_thong-tin-337"></div></div><div style="clear: both;" class_name="clear_thong-tin-334"></div></div></a><div style="clear: both;" class_name="clear_thong-tin-302"></div></div><div style="clear: both;" class_name="clear_thong-tin-299"></div></div><div style="clear: both;" class_name="clear_thong-tin-33"></div></div><div class="c-thong-tin-166" class_name="thong-tin-166" includepage="footer-1"><div style="clear: both;" class_name="clear_thong-tin-166"></div><div style="clear: both;" class_name="clear_thong-tin-166"></div><div class="c-footer-1-150" class_name="footer-1-150" footer_app="1"><a href="/home" class="c-footer-1-163" class_name="footer-1-163"><div class="c-footer-1-151" class_name="footer-1-151"><div class="c-footer-1-152" class_name="footer-1-152"><img src="/zeanniTheme/img/0.981402001559817901.png" class="c-footer-1-173" class_name="footer-1-173"><div style="clear: both;" class_name="clear_footer-1-152"></div></div><div class="input-text  c-footer-1-154" class_name="footer-1-154">Trang chủ</div><div style="clear: both;" class_name="clear_footer-1-151"></div></div></a><a href="/uu-dai" class="c-footer-1-175" class_name="footer-1-175"><div class="c-footer-1-155" class_name="footer-1-155"><div class="c-footer-1-156" class_name="footer-1-156"><img src="/zeanniTheme/img/0.910463001559818140.png" class="c-footer-1-174" class_name="footer-1-174"><div style="clear: both;" class_name="clear_footer-1-156"></div></div><div class="input-text   c-footer-1-158" class_name="footer-1-158">Ưu đãi</div><div style="clear: both;" class_name="clear_footer-1-155"></div></div></a><a href="/tro-giup" class="c-footer-1-172" class_name="footer-1-172"><div class="c-footer-1-164" class_name="footer-1-164"><div class="c-footer-1-165" class_name="footer-1-165"><img src="/zeanniTheme/img/0.626373001557219910.svg" class="c-footer-1-166" class_name="footer-1-166"><div style="clear: both;" class_name="clear_footer-1-165"></div></div><div class="input-text    c-footer-1-167" class_name="footer-1-167">Hỗ trợ</div><div style="clear: both;" class_name="clear_footer-1-164"></div></div></a><a href="/thong-tin-ca-nhan" class="c-footer-1-171" class_name="footer-1-171"><div class="c-footer-1-159" class_name="footer-1-159"><div class="c-footer-1-160" class_name="footer-1-160"><img src="/zeanniTheme/img/0.911857001558409115.svg" class="c-footer-1-169" class_name="footer-1-169"><div style="clear: both;" class_name="clear_footer-1-160"></div></div><div class="input-text    c-footer-1-162" class_name="footer-1-162">Tài khoản</div><div style="clear: both;" class_name="clear_footer-1-159"></div></div></a><div style="clear: both;" class_name="clear_footer-1-150"></div></div><div style="clear: both;" class_name="clear_content-layer"></div><div style="clear: both;" class_name="clear_thong-tin-166"></div></div><div style="clear: both;" class_name="clear_thong-tin-2"></div></div><div style="clear: both;" class_name="clear_content-layer"></div><script> zLh94 = {}; zLd50 = {};/*thiet lap gia tri ui sau khi cap nhat bien client*/$.each($_systemCookie,function (i, v) {try {$_systemCookie[i]=JSON.parse(v);}catch (e) {}});zLk328();/*end: thiet lap gia tri ui sau khi cap nhat bien client*/zLg75();zLn266 = function(selectorParent){selectorParent = selectorParent || "#content";};zLm174();zLn266();zLd84();zLa111();zLa192();zLf79();$('[social_action=shareF]').attr('onclick','zLb132();');            $('[social_action=shareG]').off('click').on('click',function(){zLn293();});            $('[social_action=shareT]').off('click').on('click',function(){zLb276();});</script></body></html>