<?php
    if(session_status()==PHP_SESSION_NONE)
        session_start();
require_once 'header.php';

echo "<div class='center'>Welcome to Blue Nest,";

if($loggedin) echo "$user, you are logged in";
else          echo "please sign up or log in";

echo <<<_END
    </div><br>
    </div>
        <div data-role='footer'>
        Database mini project.
        </div>
    </body>
</html>
_END;
?>