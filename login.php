<?php
    require_once 'header.php';
    $error = $user = $pass = "";

    if(!empty($_POST['user'])){
        $user = sanitizeString($_POST['user']);
        $pass = sanitizeString($_POST['pass']);

        if($user == "" || $pass == ""){
            $error = 'Not all fields were entered';
        }
        else{
            $result = queryMysql("SELECT user, pass FROM members WHERE user='$user' AND pass='$pass'");

            if($result->num_rows == 0){
                $error = "Invalid login attempt";
            }
            else{
                $_SESSION['user'] = $user;
                $_SESSION['pass'] = $pass;
                echo "<script>alert('You are logged in')</script>";
                header('Location: http://localhost/blue_nest/members.php');
                die("You are now logged in. 
                        Please <a data-transition='slide' href='members.php?view=$user'
                        >click here</a> to continue
                        </div>
                    </body>
                </html>");
            }
        }
    }
    echo <<<_END
            <form method='post' action='login.php'>
                <div data-role='fieldcontain'>
                    <label></label>
                    <span class='error'>$error</span>
                </div>
                <div data-role='fieldcontain'>
                    <label></label>
                    Please enter your details to log in
                </div>
                <div data-role='fieldcontain'>
                    <label>Username</label>
                    <input type='text' maxlength='16' name='user' value='$user'>
                </div>
                <div data-role='fieldcontain'>
                    <label>Password</label>
                    <input type='password' maxlength='16' name='pass' value='$pass'>
                </div>
                <div data-role='fieldcontain'>
                    <label></label>
                    <input data-transitions='slide' type='submit' value='Login'>
                </div>
            </form>
        </div>
        </body>
    </html>
    _END;
?>