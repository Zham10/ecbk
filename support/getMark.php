<script type="text/javascript" src="../lib/jquery-1.6.2.min.js"></script>
<script type="text/javascript">
function getCrawling(id,day, ftw){
    $.get(
        "crawling.php",
        {
                msv: id ,
                fn: ftw,
                birthday:day,
        }
        )
    //alert('a');
}
    
</script>

<?php

/**
 * @author Tuan Anh
 * @copyright 2011
 */
    
    $fileName = 'support\kq_ts2008.txt';
    $fr = fopen($fileName,'r');
    
    while(!feof($fr)){//!feof($fr)
        $data = fgets($fr);
        $id = substr($data,6,8);
        $day = substr($data,4,2).substr($data,2,2).substr($data,0,2);
        echo $id.'-'.$day.'<br>';

        echo '<script>getCrawling('.$id.',"'.$day.'","kq.sql");</script>';
        
    }
    
    fclose($fr);
    

?>
