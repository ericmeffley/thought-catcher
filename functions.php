<?php
    function GenerateToken(){
    $random = "";
    $randomString = "";

    for ($i=0; $i<7; $i++){

        $random = rand(65,90);
        $random = chr($random);
        $randomString .= $random; 

    }
    for ($i=0; $i<7; $i++){

        $random = rand(0,9);
        $randomString .= $random; 

    }
    for ($i=0; $i<8; $i++){

        $random = rand(97,122);
        $random = chr($random);
        $randomString .= $random; 

    }
    $randomString = str_shuffle($randomString);
    //echo $randomString;
    return $randomString;
}

?>