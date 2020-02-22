<!DOCTYPE html>
<html>
<head> <?php global $_systemCookie, $_systemSession, $_getSegment;
    include_once(PATH_STSTEM . "/application/libraries/Lib_ZN.php");
    function numberFormat($number, $decimals = null, $dec_point = ".", $thousands_sep = ",")
    {
        return Lib_ZN::numberFormat($number, $decimals, $dec_point, $thousands_sep);
    }

    function find($vl, $arr)
    {
        return Lib_ZN::find($vl, $arr);
    }

    function sum($arr = array(), $key = "")
    {
        return Lib_ZN::sum($arr, $key);
    }

    function formatDate($date, $format)
    {
        return Lib_ZN::formatDate($date, $format);
    }

    $self = !empty($_SERVER["PHP_SELF"]) ? $_SERVER["PHP_SELF"] : $_SERVER["SCRIPT_NAME"];
    $self = explode("/", $self);
    $_getSegment = array();
    for ($x = 1; $x <= count($self); $x++) {
        $_getSegment[$x] = $this->db->escape_str($this->uri->segment($x));
    }
    $_systemCookie = array();
    if (!empty($_COOKIE)) {
        $_systemCookie = $_COOKIE;
    }
    $_systemSession = $this->session->userdata();
    echo '<script>var $_systemCookie = ' . json_encode($_systemCookie) . ';var $_zn = [];$_zn["clZN_dataClient"]={};</script>';
    foreach ($_systemCookie as $k => $v) {
        $ck = json_decode($v, true);
        if (is_array($ck)) {
            $_systemCookie[$k] = $ck;
        }
    } ?>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <link href="/zeanniTheme/favicon.png" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script type="text/javascript" src="/zeanniTheme/js/jquery-1.9.1.js"></script>
    <script src="/zeanniTheme/js/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="/zeanniTheme/css/jquery-ui.css">
    <link href="/zeanniTheme/css/font.css?time=1561421928433" type="text/css" rel="stylesheet"/>
    <script type="text/javascript"
            src="/zeanniTheme/plugins/jssor.slider/jssor.slider.min.js?time=1561421928433"></script>
    <script type="text/javascript" src="/zeanniTheme/js/zeanniLib.js?time=1561421928433"></script>
    <link href="/zeanniTheme/css/Zn_thong_bao_moi_thau.css?time=1561421928433" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
          integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous"/>
