<?php

/**
 * @author Tuan Anh
 * @copyright 2011
 */
function connect_db (){
    $con = mysql_connect('localhost','root','') or die('Cannot connect!');
    //echo 'Connected';
    $db = mysql_select_db('diem',$con) or die('Cannot select database!');
    //echo 'Selected';
    mysql_set_charset('utf8');
    return $con;
}
function close_db(){
    mysql_close();
}
function check_exits($obj, $table, $col){
    $query = 'SELECT * FROM '.$table.' WHERE '.$col .'= '.$obj;
    //echo $query;
    $result = mysql_query($query) or die(mysql_error());
    if(mysql_num_rows($result)) 
        return 1;
    else 
        return 0;
}

//connect_db();
//check_exits("'2 (2009-2010)'",'term','term_name');

//echo check_exits("006018",'subject','subject_id');



?>