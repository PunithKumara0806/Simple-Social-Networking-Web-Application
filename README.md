# Simple-Social-Networking-Web-Application

Based on the examples and instruction given in the book [ Learning PHP, MySql and Javascript 5th edition](https://www.oreilly.com/library/view/learning-php-mysql/9781491979075/)

## Some additional features are added like:
  - Searching using substring or keywords.
  - > Using `LIKE` keyword of MySQL and `FULLTEXT` indexing.
  - You can search for particular words in a message by typing those words in the search bar.
  - You can also use substring search using `%`substring`%` pattern in the search bar.
    - Eg. 
      > `%ath%` **matches** math, maths etcs.
  - Added Trigger to count the number of friend.
## Running the project on Ampps:
  - After installing the Ampps and connecting it to database server(here MySQL).
  - Clone this repo to the 'www' folder in the Ampps folder.
  - Create a user in the database with the username and password as specified in the 'login_details.php' file
  - The user created for this project was as follows:
  - > `CREATE USER` 'bluenest'@'localhost' `IDENTIFIED BY` 'bluenest123';
  - Then create a database called 'bluenest'.
  - Then grant permissions to modify on the database to the created user.
  - > `GRANT ALL ON` bluenest.* `TO` 'bluenest'@'localhost';
  - After creating all the necessary tables we must create triggers for the events.
  - The following the triggers used in the project:
    - ### Initialising the friend_counter table.
      ``` 
        create trigger `friend_counter_init`
             after insert 
             on `members`
             for each row
             begin
                 insert into `friend_count` values(new.user,0);
             end;
      ```
    - ### Increasing the friend count.
      ```
      delimiter $
             create trigger friend_counter_incre
             after insert 
             on friends
             for each row 
             begin
                 if ((exists(select * from friends where user = new.user and friend = new.friend))
                 and (exists(select * from friends where user = new.friend and friend = new.user))) then 
                 update friend_count set count = count+1 where user=new.user;
                 update friend_count  set count = count+1 where user = new.friend;
             end if;

             end$
         delimiter  ;
       ```
     -  ### Decreasing the friend count.
       ```
       delimiter $
             create trigger friend_counter_decre
             before delete
             on friends
             for each row
             begin
                  
                 if ((exists(select * from friends where user = old.user and friend = old.friend))
                 and (exists(select * from friends where user = old.friend and friend = old.user))) then 
                 update friend_count set count = count-1 where user=old.user;
                 update friend_count  set count = count-1 where user = old.friend;
             end if;
             end $
         delimiter ;

       ```
 - Once all this is done then start the Apache & MySQL servers in the Ampps and type `localhost` in your browser.
 - The browser will display the front page for the bluenest.

     
