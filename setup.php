<!DOCTYPE html>
<html>
    <head>
        <title>Setting up database</title>
    </head>
    <body>
        <h3>Setting up...</h3>
    <?php
        require_once 'functions.php';

        createTable(
            'members',
            'user VARCHAR(16),
            pass VARCHAR(16),
            INDEX(user(6))'
        );

        createTable(
            'messages',
            'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            auth VARCHAR(16),
            recip VARCHAR(16),
            pm CHAR(1),
            time INT UNSIGNED,
            message VARCHAR(4096),
            INDEX(auth(6)),
            INDEX(recip(6)),
            FULLTEXT(message)'
        );

        createTable(
            'friends',
            'user VARCHAR(16),
            friend VARCHAR(16),
            INDEX(user(6)),
            INDEX(friend(6))'
        );
        createTable(
            'profiles',
            'user VARCHAR(16),
            text VARCHAR(4096),
            INDEX(user(6))'
        );

        createTable(
            'friend_count',
            'user VARCHAR(16),
            count INT,
            INDEX(user(6))'
        );

    //     //triggers

    //     //initializes the friend_count table;
    //     queryMysql('
    //         create trigger `friend_counter_init`
    //         after insert 
    //         on `members`
    //         for each row
    //         begin
    //             insert into `friend_count` values(new.user,0);
    //         end;
    //     ');
    //     echo "done friend_init<br>";
    //     //increases friend_count 
    //     queryMysql('
    //     delimiter $
    //         create trigger friend_counter_incre
    //         after insert 
    //         on friends
    //         for each row 
    //         begin
    //             if ((exists(select * from friends where user = new.user and friend = new.friend))
    //             and (exists(select * from friends where user = new.friend and friend = new.user))) then 
    //             update friend_count set count = count+1 where user=new.user;
    //             update friend_count  set count = count+1 where user = new.friend;
    //         end if;

    //         end$
    //     delimiter  ;

    //     ');
    //     //decrease friend_count;
    //     queryMysql('
            
    //     delimiter $
    //         create trigger friend_counter_decre
    //         before delete
    //         on friends
    //         for each row
    //         begin
                    
    //             if ((exists(select * from friends where user = old.user and friend = old.friend))
    //             and (exists(select * from friends where user = old.friend and friend = old.user))) then 
    //             update friend_count set count = count-1 where user=old.user;
    //             update friend_count  set count = count-1 where user = old.friend;
    //         end if;
    //         end $
    //     delimiter ;
    // ');

    ?>
    <br>...done
    </body>
</html>
