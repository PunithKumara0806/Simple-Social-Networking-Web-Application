<?php
// was getting session already started without below if line
// found from stackoverflow
if(session_status() === PHP_SESSION_NONE)
    session_start();

echo <<<_INIT
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width',initial-scale=1'>
        <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
        <link rel='stylesheet' href='styles.css'>
        <script src='javascript.js'></script>
        <script 
            src="https://code.jquery.com/jquery-2.2.4.min.js" 
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" 
            crossorigin="anonymous"></script>
        <script 
            src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js" 
            integrity="sha256-Lsk+CDPOzTapLoAzWW0G/WeQeViS3FMzywpzPZV8SXk=" 
            crossorigin="anonymous"></script>
_INIT;

    require_once 'functions.php';
    $userstr = 'Welcome guest';

    if(!empty($_SESSION['user'])){
        $user = $_SESSION['user'];
        $loggedin = true;
        $userstr = "Logged in as : $user";
    }
    else $loggedin = false;

echo <<<_MAIN
        <title>Blue Nest: $userstr</title>
    </head>
    <body>
    <div data-role='page'>
        <div data-role='header'>
            <div id='logo'
                class='center'>B<img alt='bluenest' id='blue' width='50px' src='bluenest.jpg'>lue Nest</div>
            <div class='username'>$userstr</div>
        </div>
        <div data-role='content'>

_MAIN;

    if($loggedin){
        //need internet for jquery to work
        // includes data-xxxx attributes
        echo <<<_LOGGEDIN
            <div class='center'>
                <a data-role='button' data-inline='true' data-icon='home'
                    data-transition="slide" href='members.php?view=$user'>Home</a>
                <a data-role='button' data-inline='true'
                    data-transition='slide' href='members.php'>Members</a>
                <a data-role='button' data-inline='true'
                    data-transition='slide' href='friends.php'>Friends</a>
                <a data-role='button' data-inline='true'
                    data-transition='slide' href='messages.php'>Messages</a>
                <a data-role='button' data-inline='true'
                    data-transition='slide' href='profile.php'>Edit Profile</a>
                <a data-role='button' data-inline='true'
                    data-transition='slide' href='logout.php'>Log out</a>
            </div>


        _LOGGEDIN;
    }
    else{
        echo <<<_GUEST
        <div class='center'>
            <a data-role='button' data-inline='true' data-icon='home'
                data-transition='slide' href='index.php'>Home</a>
            <a data-role='button' data-inline='true' data-icon='plus'
                data-transiton='slide' href ='signup.php'>Sign Up</a>
            <a data-role='button' data-inline='true' data-icon='check'
                data-transiton='slide' href ='login.php'>Log In</a>
        </div>
        <p class='info'>(You must be logged in to use this app)</p>
        _GUEST;
    }
?>