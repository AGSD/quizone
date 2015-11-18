# quizone
A network based quizzing platform
- Aditya Gaur, 2015

Hi there!
This project was created originally in January-April 2015 as an academic DBMS project.

The project also required some documentation which you should be able to find in the glittery documentation.pdf
file which was created along with the project.

The entire project uses HTML, CSS, javaScript, php, MySQL. For the UI design BootStrap was used, and AJAX was used at a lot
of places for form validation and some other purposes. The project was developed on a XAMPP local server.

----Where to start----

If you want to run this project, copy the entire repo on a local server capable of running php and inclusive of a MySQL database.
I personally used XAMPP.

the initial place to go to is the index.php, which should be obvious to most people. The code has a php snippet which
automatically takes you to the init folder which then runs the query which creates the entire database required for the project.
It also allows you to create an administrator account, and then thereafter, once the initialisation is done, visiting index.php 
will show the home page.

----Folder descriptions----

/ - root
the root basically has all the main pages which are visited. There is no other file directly accessed by the user.

/init - initialisation
This folder consists of files required for the one time initialisation of the database on the system. The files help create an
admin account, and run a query (which can probably be found as it is in query.txt) to create the database.

/res - resources
The resource folder has a lot of under the hood files which are used alongside all the main files in the root directory.
All form validation, and some other query passing tasks, along with a time returning script for the timers on the quizzes.
It also includes bootstrap and some CSS files I used in addition to bootstrap for the UI.

/pics - pictures
Just some image files used here and there in the project.

