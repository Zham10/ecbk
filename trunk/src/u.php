<?php

/**
 * @author Tuan Anh
 * @copyright 2011
 */

    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    include 'Spreadsheet/Excel/Writer.php';
    include 'db.php';
    header('Content-Type: text/html; charset=UTF-8');
    
    $sid = '50800935';
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
    
    $workbook = new Spreadsheet_Excel_Writer();
    $workbook->setVersion(8, 'utf-8');
    
    $worksheet1 = &$workbook->addWorksheet($sid);
    $worksheet1->setInputEncoding('utf-8');
    $worksheet1->hideScreenGridlines();
    $worksheet1->freezePanes(array(4,0));
    $worksheet1->setHeader('Truong Dai hoc Bach Khoa Tp.HCM');
    $worksheet1->setFooter(date('d/m/Y'));
    $worksheet1->centerVertically();
    
    $cur_row = 0;
    
    $bitmap = "../file/bk_hcm.bmp";
    $format = &$workbook->addFormat(array(
        'color'=>'black',
        //'FgColor' => 'blue',
        'bold'=> 1,
        'FontFamily'=> 'Arial',
        'align'=>'merge',
        'size'=> 15,
        'vAlign' => 'vcenter'
    ));
    $worksheet1->setRow(0,40);
    //$worksheet1->set
    $worksheet1->insertBitmap(0,0,$bitmap,0,0,0.7,0.7); $cur_row++;
    $worksheet1->write(0,1,'Truong Dai hoc Bach Khoa Tp. Ho Chi Minh',$format);
    $worksheet1->write(0,2,'',$format);
    $worksheet1->write(0,3,'',$format);
    $worksheet1->write(0,4,'',$format);
    $worksheet1->write(0,5,'',$format);
    $cur_row++;
    
    $header = &$workbook->addFormat();
    $header->setBold();
    $header->setColor('black');
    $header->setFgColor("grey");
    $header->setHAlign('center');
    
    
    
    $query = 'SELECT student_id, student_name, DATE_FORMAT(birthday,"%d %M %Y" ) FROM student WHERE student_id="'.$sid.'"';
    $rs = mysql_query($query);
    $r = mysql_fetch_array($rs);
    

    
    $title = utf8_encode('BANG DIEM SINH VIEN');
    $title_format = &$workbook->addFormat(array(
        'color'=>'white',
        'FgColor' => 'blue',
        'bold'=> 1,
        'FontFamily'=> 'Arial',
        'align'=>'merge',
        'size'=> 15
    ));
    $worksheet1->writeString($cur_row,0,$title,$title_format);
    $worksheet1->write($cur_row,1,'',$title_format);
    $worksheet1->write($cur_row,2,'',$title_format);
    $worksheet1->write($cur_row,3,'',$title_format);
    $worksheet1->write($cur_row,4,'',$title_format);
    $worksheet1->write($cur_row,5,'',$title_format);
    $cur_row += 1;
    
    
    $title_format = &$workbook->addFormat(array(
        'color'=>'red',
        //'FgColor' => 9,
        'bold'=> 1,
        'FontFamily'=> 'Arial',
        'align'=>'merge',
        'size'=> 25
    ));
    $title = $r['student_name'].'-'.$r['student_id'];
    $worksheet1->writeString($cur_row,0,$title,$title_format);
    $worksheet1->write($cur_row,1,'',$title_format);
    $worksheet1->write($cur_row,2,'',$title_format);
    $worksheet1->write($cur_row,3,'',$title_format);
    $worksheet1->write($cur_row,4,'',$title_format);
    $worksheet1->write($cur_row,5,'',$title_format);
    $cur_row += 1;
    
    foreach($term_result as $term_result_){
        //var_dump($term_result_);
        //echo $term_result_['ten_hk'];
        $format = &$workbook->addFormat(array(
            'bold'=> 1,
            'FontFamily'=> 'Arial',
            'align'=>'merge',
            'FgColor'=>'grey'
        ));
        $cur_row++;
        $name = 'HK '.substr($term_result_['ten_hk'],-1,1).' Nam hoc '.substr($term_result_['ten_hk'],0,4).'-'.substr($term_result_['ten_hk'],4,4);
        $worksheet1->write($cur_row,0,$name,$format);
        $worksheet1->write($cur_row,1,'',$format);
        $worksheet1->write($cur_row,2,'',$format);
        $worksheet1->write($cur_row,3,'',$format);
        $worksheet1->write($cur_row,4,'',$format);
        $worksheet1->write($cur_row,5,'',$format);
        
        
        $cur_row ++;
        $worksheet1->write($cur_row, 0, utf8_encode('Mã MH'), $header);
        $worksheet1->write($cur_row, 1, utf8_encode('Tên MH'), $header);
        $worksheet1->setColumn(1,1,30);
        $worksheet1->write($cur_row, 2, utf8_encode('So TC'), $header);
        $worksheet1->write($cur_row, 3, utf8_encode('Kiem tra'), $header);
        $worksheet1->write($cur_row, 4, utf8_encode('Thi'), $header);//
        $worksheet1->write($cur_row, 5, utf8_encode('TB'), $header);
        $cur_row ++;
        
        $h = &$workbook->addFormat();
        $h->setColor('black');
        foreach($term_result_['detail'] as $term_result__)
        {
            $worksheet1->write($cur_row, 0, " ".$term_result__['subject_id'], $h);
            $worksheet1->write($cur_row, 1, $term_result__['subject_name'], $h);
            $worksheet1->write($cur_row, 2, $term_result__['credit'], $h);
            $worksheet1->write($cur_row, 3, $term_result__['mid_term'], $h);
            $worksheet1->write($cur_row, 4, $term_result__['end_term'], $h);
            $worksheet1->write($cur_row, 5, $term_result__['avg'], $h);
            $cur_row +=1;
        }
        $title = 'Thong ke';

        $worksheet1->write($cur_row,0,$title,$format);
        $worksheet1->write($cur_row,1,'',$format);
        $worksheet1->write($cur_row,2,'',$format);
        $worksheet1->write($cur_row,3,'',$format);
        $worksheet1->write($cur_row,4,'',$format);
        $worksheet1->write($cur_row,5,'',$format);
        $cur_row++;
        
        
        $stat = array(
            'num_cre_reg' => 'So tin chi dang ki hoc ki',
            'num_cre_pass' => 'So tin chi tich luy hoc ki',
            'avg_grade_term' => 'Diem trung binh hoc ki',
            'num_cre_all' => 'Tong so tin chi tich luy',
            'avg_grade_all' => 'Diem trung binh tich luy'
        );
        $worksheet1->writeCol($cur_row,0,$stat);
        //var_dump($term_result_['stat']);
        $stat_detail = array(
            'num_cre_reg' => $term_result_['stat']['num_cre_reg'],
            'num_cre_pass' => $term_result_['stat']['num_cre_pass'],
            'avg_grade_term' => $term_result_['stat']['avg_grade_term'],
            'num_cre_all' => $term_result_['stat']['num_cre_all'],
            'avg_grade_all' => $term_result_['stat']['avg_grade_all']
        );
        $worksheet1->writeCol($cur_row,2,$stat_detail);
        
        $cur_row+=6;
        
    }
    
    
     $workbook->send($sid.'.xls');
 
    $workbook->close();
?>