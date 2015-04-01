<?php

spl_autoload_register('_autoload');

function _autoload($className) {
    $fileName = "models/" . $className . '.php';
    include $fileName;
}

function debug($mas, $val) {
    echo "<pre>";
    print_r($mas);
    echo "</pre>";
    $val ? exit() : '';
}

function myHash($var) {
    $salt  = 'skr9';
    $salt2 = 'bnrg';
    $var = crypt(md5($var,$salt),$salt2);
    return $var;
}

function utf_win($s){ 
    $in=array("%26 ", "%u2116", "%20","%u0430","%u0431","%u0432","%u0433","%u0434","%u0435","%u0436","%u0437","%u0438","%u0439","%u043A","%u043B","%u043C","%u043D","%u043E","%u043F","%u0440","%u0441","%u0442","%u0443","%u0444","%u0445","%u0446","%u0447","%u0448","%u0449","%u044A","%u044B","%u044C","%u044D","%u044E","%u044F","%u0451","%u0410","%u0411","%u0412","%u0413","%u0414","%u0415","%u0416","%u0417","%u0418","%u0419","%u041A","%u041B","%u041C","%u041D","%u041E","%u041F","%u0420","%u0421","%u0422","%u0423","%u0424","%u0425","%u0426","%u0427","%u0428","%u0429","%u042A","%u042B","%u042C","%u042D","%u042E","%u042F","%u0401");

    $out=array("&", "№", " ","а","б","в","г","д","е","ж","з","и","й","к","л","м","н","о","п","р","с","т","у","ф","х","ц","ч","ш","щ","ъ","ы","ь","э","ю","я","ё","А","Б","В","Г","Д","Е","Ж","З","И","Й","К","Л","М","Н","О","П","Р","С","Т","У","Ф","Х","Ц","Ч","Ш","Щ","Ъ","Ы","Ь","Э","Ю","Я","Ё");

    $s=str_replace($in,$out,$s); 
    return $s; 
}  

function carveString($a, $b, $c) {
    $char_first = strpos($a, $b);
    $char_last = strpos($a, $c);
    $char_count = $char_last - $char_first;
    
    return $project_id = substr($a, ++$char_first, --$char_count);
}