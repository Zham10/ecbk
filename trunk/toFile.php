<?php

/**
 * @author Tuan Anh
 * @copyright 2011
 */
    include 'crawling.php';
    
    function writeUTF8File($filename,$content) { 
        $f=fopen($filename,"w"); 
        # Now UTF-8 - Add byte order mark 
        fwrite($f, pack("CCC",0xef,0xbb,0xbf)); 
        fwrite($f,$content); 
        fclose($f); 
    } 
    
    $fileName = $_REQUEST['msv'].'.sql';
    //$filepath = 'file\\';
    //echo $filepath;
    $fileHandle = fopen($fileName,'w') or die('cant open file');
    
    //insert name and student_id to student table
    $str = 'INSERT INTO student VALUES ('.$id.', '.$result[0].');';
    fwrite($fileHandle,$str."\n");
    
    //insert each term
    for($i=1; $i<count($result);$i++){
        //echo HK
        fwrite($fileHandle, '/*======================'.$result[$i]['hk'].'======================*/'."\n");
        $j = 0;
        $str = '';
        $count = (count($result[$i])-7);
        //echo 'count'.$count;
        while($j<$count){
            //insert subject_id, subject_name, credit
            $str = 'INSERT INTO subject VALUES ('.$result[$i][$j].','.$result[$i][$j+1].','.$result[$i][$j+3].');';
            fwrite($fileHandle,$str."\n");
            //echo $str;
            //insert mid_term, end_term, avg
            $str = 'INSERT INTO score_term VALUES ('.$id.', '.$result[$i]['hk'].','.$result[$i][$j].',`'.$result[$i][$j+4].'`,'.$result[$i][$j+5].','.$result[$i][$j+6].');';  
            fwrite($fileHandle,$str."\n");
            $j+=7;          
        }
        
        //insert into term_stat
        //$str .= 'INSERT INTO term_stat VALUES ('.$result[$i]['hk'].' ,'.$id.' ,'.$result[$i]['sum_credit_reg_term'].' ,'.$result[$i]['sum_credit_all_term'].' ,'.$result[$i]['avg_term'].' ,'.$result[$i]['sum_credit'].' ,'.$result[$i]['avg_all'].');';
            echo $str;
        fwrite($fileHandle,$str."\n");
    }
    
    fclose($fileHandle);
    
    echo '<a href = '.$fileName.'>file here</a>';
?>