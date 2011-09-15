<?php  
function parseHK($str,$sid){
        
	$title = explode('Điểm TK',$str);
		
		$hk = substr($title[0],0,13);
		
		$ngaycapnhat = explode('Ngày cập nhật: ',$title[0]);
		
		$ngaycapnhat = explode(' <td><td',$ngaycapnhat[1]); 
		
		$ngaycapnhat = substr($ngaycapnhat[0],0,22);
		
		$subject = explode('</td><td align=center>',$title[1]);
        
		$subject[0] = substr($subject[0],-6); 
        
        //$subject[end($subject)] = substr
		$sub_end = $subject[count($subject)-1];
		
		$subject[count($subject)-1] = substr($sub_end,0,3);
		
		$sum_info = strip_tags(substr($sub_end,3));
		
		if($sum_info!=''){
			$temp = explode('Tổng số tín chỉ đăng ký học kỳ :',$sum_info);
			$temp = explode(' Tổng số tín chỉ tích lũy học kỳ:', $temp[1]);
			
			$sum_credit_reg_term = $temp[0];
			$temp = explode('Tổng số tín chỉ :', $temp[1]);
			
			$sum_credit_all_term = $temp[0];
			$temp = explode('Điểm trung bình học kỳ:', $temp[1]);
			
			$sum_credit = $temp[0];
			$temp = explode('Điểm trung bình tích lũy:', $temp[1]);
			
			$avg_term = $temp[0];
			$avg_all = substr($temp[1],0,3);
			
			$subject['sum_credit_reg_term'] = $sum_credit_reg_term;
			$subject['sum_credit_all_term'] = $sum_credit_all_term;
			$subject['sum_credit'] = $sum_credit;
			$subject['avg_term'] = $avg_term;
			$subject['avg_all'] = $avg_all;
			$subject['hk'] = $hk;
			$subject['ngaycapnhat'] =$ngaycapnhat;
		}
		else{
			$subject['sum_credit_reg_term'] = '';
			$subject['sum_credit_all_term'] = '';
			$subject['sum_credit'] = '';
			$subject['avg_term'] = '';
			$subject['avg_all'] = '';
		}
   return $subject;
}

function getMarkByID($sid){
    $url = "http://www.pgs.hcmut.edu.vn/pdt/aao_bd.php?goto="; // URL to POST FORM. 

    // use PHP Fucntion url_encode() for post variable for application/x-www-form-urlencoded  
    $post_fields = "HOC_KY=".urlencode('d.hk_nh is not NULL')."&mssv=".$sid;
     
    $ch = curl_init();    // Initialize a CURL session.       
    curl_setopt($ch, CURLOPT_URL, $url);  // Pass URL as parameter.
      
    curl_setopt($ch, CURLOPT_POST, 1); // use this option to Post a form
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); // Pass form Fields.
      
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // Return Page contents.  
    
    
    $result = curl_exec($ch);  // grab URL and pass it to the variable.  
    
    curl_close($ch);  // close curl resource, and free up system resources.  
     
    $result_arr= array(); 

        {
            $plain = strip_tags($result,"<td>");
            
            //check if student_id exits
            if(strpos($plain,'Không tìm thấy mã số sinh viên này trong dữ liệu')){
                $result = '';
                return;
            }
            
            $sinhvien = explode('Sinh viên :',$plain);
            $sinhvien = explode('-Mssv:',$sinhvien[1]);
			
			$result_arr[0] = $sinhvien[0];
            
            $temp_hks = explode('BẢNG ĐIỂM HK',$sinhvien[1]);
            
			$count = count($temp_hks);
            for($i = 1; $i<$count; $i++){
                $result_arr[$i] = parseHK($temp_hks[$i],$sid);  
            }
			
			return $result_arr;
           
        }

}
    include_once 'toFile.php';
    $id = $_REQUEST['msv'];
    $fn = $_REQUEST['fn'];
    $bd = $_REQUEST['birthday'];
    $result = getMarkByID($id);
    
    toFile($result,$id,$bd, $fn);
?>  