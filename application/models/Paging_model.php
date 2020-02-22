<?php
class Paging_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    public function createPaging($count, $href='javascript:;',$display=20,$currentPage=1,$obj=array()){
        /*
        * tạo logic page. tạo link - tạo sự kiện click, view
        * $href = '/page name/$____pageIndex____?param=a'
        * $href.replace(/($____pageIndex____)/g,$i);
        *
        * chọn group
        * tao mẫu link href
        * chọn $currentPage và $display ($display có thể lấy từ group thiết lập limit, $currentPage cung co the tinh tu group
        * giong nhúng dữ liệu
        *
        * */

        $count = (int)$count;
        $currentPage = (int)$currentPage;
        $display = (int)$display;
        $str = '';

        if($count>$display){
            //tinh so trang can hien
            $pages=ceil($count / $display);// tính số trang

            $str .='<div class="box-pagination" style="">'.
                '<ul class="pagination clearfix">';
            if($currentPage>1){
                $str .="<li><a href='" . str_replace('$____pageIndex____',1,$href) . "'> << </a></li>";
                //$str .="<li><a href='" . str_replace('$____pageIndex____',($currentPage-1),$href)."'> < </a></li>";
            }
            if(1<=$currentPage && $currentPage<=2){
                $end=5;
                if($pages<5){
                    $end=$pages;
                }
                for($i=1;$i<=$end;$i++){
                    if($i!=$currentPage){
                        $str .="<li><a href='" . str_replace('$____pageIndex____',$i,$href) . "'> ".$i."</a></li>";
                    }else{
                        $str .="<li class='active'><a href='" . str_replace('$____pageIndex____',$i,$href) . "'> ".$i."</a></li>";
                    }
                }
            }
            else if($pages-2 <= $currentPage){
                $start=$pages-4;
                if($pages<5){
                    $start=1;
                }
                for($i=$start;$i<=$pages;$i++){
                    if($i!=$currentPage){
                        $str .="<li><a href='" . str_replace('$____pageIndex____',$i,$href) . "'> ".$i."</a> </li>";
                    }
                    else{
                        $str .="<li class='active'><a href='" . str_replace('$____pageIndex____',$i,$href) . "'> ".$i."</a></li>";
                    }
                }
            }
            else{
                $start=$currentPage-2;
                $end=$currentPage+2;
                for($i=$start;$i<=$end;$i++){
                    if($i!=$currentPage){
                        $str .="<li><a href='" . str_replace('$____pageIndex____',$i,$href) . "'> ".$i."</a></li>";
                    }
                    else{
                        $str .="<li class='active'><a href='" . str_replace('$____pageIndex____',$i,$href) . "'> ".$i." </a></li>";
                    }
                }
            }
            if($currentPage<$pages){
                //$str .="<li><a href='" . str_replace('$____pageIndex____',($currentPage+1),$href) . "'> > </a></li>";
                $str .="<li><a href='" . str_replace('$____pageIndex____',$pages,$href) . "'> >> </a></li>";
            }
            $str .='</ul>'.
                '</div>' .
                '<div style="clear: both"></div>'.
                '<style>' .
                '.box-pagination{text-align: center;}'.
                '.pagination {border-radius: 4px;display: inline-block;margin: 0;padding-left: 0; vertical-align: middle;}'.
                '.pagination > li {display: inline;}'.
                '.pagination > li:first-child > a, .pagination > li:first-child > span {border-bottom-left-radius: 4px;border-top-left-radius: 4px;margin-left: 0;}'.
                '.pagination > li:last-child > a, .pagination > li:last-child > span {border-bottom-right-radius: 4px;border-top-right-radius: 4px;}'.
                '.pagination > .active > a, .pagination > .active > a:focus, .pagination > .active > a:hover, .pagination > .active > span, .pagination > .active > span:focus, .pagination > .active > span:hover {background-color: #8cc152;border-color: #8cc152;color: #fff;}'.
                '.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {background-color: #428bca;border-color: #428bca;color: #fff;cursor: default;z-index: 2;}'.
                '.pagination > li > a, .pagination > li > span {background-color: #fff;border-color: #ccd1d9;color: #434a54;}'.
                '.pagination > li > a, .pagination > li > span {background-color: #fff;border: 1px solid #ddd;color: #428bca;float: left;line-height: 1.42857;margin-left: -1px;padding: 6px 3px;position: relative;text-decoration: none;min-width: 24px;}'.
                '.pagination > li > a, .pagination > li > span {background-color: #fff;border-color: #ccd1d9;color: #434a54;}'.
                '.pagination > li > a:focus, .pagination > li > a:hover, .pagination > li > span:focus, .pagination > li > span:hover {background-color: #ccd1d9;border-color: #ccd1d9;color: #fff;}'.
                '.pagination > .active > a, .pagination > .active > a:focus, .pagination > .active > a:hover, .pagination > .active > span, .pagination > .active > span:focus, .pagination > .active > span:hover {background-color: #8cc152;border-color: #8cc152;color: #fff;}'.
                '.pagination > .disabled > a, .pagination > .disabled > a:focus, .pagination > .disabled > a:hover, .pagination > .disabled > span, .pagination > .disabled > span:focus, .pagination > .disabled > span:hover {background-color: #fff;border-color: #ccd1d9;color: #e6e9ed;}' .
                '</style>';
        }
        return $str;
    }
}