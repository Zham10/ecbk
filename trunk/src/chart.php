<html>

<head>
    <script type="text/javascript" src="../lib/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="../lib/highcharts.js"></script>
    <script type="text/javascript" src="../lib/modules/exporting.js"></script>
</head>

<body>
    <div id="container" style="width: 900px; height: 400px; margin: 0 auto"></div>
</body>
</html>

<script type="text/javascript">
	function getChart(title,hk,tl,tensv,mssv){	
		var chart;
		$(document).ready(function() {
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'container',
					defaultSeriesType: 'line',
					marginRight: 160,
					marginBottom: 30
				},
				title: {
					text: 'Biểu đồ điểm trung bình của',
					x: -20 //center
				},
				subtitle: {
					text: tensv+'-'+mssv,
					x: -20
				},
				xAxis: {
					categories: title
				},
				yAxis: {
					title: {
						text: 'Điểm'
					},
					plotLines: [{
						value: 0,
						width: 1,
						color: '#808080'
					}]
				},
				tooltip: {
					formatter: function() {
			                return '<b>'+ this.series.name +'</b><br/>'+
							this.x +': '+ this.y ;
					}
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'top',
					x: -10,
					y: 100,
					borderWidth: 0
				},
				series: [{
					name: 'Trung bình học kì',
					data: hk
				}, {
					name: 'Trung bình tích lũy',
					data: tl
				}]
			});
			
			
		});
	}	
</script>

<?php

/**
 * @author Tuan Anh
 * @copyright 2011
 */
    require_once 'db.php';
    $sid = $_REQUEST['sid'];
    //$sid = '50800066';
 
    connect_db();
    $info = array();
    $temp = array();
    $query = 'SELECT term_name FROM term_stat WHERE student_id="'.$sid.'"';
    //echo $query;
    $results = mysql_query($query);
    while($result = mysql_fetch_array($results)){
        $term_name = $result['term_name'];
        $query = 'SELECT avg_grade_term, avg_grade_all FROM term_stat WHERE student_id="'.$sid.'" AND term_name = "'.$term_name.'"';
        //echo $query;
        $grades = mysql_query($query);
        $grade = mysql_fetch_array($grades);
        $grade['term_name'] = $term_name;
        
        $temp[$term_name] = $grade;
    }   
    //var_dump($temp);
    $i=0;
    foreach($temp as $tem){//var_dump($temp);
        $term_name = $tem['term_name'];
        $term_name_edit = 'HK '.substr($term_name,-1,1).'<br>'.substr($term_name,0,4).'-'.substr($term_name,4,4);
        //echo $term_name_edit;
        $info[0][$i] = $term_name_edit;
        $info[1][$i] = $tem['avg_grade_term'];
        $info[2][$i] = $tem['avg_grade_all'];
        $i++;
    }


        $para ='';
        $i=0;
        $para.= '[';
        for($i=0;$i<count($info[0]);$i++){
            if($i == count($info[0])-1)
                $para .= '"'.$info[0][$i].'"';
            else
                $para .= '"'.$info[0][$i].'", ';
        }
        $para .= '],';
        
        $i=0;
        $para .= '[';
        for($i=0;$i<count($info[1]);$i++){
            if($i == count($info[1])-1)
                $para .= $info[1][$i];
            else
                $para .= $info[1][$i].', ';
        }
        $para .= '],';
        
        $i=0;
        $para .= '[';
        for($i=0;$i<count($info[2]);$i++){
            if($i == count($info[2])-1)
                $para .= $info[2][$i];
            else 
                $para .= $info[2][$i].', ';
        }
        $para .= ']';
    
    $query = 'SELECT student_name FROM student WHERE student_id="'.$sid.'"';
    $tensv = mysql_query($query);
    $tensv = mysql_fetch_array($tensv);
    $tensv = $tensv['student_name'];
    //$tensv = 'Nguyễn Tuấn Anh';
    
    echo '<script>getChart('.$para.',"'.$tensv.'","'.$sid.'");</script>';
    close_db();
    
?>

