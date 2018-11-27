Take this code for a test drive at https://scott-chaplinski.com/

Fully functioning PHP message board with:  
  
-List of existing messages, sorted most recent first  
-Paginated, 10 per page - can be easily changed in code  
-User creation/login page  
-User logs in and posts as log-in name  
-Posts display user name, email address, message  
-User name, email, and password validation  
-Users can delete own messages  
-Admin can delete any/all messages  
  
  
Additional:  
  
-DB table holds user info, separate table holds messages  
-Inner join used to display messages alongside user name and email  
-No matter what page the user is on, the URL is https://scott-chaplinski.com  
-Password hashing  
-User names and email addresses must be unique  
-Users have log out button  
  
To launch in XAMPP:  
-Add /DB/message_board to xampp\mysql\data  
-Add /site to xampp\htdocs  
  
Current User/Passwords:  
(Since passwords are hashed, this is necessary)  
  
user name: admin  
password: adminadmin  
  
user name: ScrappyDoo  
password: password1  
  
user name: Garfunkel  
password: garfunkel  
  
user name: Chewbacca  
password: chewchewtrain  
  
user name: GarthAlgar  
password: garthworld  
  
user name: SilentBob  
password: quietplease  
  
user name: PedroPedro  
password: voteforme  
  
user name: Samwise  
password: potatoes
