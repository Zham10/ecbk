<html>
<body>

<script type="text/javascript" src="lib/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="lib/jquery.form.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#formMark").ajaxForm({
            target: '#results',
            success: function(response){
                $("#results").html(response);
            },
            beforeSubmit: function(){
                //$("#results").html('Loading...')
                $("#results").html('<img src="src/loading.gif"/> Waiting me !!!')
            },
        });
    });
</script>

<form action="crawling.php" method="get" id="formMark">

    <label for="msv">Student ID</label>
    <input type="text" name="msv"/><br />
    
<!--    <label for="mssv1">From</label>
    <input type="text" name="mssv1"/>
    
    <label for="mssv2">To</label>
    <input type="text" name="mssv2"/>
 -->   
    <input type="submit" value="Submit"/>
</form>

<div id="results"> Result here</div>
</body>
</html>