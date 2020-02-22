<?php
class Lib_ZN{
    static function translit_characters($str){
        $str = preg_replace("/̣|́/", "",$str);
        $str = preg_replace("/(Α|Ά|А|À|Á|Â|Ã|Ä|Å|Ǻ|Ā|Ă|Ą|Ǎ|Ạ|Ả|Ã|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
        $str = preg_replace("/(α|ά|а|à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª|ạ|ả|ã|ầ|ấ|ậ|ẩ|ẫ|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
        $str = preg_replace("/(Β|Б)/", "B", $str);
        $str = preg_replace("/(β|б)/", "b", $str);
        $str = preg_replace("/(Ç|Ć|Ĉ|Ċ|Č)/", "C", $str);
        $str = preg_replace("/(ç|ć|ĉ|ċ|č)/", "c", $str);
        $str = preg_replace("/(Δ|Д|Ð|Ď|Đ)/", "D", $str);
        $str = preg_replace("/(δ|д|ð|ď|đ)/", "d", $str);
        $str = preg_replace("/(Ε|Έ|Е|Э|Є|È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě|Ẹ|Ẻ|Ẽ|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
        $str = preg_replace("/(ε|έ|е|э|є|è|é|ê|ë|ē|ĕ|ė|ę|ě|ẹ|ẻ|ẽ|ề|ế|ệ|ể|ễ)/", "e", $str);
        $str = preg_replace("/(Φ|Ф)/", "F", $str);
        $str = preg_replace("/(φ|ф|ƒ)/", "f", $str);
        $str = preg_replace("/(Γ|Г|Ĝ|Ğ|Ġ|Ģ)/", "G", $str);
        $str = preg_replace("/(γ|г|ĝ|ğ|ġ|ģ)/", "g", $str);
        $str = preg_replace("/(Х|Ĥ|Ħ)/", "H", $str);
        $str = preg_replace("/(х|ĥ|ħ)/", "h", $str);
        $str = preg_replace("/(Η|Ή|Ι|Ί|И|Ы|І|Ї|Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ|Ị|Ỉ|Ĩ)/", "I", $str);
        $str = preg_replace("/(η|ή|ι|ί|и|ы|і|ї|ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı|ị|ỉ|ĩ)/", "i", $str);
        $str = preg_replace("/(Ĵ)/", "J", $str);
        $str = preg_replace("/(ĵ)/", "j", $str);
        $str = preg_replace("/(Κ|К|Ķ)/", "K", $str);
        $str = preg_replace("/(κ|к|ķ)/", "k", $str);
        $str = preg_replace("/(Λ|Л|Ĺ|Ļ|Ľ|Ŀ|Ł)/", "L", $str);
        $str = preg_replace("/(λ|л|ĺ|ļ|ľ|ŀ|ł)/", "l", $str);
        $str = preg_replace("/(Μ|М)/", "M", $str);
        $str = preg_replace("/(μ|м)/", "m", $str);
        $str = preg_replace("/(Ν|Н|Ñ|Ń|Ņ|Ň)/", "N", $str);
        $str = preg_replace("/(ν|н|ñ|ń|ņ|ň|ŉ)/", "n", $str);
        $str = preg_replace("/(Ο|Ό|О|Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ|Ọ|Ỏ|Õ|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
        $str = preg_replace("/(ο|ό|о|ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º|ọ|ỏ|õ|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
        $str = preg_replace("/(Π|П)/", "P", $str);
        $str = preg_replace("/(π|п)/", "p", $str);
        $str = preg_replace("/(Ρ|Р|Ŕ|Ŗ|Ř)/", "R", $str);
        $str = preg_replace("/(ρ|р|ŕ|ŗ|ř)/", "r", $str);
        $str = preg_replace("/(Σ|С|Ś|Ŝ|Ş|Š)/", "S", $str);
        $str = preg_replace("/(σ|ς|с|ś|ŝ|ş|š|ſ)/", "s", $str);
        $str = preg_replace("/(Τ|Т|Ţ|Ť|Ŧ)/", "T", $str);
        $str = preg_replace("/(τ|т|ţ|ť|ŧ)/", "t", $str);
        $str = preg_replace("/(У|Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ|Ụ|Ủ|Ũ|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
        $str = preg_replace("/(у|ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ|ụ|ủ|ũ|ừ|ứ|ự|ử|ữ)/", "u", $str);
        $str = preg_replace("/(В)/", "V", $str);
        $str = preg_replace("/(в)/", "v", $str);
        $str = preg_replace("/(Ω|Ώ|Ŵ)/", "W", $str);
        $str = preg_replace("/(ω|ώ|ŵ)/", "w", $str);
        $str = preg_replace("/(Χ)/", "X", $str);
        $str = preg_replace("/(χ)/", "x", $str);
        $str = preg_replace("/(Υ|Ύ|Ψ|Й|Ý|Ÿ|Ŷ|Ỳ|Ỵ|Ỷ|Ỹ)/", "Y", $str);
        $str = preg_replace("/(υ|ύ|ψ|й|ý|ÿ|ŷ|ỳ|ỵ|ỷ|ỹ)/", "y", $str);
        $str = preg_replace("/(Ζ|З|Ź|Ż|Ž)/", "Z", $str);
        $str = preg_replace("/(ζ|з|ź|ż|ž)/", "z", $str);
        $str = preg_replace("/(Θ)/", "Th", $str);
        $str = preg_replace("/(θ)/", "th", $str);
        $str = preg_replace("/(Ξ)/", "Ks", $str);
        $str = preg_replace("/(ξ)/", "ks", $str);
        $str = preg_replace("/(Ё)/", "Yo", $str);
        $str = preg_replace("/(ё)/", "yo", $str);
        $str = preg_replace("/(Ж)/", "Zh", $str);
        $str = preg_replace("/(ж)/", "zh", $str);
        $str = preg_replace("/(Ц)/", "Ts", $str);
        $str = preg_replace("/(ц)/", "ts", $str);
        $str = preg_replace("/(Ч)/", "Ch", $str);
        $str = preg_replace("/(ч)/", "ch", $str);
        $str = preg_replace("/(Ш)/", "Sh", $str);
        $str = preg_replace("/(ш)/", "sh", $str);
        $str = preg_replace("/(Щ)/", "Sch", $str);
        $str = preg_replace("/(щ)/", "sch", $str);
        $str = preg_replace("/(Ь|Ъ)/", "", $str);
        $str = preg_replace("/(ь|ъ)/", "", $str);
        $str = preg_replace("/(Ю)/", "Yu", $str);
        $str = preg_replace("/(ю)/", "yu", $str);
        $str = preg_replace("/(Я)/", "Ya", $str);
        $str = preg_replace("/(я)/", "ya", $str);
        $str = preg_replace("/(Æ|Ǽ)/", "AE", $str);
        $str = preg_replace("/(Ä)/", "Ae", $str);
        $str = preg_replace("/(ä|æ|ǽ)/", "ae", $str);
        $str = preg_replace("/(Œ)/", "OE", $str);
        $str = preg_replace("/(Ö)/", "Oe", $str);
        $str = preg_replace("/(ö|œ)/", "oe", $str);
        $str = preg_replace("/(Ü)/", "Ue", $str);
        $str = preg_replace("/(ü)/", "ue", $str);
        $str = preg_replace("/(Ĳ)/", "IJ", $str);
        $str = preg_replace("/(ĳ)/", "ij", $str);
        $str = preg_replace("/(ß)/", "ss", $str);
        return $str;
    }
    static function exploderText($str){
        if(!$str)
            return [];
        $str = preg_replace("/(\.|\,|\;|\:|\(|\)|\{|\}|\+|\-|\*|\/|\||\\|\!|\"|\')/", "", $str);
        $str = strtolower($str);
        $str1 = explode(' ',$str);
        $str = $this->translit_characters($str);
        $str = explode(' ',$str);
        $str1 = array_merge($str1,$str);
        return array_unique($str1);
    }
    static function find($vl, $arr)
    {
        $GLOBALS["sdfsd23432dwef3fcef"] = $vl;
        return array_filter($arr, function ($var) {
            return ($var == $GLOBALS["sdfsd23432dwef3fcef"]);
        });
    }

    static function numberFormat($number, $decimals = null, $dec_point = ".", $thousands_sep = ",")
    {
        if(empty($number)){
            return $number;
        }
        $number = (string)$number;
        $b = explode(".", $number);
        return number_format($b[0], "0", $dec_point, $thousands_sep) . ((empty($b[1]) || (int)$decimals === 0) ? "" : $dec_point . (($decimals === null) ? $b[1] : substr($b[1], 0, $decimals)));
    }

    static function sum($arr = array(), $key = "")
    {
        $s = 0;
        if (empty($key)) {
            $s = array_sum($arr);
        } else {
            foreach ($arr as $i => $v) {
                $s = $s + (empty($v[$key]) ? 0 : (float)$v[$key]);
            };
        }
        return $s;
    }
    static function formatDate($date,$format){
        $date=date_create($date);
        return date_format($date,$format);
    }
}
