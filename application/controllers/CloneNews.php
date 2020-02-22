<?php
defined("BASEPATH") or exit("No direct script access allowed");
include(PATH_STSTEM.'/simplehtmldom/simple_html_dom.php');
class CloneNews extends CI_Controller
{
    private $base_url;
    function __construct()
    {
        parent::__construct();
        $this->base_url = base_url();
    }
    private function getDom($url){
        $ch = curl_init();
        $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSLVERSION,CURL_SSLVERSION_DEFAULT);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $html= str_get_html(curl_exec ($ch));
        $error = curl_error($ch); 
        curl_close ($ch);

        return $html;
    }
    public function cloneList(){
        $sql = "select *
        from AW_LOG_CRAWL_NEWS a1
        where a1.status = 0 and rownum <2";
        $query = $this->db->query($sql);
        $row =  $query->row_array();
        if(empty($row)){
            $this->db->update('AW_LOG_CRAWL_NEWS',array('STATUS'=>0));
            return;
        }
        
        $this->db->where('ID',$row['ID']);
        $this->db->update('AW_LOG_CRAWL_NEWS',array('STATUS'=>1));

        $html = $this->getDom($row['START_LINK']);
        $arrSelect = array();
        $IMG='';
        foreach($html->find('.cat-news-list-block .news-md-item a.list-tin-tuc') as $e) {
            $url = strip_tags($e->href );
            $title = trim(strip_tags($e->innertext));
            if($url==$row['LAST_URL_NEWS'] || $title == $row['LAST_TITLE']){
                break;
            }

            $arrSelect['LAST_URL_NEWS'] = $url;
            $arrSelect['LAST_TITLE'] = $title;
            $IMG = @trim($this->db->escape_str($html->find('.news-md-item a img.img-responsive',0)->src));
            if(!empty($IMG)){
                $IMG = 'http://muasamcong.mpi.gov.vn'.$IMG;
            }
        }

        if(!empty($arrSelect)){
            $this->db->where('ID',$row['ID']);
            $this->db->update('AW_LOG_CRAWL_NEWS',$arrSelect);

            $html = $this->getDom($row['WEBSITE'].$arrSelect['LAST_URL_NEWS']);
            // print_r($arrInsert);
            // echo $row['WEBSITE'].$arrSelect['LAST_URL_NEWS'];
            $arrInsert = array();
            $arrInsert['SOURCE_URL']=$row['WEBSITE'].$arrSelect['LAST_URL_NEWS'];
            $arrInsert['TITLE'] = @trim($this->db->escape_str($html->find('#content-tin-tuc .the-title',0)->plaintext));
            $arrInsert['SHORT_DESCRIPTION'] = @trim($this->db->escape_str($html->find('#content-tin-tuc p',1)->plaintext));
            $arrInsert['IMG'] = @trim($this->db->escape_str($html->find('#content-tin-tuc p a img',0)->src));
            if(empty($arrInsert['IMG']) && !empty($IMG)){
                $arrInsert['IMG'] = $IMG;
            }
            $arrInsert['DATE_SUBMITTED'] = @trim($this->db->escape_str($html->find('#content-tin-tuc .new-datetime',0)->plaintext));
            $arrInsert['POST'] = array();
            $i=0;$content='';
            $a;
            foreach($html->find('#content-tin-tuc p') as $e) {
                if($i>0)
                {
                    $arrInsert['POST'][]=$content;
                    $content = $e->outertext;
                    $a = $e;
                }
                $i++;
            }
            $arrInsert['POST'] = $this->db->escape_str(trim(join($arrInsert['POST'],' ')));
            if($a){
                // $arrInsert['EDITOR']=@trim(($html->find('#content-tin-tuc p strong',0)->plaintext.''));
                $arrInsert['EDITOR']=@trim($this->db->escape_str($a->prev_sibling()->plaintext));    
            }
            
            $arrInsert['SOURCE_URL'] = substr($arrInsert['SOURCE_URL'],0,400);
            $arrInsert['TITLE'] = substr($arrInsert['TITLE'],0,400);
            $arrInsert['SHORT_DESCRIPTION'] = substr($arrInsert['SHORT_DESCRIPTION'],0,1500);
            $arrInsert['IMG'] = substr($arrInsert['IMG'],0,400);
            $arrInsert['DATE_SUBMITTED'] = substr($arrInsert['DATE_SUBMITTED'],0,40);
            $arrInsert['EDITOR'] = substr($arrInsert['EDITOR'],0,80);
            // print_r($arrInsert);
            $sql = 'Insert into NEWS(SOURCE_URL,TITLE,SHORT_DESCRIPTION,IMG,DATE_SUBMITTED,EDITOR,POST)
            VALUES (\''.$arrInsert['SOURCE_URL'].'\'
            ,\''.$arrInsert['TITLE'].'\'
            ,\''.$arrInsert['SHORT_DESCRIPTION'].'\'
            ,\''.$arrInsert['IMG'].'\'
            ,\''.$arrInsert['DATE_SUBMITTED'].'\'
            ,\''.$arrInsert['EDITOR'].'\'
            ,TO_CLOB(\''.substr($arrInsert['POST'],0,3000).'\')
            || TO_CLOB(\''.substr($arrInsert['POST'],3001,3000).'\')
            || TO_CLOB(\''.substr($arrInsert['POST'],6001,3000).'\')
            || TO_CLOB(\''.substr($arrInsert['POST'],9001,3000).'\')
            )';
            $this->db->query($sql);

            $sql = "select ID
            from NEWS a
            where a.SOURCE_URL = '".$arrInsert['SOURCE_URL']."'";
            $query = $this->db->query($sql);
            $row=$query->row_array();
            // echo $sql;
            // print_r($row);
            if(!empty($row)){
                $this->db->insert_batch('AW_NEWS_KEYTAG',array(
                    array(
                        'NEWS_ID'=>$row['ID'],
                        'KEY_TAG_ID'=>1
                    ),
                    array(
                        'NEWS_ID'=>$row['ID'],
                        'KEY_TAG_ID'=>2
                    ),
                    array(
                        'NEWS_ID'=>$row['ID'],
                        'KEY_TAG_ID'=>3
                    )
                ));
            }
            
        }
    }
    function index(){

        $html = $this->getDom('http://muasamcong.mpi.gov.vn/tin-tuc/3');
        $arrSelect = array();
        $IMG='';
        foreach($html->find('.cat-news-list-block .news-md-item a.list-tin-tuc') as $e) {
            // if()
            $url = strip_tags($e->href );
            $title = trim(strip_tags($e->innertext));
            $arrSelect['LAST_URL_NEWS'] = $url;
            $arrSelect['LAST_TITLE'] = $title;
            $IMG = @trim($this->db->escape_str($html->find('.news-md-item a img.img-responsive',0)->src));
            $IMG = 'http://muasamcong.mpi.gov.vn'.$IMG;
            echo $IMG;
            echo $title;
            break;
        }
        return;
        /**
         * - clone 15p 1 lan.
         * - b1: clone list. 
         *      lap tu 0 -> id gan nhat (hoac trung voi ten bai gan nhat) thi dung.
         * - b1.1: log lai id va ten bai clone moi nhat
         * - b2: clone mang cac tin moi o tren. lay content -> insert db
         * - log cloneNews
         *      ID, LAST_ID_NEWS, LAST_TITLE,WEBSITE
         */


        // example of how to use basic selector to retrieve HTML contents

        
        // get DOM from URL or file
        $url='http://muasamcong.mpi.gov.vn/article/detail?id=p55323';
        $html = $this->getDom($url);

        echo '<b>Title</b><br/>';
        echo $html->find('#content-tin-tuc .the-title',0)->innertext . '<br>';

        echo '<b>Time push</b><br/>';
        foreach($html->find('#content-tin-tuc .new-datetime') as $e) 
            echo $e->innertext . '<br>';

        echo '<b>Short post</b><br/>';
        echo $html->find('#content-tin-tuc p',1)->innertext . '<br>';

        echo '<b>Anh</b><br/>';
            echo '<img width="200px" src="'.$html->find('#content-tin-tuc p a img',0)->src .'"/><br>';

        echo '<b>post</b><br/>';
        $i=0;
        foreach($html->find('#content-tin-tuc p') as $e) {
            if($i>3)
            echo '<p>'.$e->innertext .'</p>';
            
            $i++;
        }
            

        // // find all image
        // foreach($html->find('img') as $e)
        //     echo $e->src . '<br>';

        // // find all image with full tag
        // foreach($html->find('img') as $e)
        //     echo $e->outertext . '<br>';

        // // find all div tags with id=gbar
        // foreach($html->find('div#gbar') as $e)
        //     echo $e->innertext . '<br>';

        // // find all span tags with class=gb1
        // foreach($html->find('span.gb1') as $e)
        //     echo $e->outertext . '<br>';

        // // find all td tags with attribite align=center
        // foreach($html->find('td[align=center]') as $e)
        //     echo $e->innertext . '<br>';
            
        // // extract text from table
        // echo $html->find('td[align="center"]', 1)->plaintext.'<br><hr>';

        // // extract text from HTML
        // echo $html->plaintext;

    }
}