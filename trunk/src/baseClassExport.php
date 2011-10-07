<?php

/**
 * @author Tuan Anh
 * @copyright 2011
 */
    include 'db.php';
    header('Content-Type: text/html; charset=UTF-8');
    
    $sid = $_REQUEST['sid'];
    $resul_arr=array();
    connect_db();
    
    $query = 'SELECT term_name FROM score_term WHERE student_id="'.$sid.'" GROUP BY term_name';
    $terms= mysql_query($query) or die(mysql_error());
    $term_results = array();
    $term_result = array();
    while($term = mysql_fetch_array($terms)){
        $query = 'SELECT subject_id, mid_term, end_term, `avg`, `group` FROM score_term WHERE student_id="'.$sid.'" AND term_name = "'.$term['term_name'].'"';
        //echo $query;
        $subjects = mysql_query($query);
        $temp = array();
        $tenhk;
        while($subject = mysql_fetch_array($subjects)){
            $tenhk = $term['term_name'];
            $query = 'SELECT * FROM subject WHERE subject_id= "'.$subject['subject_id'].'"';
            //echo $query;
            $subject_details = mysql_query($query);
            $subject_detail = mysql_fetch_array($subject_details);
            //var_dump($subject_detail);
            $subject['subject_name']= $subject_detail['subject_name'];
            $subject['credit']  =$subject_detail['credit'];
            $temp[$subject['subject_id']] = $subject;
            //$temp[$subject['subject_id']] = $subject['subject_id'];
            //var_dump($temp);
        }
        
        $temp2 = array();
        $query = 'SELECT num_cre_reg, num_cre_pass,avg_grade_term, num_cre_all,avg_grade_all FROM term_stat WHERE student_id="'.$sid.'" AND term_name = "'.$term['term_name'].'"';
        //echo $query;
        $stats = mysql_query($query);
        $stat = mysql_fetch_array($stats);
        $temp2['num_cre_reg'] = $stat['num_cre_reg'];
        $temp2['num_cre_pass'] = $stat['num_cre_pass'];
        $temp2['avg_grade_term'] = $stat['avg_grade_term'];
        $temp2['num_cre_all'] = $stat['num_cre_all'];
        $temp2['avg_grade_all'] = $stat['avg_grade_all'];
        
        $term_result[$term['term_name']]= array('detail'=>$temp, 'stat' =>$temp2,'ten_hk' =>$tenhk);
        //var_dump($term_result);
        
        
    }
    //var_dump($term_result);
    
    $query = 'SELECT student_id, student_name, DATE_FORMAT(birthday,"%d %M %Y" ) FROM student WHERE student_id="'.$sid.'"';
    $rs = mysql_query($query);
    $r = mysql_fetch_array($rs);
      
?>