<?php
require_once 'login_details.php';
$conn = new mysqli($hostname,$dbuser,$dbpasswd,$db);
if($conn->connect_error) die("Connection error");

function createTable($name,$query){
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br>";
}

function queryMysql($query){
    global $conn;
    // echo "$query<br>";
    $result = $conn->query($query);
    if(!$result){
        echo "$result<br>";
        die('Query failed to execute');
    }
    return $result;
}

function destroySession(){
    $_SESSION =array();
    if(session_id() != '' || !empty($_COOKIE[session_name()])){
        setcookie(session_name(),'',time()-2500000,'/');
    }
    session_destroy();
}

function sanitizeString($var){
    global $conn;
    $var = strip_tags($var);
    $var = htmlentities($var);
    // if(get_magic_quotes_gpc()){
    //     $var = stripslashes($var);
    // }
    return $conn->real_escape_string($var);
}

function showProfile($user){
    if(file_exists("$user.jpg")){
        echo "<img src='$user.jpg' style='float:left;'><div><strong>$user</strong></div>";
    }

    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

    if($result->num_rows){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo stripslashes($row['text']). "<br style='clear:left;'><br>";
    }
    else echo "<p>Nothing to see here, yet</p><br>";
}
?>