<?php

/**
 * @author Tuan Anh
 * @copyright 2011
 */
    
    include 'baseClassExport.php';
    require_once('clsMsDocGenerator.php');
    //var_dump($term_result);
    
    function vnstr ($str){
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
			'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
       foreach($unicode as $nonUnicode=>$uni){
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
       }
		return $str;
    }
	
	$doc = new clsMsDocGenerator();
    
    $format = array(
		'text-align' 	=> 'center',
		'font-weight' 	=> 'bold',
		'font-size'		=> '18pt',
		'color'			=> 'blue'
    );
    //$doc->addImage('http://localhost/ec/file/bk_hcm.gif',70,70);
	$doc->addParagraph('<img src="http://localhost/ec/file/bk_hcm.gif"/>Truong Dai hoc Bach Khoa Tp. Ho Chi Minh', $format);
	
   $format = array(
		'text-align' 	=> 'center',
		'font-weight' 	=> 'bold',
		'font-size'		=> '18pt',
		'color'			=> 'blue'
    );
    $doc->addParagraph('BANG DIEM SINH VIEN',$format);
    
    $format = array(
		'text-align' 	=> 'center',
		'font-weight' 	=> 'bold',
		'font-size'		=> '20pt',
		'color'			=> 'red'
    );
	$doc->addParagraph(vnstr($r['student_name']).'-'.$r['student_id'],$format);

    
    foreach($term_result as $term_result_){
        $doc->newPage();
        
        $format = array(
    		'font-weight' 	=> 'bold',
    		'font-size'		=> '15pt',
    		'color'			=> 'grey',
        );
        $name = 'HK '.substr($term_result_['ten_hk'],-1,1).' Nam hoc '.substr($term_result_['ten_hk'],0,4).'-'.substr($term_result_['ten_hk'],4,4);
        $doc->addParagraph($name,$format);
        
        $doc->startTable();
      
        $format = array(
    		'font-weight' 	=> 'bold',
    		'font-size'		=> '15pt',
    		'color'			=> 'grey',
            'background-color' => '#800000',
            'FontFamily' => 'Times New Roman',
            'width'=>'200pt'
        );
        $tieude = array('Ma MH', 'Ten MH', 'So TC', 'Kiem tra', 'Thi', 'TB');
    	$aligns = array('center', 'center','center', 'center','center', 'center');
    	$valigns = array('middle', 'middle','center', 'center','center', 'center');
    	$doc->addTableRow($tieude, $aligns, $valigns, $format);
        
        foreach($term_result_['detail'] as $term_result__){
            $format = array(
        		'font-size'		=> '13pt',
        		'color'			=> 'grey',
            );
    		$cols = array();
    		
    		$cols[0] = $term_result__['subject_id'];
    		$cols[1] = vnstr($term_result__['subject_name']);
            $cols[2] = $term_result__['credit'];
            $cols[3] = $term_result__['mid_term']==null?'---':$term_result__['mid_term'];
            $cols[4] = $term_result__['end_term']==null?'---':$term_result__['end_term'];
            $cols[5] = $term_result__['avg']==null?'---':$term_result__['avg'];
    		
    		$doc->addTableRow($cols,$aligns,$valigns,$format);
    		unset($cols);
    	}

        $doc->endTable();
        $doc->addParagraph('');
        
        $doc->addParagraph('Thong ke');
        
        $format = array(
    		'font-size'		=> '15pt',
    		'color'			=> 'grey',
            'FontFamily'    => 'Bauhaus 93'
        );
            
        $stat = array(
            'So tin chi dang ki hoc ki',
            'So tin chi tich luy hoc ki',
            'Diem trung binh hoc ki',
            'Tong so tin chi tich luy',
            'Diem trung binh tich luy'
        );
        
         $stat_detail = array(
            $term_result_['stat']['num_cre_reg'],
            $term_result_['stat']['num_cre_pass'],
            $term_result_['stat']['avg_grade_term'],
            $term_result_['stat']['num_cre_all'],
            $term_result_['stat']['avg_grade_all']
        );
        
        //for($row = 0; $row < 5; $row++){
    		
            //$cols = array();
    		
    		//$cols[0] = $stat[$row];
   		    //$cols[1] = $stat_detail[$row];   
            
    		//$doc->addparagraph('<pre>'.$stat[$row].'                  '.$stat_detail[$row].'</pre>');
            //echo '<pre>'.$stat[$row].'              '.$stat_detail[$row].'</pre>';
    		//unset($cols);
        //}
        
        $table = 
        '<table style="font-family: fantasy;font-size: 15;font-style: italic;color: blue;">
            <tr>
                <td>'.$stat[0].'</td>
                <td><pre>          </pre></td>
                <td>'.$stat_detail[0].'</td>
            </tr>
             <tr>
                <td>'.$stat[1].'</td>
                <td><pre>          </pre></td>
                <td>'.$stat_detail[1].'</td>
            </tr>
            <tr>
                <td>'.$stat[2].'</td>
                <td><pre>          </pre></td>
                <td>'.$stat_detail[2].'</td>
            </tr>
            <tr>
                <td>'.$stat[3].'</td>
                <td><pre>          </pre></td>
                <td>'.$stat_detail[3].'</td>
            </tr>
            <tr>
                <td>'.$stat[4].'</td>
                <td><pre>          </pre></td>
                <td>'.$stat_detail[4].'</td>
            </tr>
        </table>';
        //echo $table;
        $doc->addparagraph($table,$format);
        /*
        $doc->startTable();
        for($row = 0; $row < 5; $row++){
    		
            $cols = array();
    		
    		$cols[0] = $stat[$row];
   		    $cols[1] = $stat_detail[$row];   
            
    		$doc->addTableRow($cols);
    		unset($cols);
        }
        
    	$doc->endTable();
        */
        $doc->addParagraph('');
        $doc->addParagraph('');
    }
    header('Content-Disposition: attachment; filename="docName.doc"');
	$doc->output();


?>
<table style="font-family: fantasy;font-size: 15;font-style: italic;color: blue;"></table>