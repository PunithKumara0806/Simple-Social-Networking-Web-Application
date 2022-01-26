<?php
    require_once 'header.php';
    if(!empty($_SESSION['user'])){
        destroySession();
        echo"<script>alert('You are logged out');</script>";
        header("Location: ./index.php");
        echo "<br><div class='center'>You have been logged out. Please
            <a data-transition='slide' href='index.php'>click here</a>
            to refresh the screen.</div>";
    }
    else echo "<div class='center'> You cannot log out because you are not logged in</div>";
?>
        </div>
</body>
</html>