<?php

    $fields = "";
    $fields_string = "";
    $url = $_POST['post_url'];

    foreach($_POST as $name => $value) {
        if ($name != "post_url") $fields .= urlencode($name).'='.urlencode($value).'&';
    }

    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST,count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);

    //execute post
    curl_exec($ch);


    //close connection
    curl_close($ch);

?>
<html>
<head>
</head>
<body>
THANKS
</body>
</html>
