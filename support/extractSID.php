<?php

/**
 * @author Tuan Anh
 * @copyright 2011
 */
    $fileRead = 'ts2008.txt';
    $fr = fopen($fileRead,'r');
    $fileWrite = 'kq_'.$fileRead;
    $fw = fopen($fileWrite,'w');
    while(!feof($fr)){
        $data = fgets($fr);
        
        $mssv = substr($data,-10);
        echo $mssv;
        $day = substr($data,53,6);
        echo $day;
        fwrite($fw,$day);
        fwrite($fw,$mssv);
        
    }
    fclose($fr);
    fclose($fw);

?>