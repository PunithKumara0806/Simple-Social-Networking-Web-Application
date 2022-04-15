<?php
    require_once 'header.php';
    
    if (!$loggedin) die("</div></body></html>");
    if (isset($_GET['view'])) $view = sanitizeString($_GET['view']);
    else $view = $user;
    if (isset($_POST['text']))
    {
        $text = sanitizeString($_POST['text']);
        if ($text != "")
        {
            $pm = substr(sanitizeString($_POST['pm']),0,1);
            $time = time();
            queryMysql("INSERT INTO messages VALUES(NULL, '$user',
            '$view', '$pm', $time, '$text')");
        }
    }
    if ($view != "")
    {
        if ($view == $user) $name1 = $name2 = "Your";
        else
        {
            $name1 = "<a href='members.php?view=$view'>$view</a>'s";
            $name2 = "$view's";
        }
        echo "<h3>$name1 Messages</h3>";
        showProfile($view);
        
        echo <<<_END
        <form  method='post' action='messages.php?view=$view' style='float:right;width:45%;'>
        <fieldset data-role="controlgroup" data-type="horizontal">
        <legend>Type here to leave a message</legend>
        <input type='radio' name='pm' id='public' value='0' checked='checked'>
        <label for="public">Public</label>
        <input type='radio' name='pm' id='private' value='1'>
        <label for="private">Private</label>
        </fieldset>
        <textarea  name='text'></textarea>
        <input data-transition='slide' type='submit' value='Post Message'>
        </form><br>
        <form method='post' action='messages.php?view=$view' style='margin:0px;width:200px;'>
        <input type='text' name='search' placeholder='Search messages...' style='display:inline-block; width:200px;'>
        <input type='submit' id='search_icon' style='display:inline;background-color:blue;width:200px;' data-icon='search'>
        </form>
        _END;
        date_default_timezone_set('UTC');
        if (isset($_GET['erase']))
        {
            $erase = sanitizeString($_GET['erase']);
            queryMysql("DELETE FROM messages WHERE id=$erase AND auth='$user'");
        }

        if(empty($_POST['search']))
        {
            $query = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC";
            $result = queryMysql($query);
            $num = $result->num_rows;
        }
        else{
            $search = sanitizeString($_POST['search']);
            if(preg_match('/%.*%/',$search))
                $query = "SELECT * FROM messages WHERE recip='$view' AND message LIKE '$search'";
            else
                $query = "SELECT * FROM messages WHERE recip='$view' AND MATCH(message) AGAINST('$search') ORDER BY time DESC";
            $result = queryMysql($query);
            $num = $result->num_rows;
        }
        echo "<br><br><br><br><br>";
        echo "<table>";
        echo "<tbody id='msg'>";
        
        for ($j = 0 ; $j < $num ; ++$j)
        {
            echo "<tr>";
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $time = $row['time'] + 5*60*60 + 30*60;
            if ($row['pm'] == 0 || $row['auth'] == $user || $row['recip'] == $user)
            {
                if((time() - $row['time']) < 24*60*60){ // if the diff is less a day it shows today
                    echo "<td>Today </td><td>" .date('g:ia',$time)." </td>";
                }
                elseif((time() - $row['time']) < 2*24*60*60){
                    echo "<td>Yesterday </td><td>" .date('g:ia',$time)."</td>";
                }
                else echo "<td>".date('M jS \'y',$time)."</td><td>".date('g:ia', $time)."</td>";
                echo " <td><a href='messages.php?view=" . $row['auth'] ."'>" . $row['auth']. "</a></td> ";
                if ($row['pm'] == 0){
                 echo "<td>wrote:</td><td> &quot;".$row['message']."&quot;</td>";

                }
                else{
                     echo "<td>whispered:</td><td> &quot;".$row['message']."&quot;</td>";
                }
                if ($row['recip'] == $user)
                    echo "<td>[<a href='messages.php?view=$view" .
                "&erase=" . $row['id'] . "'>erase</a>]</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "<br>";
    }
    if (!$num)
        echo "<br><span class='info'>No messages yet</span><br><br>";
    echo "<br><a data-role='button'href='messages.php?view=$view'>Refresh messages</a>";
?>
 </div><br>
 </body>
</html>
