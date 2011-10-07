<?php

/**
 * @author Tuan Anh
 * @copyright 2011
 */
?>


<html>
<script type="text/javascript" src="../lib/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="../lib/jquery.form.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#form").ajaxForm({
            target: '#result',
            success: function(response){
                $("#result").html(response);
            },
            beforeSubmit: function(){
                //$("#results").html('Loading...')
                $("#result").html('<img src="../file/loading.gif"/> Waiting me !!!')
            },
            clearForm:true,
        });
    });
</script>

<body>
    <form action="temp.php" method="get" id="form">
        Nhập MSSV <input type="text" name="sid"/>
        <input type="submit" value="Submit"/>    
    </form>
    
    <div id="result"></div>
</body>
</html>
