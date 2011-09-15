<?php

/**
 * @author Tuan Anh
 * @copyright 2011
 */
 
 function toFile($result,$id,$bd,$fn){
    require_once '../src/db.php';
    $con = connect_db();
    $fh = fopen($fn,'a') or die('cant open file');
    
    //check if $result empty
    if($result==''){
        return;
    }
    
    //insert name and student_id to student table
    $str =  '';
    $str .= " /*".$stt."====================================' .$id.'-'.$result[0].'===============================*/"."\n";

    $str .= 'INSERT INTO student VALUES ("'.$id.'", "'.$result[0].'","'.$bd.'");'."\n";
    
    
    //insert each term
    for($i=1; $i<count($result);$i++){
        
        $str .= '/*======================'.$result[$i]['hk'].'======================*/'."\n";
        
        $j = 0;
        
        $count = (count($result[$i])-7);
        
        while($j<$count){
            //check if subject_id exits
            $subject_id = $result[$i][$j];
            $subject_name = $result[$i][$j+1];
            $subject_credit = $result[$i][$j+3];
            if(!check_exits($subject_id,'subject','subject_id')){
                //insert subject_id, subject_name, credit
                $str .= 'INSERT INTO subject VALUES ("'.$subject_id.'","'.$subject_name.'",'.$subject_credit.');'."\n";
                
            }
            
            //insert mid_term, end_term, avg
            $group = $result[$i][$j+2];
            $mid_grade = $result[$i][$j+4]=='---'?'NULL':$result[$i][$j+4];
            $end_grade = $result[$i][$j+5]=='---'?'NULL':$result[$i][$j+5];
            $avg_grade = $result[$i][$j+6]=='---'?'NULL':$result[$i][$j+6];
        
            $str .= 'INSERT INTO score_term VALUES ("'.$id.'", "'.$result[$i]['hk'].'","'.$result[$i][$j].'",'.$mid_grade.','.$end_grade.','.$avg_grade.',"'.$group.'");'."\n";  
            
            $j+=7;          
        }
        
        //insert into term_stat
        $sum_credit_reg_term =$result[$i]['sum_credit_reg_term']==''?'NULL':$result[$i]['sum_credit_reg_term'];
        $sum_credit_all_term = $result[$i]['sum_credit_all_term']==''?'NULL':$result[$i]['sum_credit_all_term'];
        $avg_term = $result[$i]['avg_term']==''?'NULL':$result[$i]['avg_term'];
        $sum_credit = $result[$i]['sum_credit']==''?'NULL':$result[$i]['sum_credit'];
        $avg_all = $result[$i]['avg_all']==''?'NULL':$result[$i]['avg_all'];
        $str .= 'INSERT INTO term_stat VALUES ("'.$result[$i]['hk'].'" ,"'.$id.'" ,'.$sum_credit_reg_term.' ,'.$sum_credit_all_term.' ,'.$avg_term.' ,'.$sum_credit.' ,'.$avg_all.');'."\n";
            
    }
    fwrite($fh,$str."\n");
    fclose($fh);
    close_db($con);
 }
?>