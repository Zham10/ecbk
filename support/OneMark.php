<?php

    $from_id = $_REQUEST['mssv1'];
    $to_id  =$_REQUEST['mssv2'];
    //echo $from_id.'<br>';
    //echo $to_id.'<br>';
    
    for($i = $from_id; $i<=$to_id; $i++){
        $url = 'http://127.0.0.1/exer/crawling.php?msv='.$i;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($ch);
        echo $result;
    }
    
    
?>
