<?php

/**
 * @author Tuan Anh
 * @copyright 2011
 */
    $sid = $_REQUEST['sid'];
    echo '<a href=exportExcel.php?sid='.$sid.'>Export to Excel</a></br>';
    echo '<a href=exportWord.php?sid='.$sid.'>Export to Word</a></br>';

    echo 'Click <a href=chart.php?sid='.$sid.'>here</a> to view chart</br>';
?>