</head>
<body id="content">
<div class="c-thong-bao-moi-thau-2" class_name="thong-bao-moi-thau-2">
    <div class="c-thong-bao-moi-thau-3" class_name="thong-bao-moi-thau-3" includepage="header-2">
        <div style="clear: both;" class_name="clear_thong-bao-moi-thau-3"></div>
        <div style="clear: both;" class_name="clear_thong-bao-moi-thau-3"></div>
        <div class="c-header-2-97" class_name="header-2-97" header_app="1">
            <div class="c-header-2-98" class_name="header-2-98">
                <div class="c-header-2-99" class_name="header-2-99">
                    <div class="c-header-2-100" class_name="header-2-100" button_back_app="1">
                        <div class="c-header-2-101" class_name="header-2-101"><img
                                    src="/zeanniTheme/img/0.104646001560171964.png" class="c-header-2-115"
                                    class_name="header-2-115">
                            <div style="clear: both;" class_name="clear_header-2-101"></div>
                        </div>
                        <div style="clear: both;" class_name="clear_header-2-100"></div>
                    </div>
                    <div class="c-header-2-103" class_name="header-2-103"> <?php $FunCode_header2104 = function ($v) {
                            GLOBAL $_systemCookie, $_systemSession, $_getSegment;
                            if (!isset($_GET['title'])) {
                                $_GET['title'] = null;
                            }
                            if (!isset($_GET['title'])) {
                                $_GET['title'] = null;
                            }
                            return (empty  ($_GET['title']) ? 'Title' : $_GET['title']);;
                        };
                        $html = '';
                        $j = 1;
                        $v = array();
                        $html .= '<div class="input-text  c-header-2-104 zn-scriptCreate" class_name="header-2-104" o_index="0">';
                        $getData = $FunCode_header2104($v);
                        if (isset($getData)) {
                            $html .= $getData;
                        } else {
                            $html .= 'Title';
                        }
                        $html .= '</div>';
                        echo $html; ?>
                        <div class="c-header-2-109" class_name="header-2-109" overlay="1">
                            <div class="c-header-2-111" class_name="header-2-111">
                                <div class="c-header-2-112" class_name="header-2-112">
                                    <svg class="svg-inline--fa fa-search fa-w-16 fa-fw" aria-hidden="true"
                                         data-prefix="fas" data-icon="search" role="img"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""
                                         set-adddatafromdb-content="" zn-valfuncode_string=""
                                         zn-valfuncodeinputvalue_string="" zn-valfuncodelabel_string="">
                                        <path fill="currentColor"
                                              d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"
                                              set-adddatafromdb-content="" zn-valfuncode_string=""
                                              zn-valfuncodeinputvalue_string="" zn-valfuncodelabel_string=""></path>
                                    </svg><!-- <i class="fas fa-search fa-fw"></i> --></div>
                                <input name="name_header-2_114" class="inputText    c-header-2-114"
                                       class_name="header-2-114" type="text" value="" placeholder="Bạn muốn tìm gì ?"
                                       varname="" type_varname="1">
                                <div style="clear: both;" class_name="clear_header-2-111"></div>
                            </div>
                            <div style="clear: both;" class_name="clear_header-2-109"></div>
                        </div>
                        <div style="clear: both;" class_name="clear_header-2-103"></div>
                    </div>
                    <div class="c-header-2-105" class_name="header-2-105" indextab="0">
                        <div class="c-header-2-106" class_name="header-2-106">
                            <svg class="svg-inline--fa fa-search fa-w-16 fa-fw" aria-hidden="true" data-prefix="fas"
                                 data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                 data-fa-i2svg="" set-adddatafromdb-content="" zn-valfuncode_string=""
                                 zn-valfuncodeinputvalue_string="" zn-valfuncodelabel_string="">
                                <path fill="currentColor"
                                      d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"
                                      set-adddatafromdb-content="" zn-valfuncode_string=""
                                      zn-valfuncodeinputvalue_string="" zn-valfuncodelabel_string=""></path>
                            </svg><!-- <i class="fas fa-search fa-fw"></i> --></div>
                        <div style="clear: both;" class_name="clear_header-2-105"></div>
                    </div>
                    <div style="clear: both;" class_name="clear_header-2-99"></div>
                </div>
                <div style="clear: both;" class_name="clear_header-2-98"></div>
            </div>
            <div style="clear: both;" class_name="clear_header-2-97"></div>
        </div>
        <div style="clear: both;" class_name="clear_content-layer"></div>
        <script id="jsEventAction" type="application/javascript">if (typeof FunCongfig == "undefined") {
                var FunCongfig = {};
            }
            FunCongfig["header-2"] = [{
                "element1": ".c-header-2-105",
                "element2": [".c-header-2-109"],
                "eventType": "click",
                "animationType": "showHide",
                "callBack": ["function(eventType,element1,element2,ind){ind = ind || 0; var elm2 = $($(element2)[ind]); elm2.css({'min-height':'initial','height':elm2.css('height')}); elm2.slideToggle(200);}"],
                "callBack2": ["function(eventType,element1,element2,ind){ind = ind || 0; var elm2 = $($(element2)[ind]); elm2.css({'min-height':'initial','height':elm2.css('height')}); elm2.slideToggle(200);}"]
            }];</script>
        <div style="clear: both;" class_name="clear_thong-bao-moi-thau-3"></div>
    </div>
    <div class="c-thong-bao-moi-thau-4" class_name="thong-bao-moi-thau-4">
        <div class="c-thong-bao-moi-thau-5" class_name="thong-bao-moi-thau-5" indextab="0">
            <div class="input-text c-thong-bao-moi-thau-6" class_name="thong-bao-moi-thau-6">Thông báo mời sơ tuyển
            </div>
            <div class="input-text c-thong-bao-moi-thau-7 active" class_name="thong-bao-moi-thau-7">Thông báo mời thầu
            </div>
            <div style="clear: both;" class_name="clear_thong-bao-moi-thau-5"></div>
        </div>
        <div class="c-thong-bao-moi-thau-8" class_name="thong-bao-moi-thau-8">
            <div class="c-thong-bao-moi-thau-9"
                 class_name="thong-bao-moi-thau-9"> <?php $FunCode_thongbaomoithau265 = function ($v) {
                    GLOBAL $_systemCookie, $_systemSession, $_getSegment;
                    return ("Ngày " . formatDate($v["a1-zn-CREATE_DATE"], "d/m/Y | H:i"));;
                };
                $FunCode_thongbaomoithau209 = function ($v) {
                    GLOBAL $_systemCookie, $_systemSession, $_getSegment;
                    return ($v["a1-zn-BID_PACKAGE_CODE"] . " - " . $v["a1-zn-NOTI_VERSION_NUM"]);;
                };
                $FunCode_thongbaomoithau133 = function ($v) {
                    GLOBAL $_systemCookie, $_systemSession, $_getSegment;
                    return formatDate($v["a1-zn-START_SUBMISSION_DATE"], "d/m/Y | H:i");;
                };
                $FunCode_thongbaomoithau207 = function ($v) {
                    GLOBAL $_systemCookie, $_systemSession, $_getSegment;
                    return formatDate($v["a1-zn-FINISH_SUBMISSION_DATE"], "d/m/Y | H:i");;
                };
                $html = '';
                if (!empty($listBidPackages_prequalification)) {
                    $j1 = 0;
                    foreach ($listBidPackages_prequalification as $v1) {
                        $j1++;
                        if ($j1 < 1) continue;
                        $html .= '<div class="c-thong-bao-moi-thau-10 zn-scriptCreate" class_name="thong-bao-moi-thau-10" o_index="1"><div class="c-thong-bao-moi-thau-11" class_name="thong-bao-moi-thau-11"><a class="zn-a" href="/thong-tin-goi-thau---chi-tiet/' . $v1['a1-zn-BID_PACKAGE_ID'] . '"><div class="input-text     c-thong-bao-moi-thau-12" class_name="thong-bao-moi-thau-12" zn-group="listBidPackages_prequalification">' . $v1['a2-zn-PROCURING_NAME'] . '</div></a><div style="clear: both;" class_name="clear_thong-bao-moi-thau-11"></div></div><div class="c-thong-bao-moi-thau-264" class_name="thong-bao-moi-thau-264" overlay="1"><div class="input-text      c-thong-bao-moi-thau-265" class_name="thong-bao-moi-thau-265" zn-group="listBidPackages_prequalification">';
                        $getData = $FunCode_thongbaomoithau265($v1);
                        if (isset($getData)) {
                            $html .= $getData;
                        } else {
                            $html .= '10/04/2019 - 12:04';
                        }
                        $html .= '</div><div style="clear: both;" class_name="clear_thong-bao-moi-thau-264"></div></div><a class="zn-a" href="/thong-tin-goi-thau---chi-tiet/' . $v1['a1-zn-BID_PACKAGE_ID'] . '"><div class="input-text   c-thong-bao-moi-thau-15" class_name="thong-bao-moi-thau-15" zn-group="listBidPackages_prequalification">' . $v1['a1-zn-PACKAGE_NAME'] . '</div></a><div class="c-thong-bao-moi-thau-16" class_name="thong-bao-moi-thau-16"><div class="input-text   c-thong-bao-moi-thau-17" class_name="thong-bao-moi-thau-17">Số TBMT:</div><div class="input-text     c-thong-bao-moi-thau-209" class_name="thong-bao-moi-thau-209" zn-group="listBidPackages_prequalification">';
                        $getData = $FunCode_thongbaomoithau209($v1);
                        if (isset($getData)) {
                            $html .= $getData;
                        } else {
                            $html .= '20190427895 - 00';
                        }
                        $html .= '</div><div class="c-thong-bao-moi-thau-208" class_name="thong-bao-moi-thau-208" overlay="1"><svg class="svg-inline--fa fa-star fa-w-18 fa-fw" aria-hidden="true" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="" set-adddatafromdb-content="" zn-valfuncode_string="" zn-valfuncodeinputvalue_string="" zn-valfuncodelabel_string=""><path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z" set-adddatafromdb-content="" zn-valfuncode_string="" zn-valfuncodeinputvalue_string="" zn-valfuncodelabel_string=""></path></svg><!-- <i class="fas fa-star fa-fw"></i> --></div><div style="clear: both;" class_name="clear_thong-bao-moi-thau-16"></div></div><div class="c-thong-bao-moi-thau-19" class_name="thong-bao-moi-thau-19"><div class="input-text    c-thong-bao-moi-thau-20" class_name="thong-bao-moi-thau-20">Địa bàn:</div><div class="input-text      c-thong-bao-moi-thau-21" class_name="thong-bao-moi-thau-21" zn-group="listBidPackages_prequalification">' . $v1['a1-zn-LOCATION'] . '</div><div style="clear: both;" class_name="clear_thong-bao-moi-thau-19"></div></div><div class="c-thong-bao-moi-thau-131" class_name="thong-bao-moi-thau-131"><div class="input-text       c-thong-bao-moi-thau-133" class_name="thong-bao-moi-thau-133" zn-group="listBidPackages_prequalification">';
                        $getData = $FunCode_thongbaomoithau133($v1);
                        if (isset($getData)) {
                            $html .= $getData;
                        } else {
                            $html .= '10/4/2019 -&nbsp;<span style="font-size: 12px;">12:04</span>';
                        }
                        $html .= '</div><div class="c-thong-bao-moi-thau-204" class_name="thong-bao-moi-thau-204"><img src="/zeanniTheme/img/0.386523001559901616.png" class="c-thong-bao-moi-thau-205" class_name="thong-bao-moi-thau-205"><div style="clear: both;" class_name="clear_thong-bao-moi-thau-204"></div></div><div class="input-text         c-thong-bao-moi-thau-207" class_name="thong-bao-moi-thau-207" zn-group="listBidPackages_prequalification">';
                        $getData = $FunCode_thongbaomoithau207($v1);
                        if (isset($getData)) {
                            $html .= $getData;
                        } else {
                            $html .= '10/5/2019 -&nbsp;<span style="font-size: 12px;">12:04</span>';
                        }
                        $html .= '</div><div style="clear: both;" class_name="clear_thong-bao-moi-thau-131"></div></div><div style="clear: both;" class_name="clear_thong-bao-moi-thau-10"></div></div>';
                    }
                }
                echo $html; ?>
                <div style="clear: both;" class_name="clear_thong-bao-moi-thau-9"></div>
            </div>
            <div class="c-thong-bao-moi-thau-56"
                 class_name="thong-bao-moi-thau-56"> <?php $FunCode_thongbaomoithau267 = function ($v) {
                    GLOBAL $_systemCookie, $_systemSession, $_getSegment;
                    return ("Ngày " . formatDate($v["a1-zn-CREATE_DATE"], "d/m/Y | H:i"));;
                };
                $FunCode_thongbaomoithau219 = function ($v) {
                    GLOBAL $_systemCookie, $_systemSession, $_getSegment;
                    return ($v["a1-zn-BID_PACKAGE_CODE"] . " - " . $v["a1-zn-NOTI_VERSION_NUM"]);;
                };
                $FunCode_thongbaomoithau225 = function ($v) {
                    GLOBAL $_systemCookie, $_systemSession, $_getSegment;
                    return (formatDate($v["a1-zn-START_SUBMISSION_DATE"], "d/m/Y | H:i"));;
                };
                $FunCode_thongbaomoithau228 = function ($v) {
                    GLOBAL $_systemCookie, $_systemSession, $_getSegment;
                    return formatDate($v["a1-zn-FINISH_SUBMISSION_DATE"], "d/m/Y | H:i");;
                };
                $FunCode_thongbaomoithau231 = function ($v) {
                    GLOBAL $_systemCookie, $_systemSession, $_getSegment;
                    echo $v["a1-zn-ESTIMATE_PRICE"];
                    return (numberFormat($v["a1-zn-ESTIMATE_PRICE"], 0, '.', ",") . " VNĐ");
                };
                $FunCode_thongbaomoithau232 = function ($v) {
                    GLOBAL $_systemCookie, $_systemSession, $_getSegment;
                    if ($v["a1-zn-NOTI_TYPE"] == 1) {
                        return '';
                    };
                };
                $FunCode_thongbaomoithau258 = function ($v) {
                    GLOBAL $_systemCookie, $_systemSession, $_getSegment;
                    if ($v["a1-zn-NOTI_TYPE"] != 1) {
                        return "";
                    };
                };
                $html = '';
                if (!empty($listBidPackages)) {
                    $j2 = 0;
                    foreach ($listBidPackages as $v2) {
                        $j2++;
                        if ($j2 < 1) continue;
                        $html .= '<div class="c-thong-bao-moi-thau-210 zn-scriptCreate" class_name="thong-bao-moi-thau-210" o_index="2"><div class="c-thong-bao-moi-thau-211" class_name="thong-bao-moi-thau-211"><a href="/thong-tin-goi-thau---chi-tiet" class="c-thong-bao-moi-thau-212" class_name="thong-bao-moi-thau-212"><a class="zn-a" href="/thong-tin-goi-thau---chi-tiet/' . $v2['a1-zn-BID_PACKAGE_ID'] . '"><div class="input-text      c-thong-bao-moi-thau-213" class_name="thong-bao-moi-thau-213" zn-group="listBidPackages">' . $v2['a2-zn-PROCURING_NAME'] . '</div></a></a><div style="clear: both;" class_name="clear_thong-bao-moi-thau-211"></div></div><div class="c-thong-bao-moi-thau-266" class_name="thong-bao-moi-thau-266" overlay="1"><div class="input-text       c-thong-bao-moi-thau-267" class_name="thong-bao-moi-thau-267" zn-group="listBidPackages">';
                        $getData = $FunCode_thongbaomoithau267($v2);
                        if (isset($getData)) {
                            $html .= $getData;
                        } else {
                            $html .= '10/04/2019 - 12:04';
                        }
                        $html .= '</div><div style="clear: both;" class_name="clear_thong-bao-moi-thau-266"></div></div><a class="zn-a" href="/thong-tin-goi-thau---chi-tiet/' . $v2['a1-zn-BID_PACKAGE_ID'] . '"><div class="input-text    c-thong-bao-moi-thau-216" class_name="thong-bao-moi-thau-216" zn-group="listBidPackages">' . $v2['a1-zn-PACKAGE_NAME'] . '</div></a><div class="c-thong-bao-moi-thau-217" class_name="thong-bao-moi-thau-217"><div class="input-text    c-thong-bao-moi-thau-218" class_name="thong-bao-moi-thau-218">Số TBMT:</div><div class="input-text      c-thong-bao-moi-thau-219" class_name="thong-bao-moi-thau-219" zn-group="listBidPackages">';
                        $getData = $FunCode_thongbaomoithau219($v2);
                        if (isset($getData)) {
                            $html .= $getData;
                        } else {
                            $html .= '20190427895 - 00';
                        }
                        $html .= '</div><div class="c-thong-bao-moi-thau-220" class_name="thong-bao-moi-thau-220" overlay="1"><svg class="svg-inline--fa fa-star fa-w-18 fa-fw" aria-hidden="true" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="" set-adddatafromdb-content="" zn-valfuncode_string="" zn-valfuncodeinputvalue_string="" zn-valfuncodelabel_string=""><path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z" set-adddatafromdb-content="" zn-valfuncode_string="" zn-valfuncodeinputvalue_string="" zn-valfuncodelabel_string=""></path></svg><!-- <i class="fas fa-star fa-fw"></i> --></div><div style="clear: both;" class_name="clear_thong-bao-moi-thau-217"></div></div><div class="c-thong-bao-moi-thau-221" class_name="thong-bao-moi-thau-221"><div class="input-text     c-thong-bao-moi-thau-222" class_name="thong-bao-moi-thau-222">Địa bàn:</div><div class="input-text       c-thong-bao-moi-thau-223" class_name="thong-bao-moi-thau-223" zn-group="listBidPackages">' . $v2['a1-zn-LOCATION'] . '</div><div style="clear: both;" class_name="clear_thong-bao-moi-thau-221"></div></div><div class="c-thong-bao-moi-thau-224" class_name="thong-bao-moi-thau-224"><div class="input-text        c-thong-bao-moi-thau-225" class_name="thong-bao-moi-thau-225" zn-group="listBidPackages">';
                        $getData = $FunCode_thongbaomoithau225($v2);
                        if (isset($getData)) {
                            $html .= $getData;
                        } else {
                            $html .= '10/4/2019 -&nbsp;<span style="font-size: 12px;">12:04</span>';
                        }
                        $html .= '</div><div class="c-thong-bao-moi-thau-226" class_name="thong-bao-moi-thau-226"><img src="/zeanniTheme/img/0.386523001559901616.png" class="c-thong-bao-moi-thau-227" class_name="thong-bao-moi-thau-227"><div style="clear: both;" class_name="clear_thong-bao-moi-thau-226"></div></div><div class="input-text          c-thong-bao-moi-thau-228" class_name="thong-bao-moi-thau-228" zn-group="listBidPackages">';
                        $getData = $FunCode_thongbaomoithau228($v2);
                        if (isset($getData)) {
                            $html .= $getData;
                        } else {
                            $html .= '10/5/2019 -&nbsp;<span style="font-size: 12px;">12:04</span>';
                        }
                        $html .= '</div><div style="clear: both;" class_name="clear_thong-bao-moi-thau-224"></div></div><div class="c-thong-bao-moi-thau-229" class_name="thong-bao-moi-thau-229"><div class="input-text        c-thong-bao-moi-thau-230" class_name="thong-bao-moi-thau-230">Giá:</div><div class="input-text          c-thong-bao-moi-thau-231" class_name="thong-bao-moi-thau-231" zn-group="listBidPackages">';
                        $getData = $FunCode_thongbaomoithau231($v2);
                        if (isset($getData)) {
                            $html .= $getData;
                        } else {
                            $html .= '583,000,000 VNĐ';
                        }
                        $html .= '</div><div style="clear: both;" class_name="clear_thong-bao-moi-thau-229"></div></div><div class="c-thong-bao-moi-thau-232" class_name="thong-bao-moi-thau-232" overlay="1" zn-group="listBidPackages">';
                        $getData = $FunCode_thongbaomoithau232($v2);
                        if (isset($getData)) {
                            $html .= $getData;
                        } else {
                            $html .= '<div class="c-thong-bao-moi-thau-260" class_name="thong-bao-moi-thau-260"><div class="input-text         c-thong-bao-moi-thau-261" class_name="thong-bao-moi-thau-261">Điện tử</div><div style="clear: both;" class_name="clear_thong-bao-moi-thau-260"></div></div><div style="clear: both;" class_name="clear_thong-bao-moi-thau-232"></div>';
                        }
                        $html .= '</div><div class="c-thong-bao-moi-thau-258" class_name="thong-bao-moi-thau-258" overlay="1" zn-group="listBidPackages">';
                        $getData = $FunCode_thongbaomoithau258($v2);
                        if (isset($getData)) {
                            $html .= $getData;
                        } else {
                            $html .= '<div class="c-thong-bao-moi-thau-262" class_name="thong-bao-moi-thau-262"><div class="input-text          c-thong-bao-moi-thau-263" class_name="thong-bao-moi-thau-263">Trực tiếp</div><div style="clear: both;" class_name="clear_thong-bao-moi-thau-262"></div></div><div style="clear: both;" class_name="clear_thong-bao-moi-thau-258"></div>';
                        }
                        $html .= '</div><div style="clear: both;" class_name="clear_thong-bao-moi-thau-210"></div></div>';
                    }
                }
                echo $html; ?>
                <div style="clear: both;" class_name="clear_thong-bao-moi-thau-56"></div>
            </div>
            <div style="clear: both; opacity: 1; left: -5200%;" class_name="clear_thong-bao-moi-thau-8"></div>
        </div>
        <div style="clear: both;" class_name="clear_thong-bao-moi-thau-4"></div>
    </div>
    <div class="c-thong-bao-moi-thau-114" class_name="thong-bao-moi-thau-114" includepage="footer-3">
        <div style="clear: both;" class_name="clear_thong-bao-moi-thau-114"></div>
        <div class="c-footer-3-2" class_name="footer-3-2" footer_app="1"><a
                    href="/tra-cuu?tab=1&BUSSINESS_FIELD=Hàng hóa" class="c-footer-3-44" class_name="footer-3-44">
                <div class="c-footer-3-4" class_name="footer-3-4">
                    <div class="c-footer-3-5" class_name="footer-3-5"><img
                                src="/zeanniTheme/img/0.970612001561415938.png" class="c-footer-3-48"
                                class_name="footer-3-48">
                        <div style="clear: both;" class_name="clear_footer-3-5"></div>
                    </div>
                    <div class="input-text   c-footer-3-7" class_name="footer-3-7">Hàng hóa</div>
                    <div style="clear: both;" class_name="clear_footer-3-4"></div>
                </div>
            </a><a href="/tra-cuu?tab=0&BUSSINESS_FIELD=Xây lắp" class="c-footer-3-43" class_name="footer-3-43">
                <div class="c-footer-3-29" class_name="footer-3-29">
                    <div class="c-footer-3-30" class_name="footer-3-30"><img
                                src="/zeanniTheme/img/0.614113001561415960.png" class="c-footer-3-49"
                                class_name="footer-3-49">
                        <div style="clear: both;" class_name="clear_footer-3-30"></div>
                    </div>
                    <div class="input-text    c-footer-3-32" class_name="footer-3-32">Xây lắp</div>
                    <div style="clear: both;" class_name="clear_footer-3-29"></div>
                </div>
            </a><a href="/tra-cuu?tab=0&BUSSINESS_FIELD=Tư vấn" class="c-footer-3-45" class_name="footer-3-45">
                <div class="c-footer-3-25" class_name="footer-3-25">
                    <div class="c-footer-3-26" class_name="footer-3-26"><img
                                src="/zeanniTheme/img/0.463149001561415982.png" class="c-footer-3-50"
                                class_name="footer-3-50">
                        <div style="clear: both;" class_name="clear_footer-3-26"></div>
                    </div>
                    <div class="input-text    c-footer-3-28" class_name="footer-3-28">Tư vấn</div>
                    <div style="clear: both;" class_name="clear_footer-3-25"></div>
                </div>
            </a><a href="/tra-cuu?tab=0&BUSSINESS_FIELD=Phi tư vấn" class="c-footer-3-46" class_name="footer-3-46">
                <div class="c-footer-3-21" class_name="footer-3-21">
                    <div class="c-footer-3-22" class_name="footer-3-22"><img
                                src="/zeanniTheme/img/0.391839001561416003.png" class="c-footer-3-51"
                                class_name="footer-3-51">
                        <div style="clear: both;" class_name="clear_footer-3-22"></div>
                    </div>
                    <div class="input-text    c-footer-3-24" class_name="footer-3-24">Phi tư vấn</div>
                    <div style="clear: both;" class_name="clear_footer-3-21"></div>
                </div>
            </a><a href="/tra-cuu?tab=0&BUSSINESS_FIELD=Hỗn hợp" class="c-footer-3-47" class_name="footer-3-47">
                <div class="c-footer-3-17" class_name="footer-3-17">
                    <div class="c-footer-3-18" class_name="footer-3-18"><img
                                src="/zeanniTheme/img/0.835742001561416021.png" class="c-footer-3-52"
                                class_name="footer-3-52">
                        <div style="clear: both;" class_name="clear_footer-3-18"></div>
                    </div>
                    <div class="input-text    c-footer-3-20" class_name="footer-3-20">Hỗn hợp</div>
                    <div style="clear: both;" class_name="clear_footer-3-17"></div>
                </div>
            </a>
            <div style="clear: both;" class_name="clear_footer-3-2"></div>
        </div>
        <div style="clear: both;" class_name="clear_content-layer"></div>
        <div style="clear: both;" class_name="clear_thong-bao-moi-thau-114"></div>
    </div>
    <div style="clear: both;" class_name="clear_thong-bao-moi-thau-2"></div>
