# TravelDiary

Travel Diary is the one stop application for recording all your travel memories

#### Server routes 

For ascessing the database http://localhost/phpmyadmin for ascessing the homepage where the credentials have to be entered to login in or create a new user http://localhost/forum/connect.php 

#### About the files: 
- http://localhost/forum/connect.php is the login page 
- http://localhost/forum/register.php is the registration page #gitcode.php is the entry page page #comments.php is the comments and voting page for an entry --uploades.php is the page to upload the pictures 
- checkdata.php is the page for the registration username check
- display.php is the page for the ajax request for the entry display
- data.php is the page to create a marker using AJAX, it sends data to result.json
- search.php  is the page for auto completing a username and finding the associated journals using  AJAX, it sends result to search.json
- logout.php is the logout page 

#### Installation steps
##### Step 1 - Create the MYSQL database 

- Enter the username and password and create a new database called "maps" 
- Over the course of this task we  will be using 3 tables in the database 

###### Table 1 : Create a table that will store the details of the users and their passwords and their names with the password hashed by MD5.

CREATE TABLE user_info ( id INT NOT NULL AUTO_INCREMENT , username TEXT NOT NULL , password TEXT NOT NULL , name TEXT NOT NULL, PRIMARY KEY (id));


###### Table 2: To create a table called that will store details about the journals

CREATE TABLE 'entry' (id INT NOT NULL AUTO_INCREMENT , username TEXT NOT NULL, title TEXT NOT NULL ,entry TEXT NOT NULL ,image LONGBLOB NOT NULL ,status INT NOT NULL , lat VARCHAR(36) NOT NULL, lng VARCHAR(36) NOT NULL, time DATETIME NOT NULL, votes INT NOT NULL PRIMARY KEY (id`));

###### Table 3: To create a table that will store the comments on the different posts

CREATE TABLE comment(id INT NOT NULL AUTO_INCREMENT ,username TEXT NOT NULL ,comments TEXT NOT NULL , entry INT NOT NULL , PRIMARY KEY (id`));
