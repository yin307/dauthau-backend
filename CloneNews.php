<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<?php
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
include('./simplehtmldom/simple_html_dom.php');
 
// get DOM from URL or file
// $html = file_get_html('http://muasamcong.mpi.gov.vn/article/detail?id=p55323');
$url='http://muasamcong.mpi.gov.vn/article/detail?id=p55323';
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
        // print_r($webcontent);
// find all link
echo '<b>Title</b><br/>';
foreach($html->find('#content-tin-tuc .the-title') as $e) 
    echo $e->innertext . '<br>';

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
?>