</div>
<div style="clear: both;" class_name="clear_content-layer"></div>
<script id="jsEventAction" type="application/javascript">if (typeof FunCongfig == "undefined") {
        var FunCongfig = {};
    }
    FunCongfig["thong-bao-moi-thau"] = [{
        "element1": ".c-thong-bao-moi-thau-5",
        "element2": [".c-thong-bao-moi-thau-8"],
        "animationType": "",
        "callBack": [""],
        "callBack2": [],
        "actionType": "setupTab"
    }];</script>
<script> zLh94 = {};
    zLd50 = {};
    /*thiet lap gia tri ui sau khi cap nhat bien client*/
    $.each($_systemCookie, function (i, v) {
        try {
            $_systemCookie[i] = JSON.parse(v);
        } catch (e) {
        }
    });
    zLk328();
    /*end: thiet lap gia tri ui sau khi cap nhat bien client*/
    zLg75();
    zLn266 = function (selectorParent) {
        selectorParent = selectorParent || "#content";
    };
    zLm174();
    zLn266();
    zLd84();
    zLa111();
    zLa192();
    zLf79();
    $('[social_action=shareF]').attr('onclick', 'zLb132();');
    $('[social_action=shareG]').off('click').on('click', function () {
        zLn293();
    });
    $('[social_action=shareT]').off('click').on('click', function () {
        zLb276();
    });</script>
</body>
</html>