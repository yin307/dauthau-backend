<!DOCTYPE html><html><head> <?php  global $_systemCookie, $_systemSession, $_getSegment; include_once (PATH_STSTEM."/application/libraries/Lib_ZN.php"); function numberFormat($number, $decimals = null, $dec_point = ".", $thousands_sep = ","){  return Lib_ZN::numberFormat($number, $decimals, $dec_point, $thousands_sep);} function find($vl,$arr){  return Lib_ZN::find($vl,$arr);} function sum($arr=array(),$key=""){  return Lib_ZN::sum($arr,$key);} function formatDate($date,$format){  return Lib_ZN::formatDate($date,$format);} $self = !empty($_SERVER["PHP_SELF"])?$_SERVER["PHP_SELF"]:$_SERVER["SCRIPT_NAME"];    $self = explode("/",$self);    $_getSegment = array();    for ($x=1;$x<=count($self);$x++){        $_getSegment[$x] = $this->db->escape_str($this->uri->segment($x));    }$_systemCookie=array();if(!empty($_COOKIE)){    $_systemCookie = $_COOKIE;} $_systemSession = $this->session->userdata();echo '<script>var $_systemCookie = '.json_encode($_systemCookie).';var $_zn = [];$_zn["clZN_dataClient"]={};</script>';foreach ($_systemCookie as $k=>$v){$ck = json_decode($v,true);if(is_array($ck)){    $_systemCookie[$k]=$ck;}}?><meta http-equiv="content-type" content="text/html; charset=utf-8" /><link href="/zeanniTheme/favicon.png" rel="shortcut icon"><meta name="viewport" content="width=device-width, initial-scale=1.0"/><script type="text/javascript" src="/zeanniTheme/js/jquery-1.9.1.js"></script><script src="/zeanniTheme/js/jquery-ui.min.js"></script><link rel="stylesheet" href="/zeanniTheme/css/jquery-ui.css"><link href="/zeanniTheme/css/font.css?time=1561421908868" type="text/css" rel="stylesheet"/><script type="text/javascript" src="/zeanniTheme/plugins/jssor.slider/jssor.slider.min.js?time=1561421908868"></script><script type="text/javascript" src="/zeanniTheme/js/zeanniLib.js?time=1561421908868"></script><link href="/zeanniTheme/css/Zn_chi_tiet_tin_tuc.css?time=1561421908868" type="text/css" rel="stylesheet"/><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous"/></head><body id="content"><div class="c-chi-tiet-tin-tuc-2" class_name="chi-tiet-tin-tuc-2"><div class="c-chi-tiet-tin-tuc-3" class_name="chi-tiet-tin-tuc-3" includepage="header-3"><div style="clear: both;" class_name="clear_chi-tiet-tin-tuc-3"></div><div style="clear: both;" class_name="clear_chi-tiet-tin-tuc-3"></div><div style="clear: both;" class_name="clear_chi-tiet-tin-tuc-3"></div><div class="c-header-3-2" class_name="header-3-2" header_app="1"><div class="c-header-3-3" class_name="header-3-3"><div class="c-header-3-4" class_name="header-3-4"><div class="c-header-3-6" class_name="header-3-6" button_back_app="1"><div class="c-header-3-7" class_name="header-3-7"><img src="/zeanniTheme/img/0.826618001557220692.svg" class="c-header-3-8" class_name="header-3-8"><div style="clear: both;" class_name="clear_header-3-7"></div></div><div style="clear: both;" class_name="clear_header-3-6"></div></div><div class="c-header-3-9" class_name="header-3-9"> <?php  $FunCode_header310 = function ($v){GLOBAL $_systemCookie,$_systemSession,$_getSegment;if(!isset($_GET['title'])){$_GET['title']=null;}if(!isset($_GET['title'])){$_GET['title']=null;} return  (  empty  ( $_GET['title'] )  ? 'Title' : $_GET['title'] )  ; ; };$html = '';$j=1; $v = array();$html .='<div class="input-text   c-header-3-10 zn-scriptCreate" class_name="header-3-10" o_index="0">'; $getData = $FunCode_header310($v); if(isset($getData)){ $html .= $getData; }else{ $html .='Title'; } $html .='</div>';echo $html; ?> <div style="clear: both;" class_name="clear_header-3-9"></div></div><div class="c-header-3-16" class_name="header-3-16" indextab="0"><div class="c-header-3-17" class_name="header-3-17" button_share_app="1"><img src="/zeanniTheme/img/0.330281001559818807.png" class="c-header-3-19" class_name="header-3-19"><div style="clear: both;" class_name="clear_header-3-17"></div></div><div style="clear: both;" class_name="clear_header-3-16"></div></div><div style="clear: both;" class_name="clear_header-3-4"></div></div><div style="clear: both;" class_name="clear_header-3-3"></div></div><div style="clear: both;" class_name="clear_header-3-2"></div></div><div style="clear: both;" class_name="clear_content-layer"></div><div style="clear: both;" class_name="clear_chi-tiet-tin-tuc-3"></div></div><div class="c-chi-tiet-tin-tuc-14" class_name="chi-tiet-tin-tuc-14"><div class="c-chi-tiet-tin-tuc-15" class_name="chi-tiet-tin-tuc-15"> <?php  $FunCode_chitiettintuc116 = function ($v){GLOBAL $_systemCookie,$_systemSession,$_getSegment; return $v["a1-zn-DATE_SUBMITTED"] . " (GMT+7)" ; ; };$html = ''; if(!empty($NewsDetail[0])){ $j1=1; $v1 = $NewsDetail[0];$html .='<div class="c-chi-tiet-tin-tuc-18 zn-scriptCreate" class_name="chi-tiet-tin-tuc-18" o_index="1"><div class="c-chi-tiet-tin-tuc-109" class_name="chi-tiet-tin-tuc-109"><div class="input-text    c-chi-tiet-tin-tuc-110" class_name="chi-tiet-tin-tuc-110" zn-group="NewsDetail">'.$v1['a1-zn-TITLE'].'</div><div class="c-chi-tiet-tin-tuc-111" class_name="chi-tiet-tin-tuc-111"><div class="c-chi-tiet-tin-tuc-116 input-text" class_name="chi-tiet-tin-tuc-116" zn-group="NewsDetail">'; $getData = $FunCode_chitiettintuc116($v1); if(isset($getData)){ $html .= $getData; }else{ $html .='Thứ 3, 9/4/2019, 08:12 (GMT+7)'; } $html .='</div><div style="clear: both;" class_name="clear_chi-tiet-tin-tuc-111"></div></div><div class="input-text      c-chi-tiet-tin-tuc-115" class_name="chi-tiet-tin-tuc-115" zn-group="NewsDetail">'.$v1['a1-zn-POST'].'</div><div style="clear: both;" class_name="clear_chi-tiet-tin-tuc-109"></div></div><div class="c-chi-tiet-tin-tuc-120" class_name="chi-tiet-tin-tuc-120"><div class="c-chi-tiet-tin-tuc-122 input-text" class_name="chi-tiet-tin-tuc-122"><b>|&nbsp;</b>biên tập</div><div class="input-text  c-chi-tiet-tin-tuc-168" class_name="chi-tiet-tin-tuc-168" zn-group="NewsDetail">'.$v1['a1-zn-EDITOR'].'</div><div style="clear: both;" class_name="clear_chi-tiet-tin-tuc-120"></div></div><div style="clear: both;" class_name="clear_chi-tiet-tin-tuc-18"></div></div>';echo $html; } ?> <div style="clear: both;" class_name="clear_chi-tiet-tin-tuc-15"></div></div><div class="c-chi-tiet-tin-tuc-56" class_name="chi-tiet-tin-tuc-56"><div class="c-chi-tiet-tin-tuc-57" class_name="chi-tiet-tin-tuc-57"><div class="input-text     c-chi-tiet-tin-tuc-58" class_name="chi-tiet-tin-tuc-58">Tin tức liên quan</div><div style="clear: both;" class_name="clear_chi-tiet-tin-tuc-57"></div></div><div class="c-chi-tiet-tin-tuc-127" class_name="chi-tiet-tin-tuc-127"> <?php  $FunCode_chitiettintuc137 = function ($v){GLOBAL $_systemCookie,$_systemSession,$_getSegment; return  numberFormat  ( $v["a1-zn-COUNT_VIEW"] ,  0  ,  '.'  , "," )  ; ; };$html='';if(!empty($newsInvolve)){ $j2=0;foreach ($newsInvolve as $v2){ $j2++;if($j2<1)    continue;$html .='<div class="c-chi-tiet-tin-tuc-129 zn-scriptCreate" class_name="chi-tiet-tin-tuc-129" o_index="2"><a class="zn-a" href="/chi-tiet-tin-tuc/'.$v2['a1-zn-ID'].'"><div class="c-chi-tiet-tin-tuc-130" class_name="chi-tiet-tin-tuc-130" zn-group="newsInvolve"><img src="'.$v2['a1-zn-IMG'].'" class="c-chi-tiet-tin-tuc-131" class_name="chi-tiet-tin-tuc-131" zn-group="newsInvolve"><div style="clear: both;" class_name="clear_chi-tiet-tin-tuc-130"></div></div></a><div class="c-chi-tiet-tin-tuc-132" class_name="chi-tiet-tin-tuc-132"><a class="zn-a" href="/chi-tiet-tin-tuc/'.$v2['a1-zn-ID'].'"><div class="input-text    c-chi-tiet-tin-tuc-133" class_name="chi-tiet-tin-tuc-133" zn-group="newsInvolve">'.$v2['a1-zn-TITLE'].'</div></a><div class="c-chi-tiet-tin-tuc-134" class_name="chi-tiet-tin-tuc-134"><div class="c-chi-tiet-tin-tuc-135" class_name="chi-tiet-tin-tuc-135"><img src="/zeanniTheme/img/0.660876001561103028.png" class="c-chi-tiet-tin-tuc-169" class_name="chi-tiet-tin-tuc-169"><div style="clear: both;" class_name="clear_chi-tiet-tin-tuc-135"></div></div><div class="input-text    c-chi-tiet-tin-tuc-137" class_name="chi-tiet-tin-tuc-137" zn-group="newsInvolve">'; $getData = $FunCode_chitiettintuc137($v2); if(isset($getData)){ $html .= $getData; }else{ $html .='1,190'; } $html .='</div><div style="clear: both;" class_name="clear_chi-tiet-tin-tuc-134"></div></div><div style="clear: both;" class_name="clear_chi-tiet-tin-tuc-132"></div></div><div style="clear: both;" class_name="clear_chi-tiet-tin-tuc-129"></div></div>'; } } echo $html; ?> <div style="clear: both;" class_name="clear_chi-tiet-tin-tuc-127"></div></div><div style="clear: both;" class_name="clear_chi-tiet-tin-tuc-56"></div></div><div style="clear: both;" class_name="clear_chi-tiet-tin-tuc-14"></div></div><div style="clear: both;" class_name="clear_chi-tiet-tin-tuc-2"></div></div><div style="clear: both;" class_name="clear_content-layer"></div><script> zLh94 = {}; zLd50 = {};/*thiet lap gia tri ui sau khi cap nhat bien client*/$.each($_systemCookie,function (i, v) {try {$_systemCookie[i]=JSON.parse(v);}catch (e) {}});zLk328();/*end: thiet lap gia tri ui sau khi cap nhat bien client*/zLg75();zLn266 = function(selectorParent){selectorParent = selectorParent || "#content";};zLm174();zLn266();zLd84();zLa111();zLa192();zLf79();$('[social_action=shareF]').attr('onclick','zLb132();');            $('[social_action=shareG]').off('click').on('click',function(){zLn293();});            $('[social_action=shareT]').off('click').on('click',function(){zLb276();});</script></body></html>