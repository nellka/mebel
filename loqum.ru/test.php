<?php
if (!empty($_POST)||isset($_GET['callback'])) {
    $result = array('server_domain'=>$_SERVER['HTTP_HOST'], 'form_domain'=>$_GET['domen']);
    //$result = array('t'=>'POSTED '.$_SERVER['HTTP_HOST']);
    $result = json_encode($result);
    echo $_GET['callback'] . "($result)";exit;
    die();
}
 ?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<form id="f1" method="post">
    <input type="text" id="t1" value="info"/>
    <input type="submit" name="submit"/>

</form>

<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="http://soderganki-online.ru/js/jquery.flash.js"></script>
<script type="text/javascript" language="javascript">
    var domen = document.location.href;

    $.ajax({
        //url: 'http://atolin.ru/test.php',
        url: 'http://soderganki-online.ru/test.php',
        dataType: "jsonp",
        crossDomain : true,
        type: "GET",
        cache: false,
        data: ({domen:domen}),
        success: function (data){
            try {
                alert(data.server_domain + ' | ' + data.form_domain);
            }
            catch (e) { alert ('error')}
        }
    });

</script>
</body>
</html>