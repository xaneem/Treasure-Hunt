Treasure-Hunt (Clueless - Tathva 2013)
======================================

A fully functional online treasure hunt built in CodeIgniter, for Clueless 2013, conducted as a part of Tathva, at NIT Calicut, India.

Features:
* Responsive UI, built using Bootstrap 3.0
* Log-in with Facebook (only)
* Implements good security - session encryption, mySQL safety features, etc. Level answers are encrypted (md5) in the database. No passwords are stored as only Facebook login is being used.
* Logs for answer tries, with user details and IP address.
* Admin interface for all user details, level upload, and to view answer log for each user.
* Leaderboard, Winners and Rules pages (manual update)

Technical Specs:
* Bootstrap 3.0
* CodeIgniter 2.1.4
* Facebook PHP SDK
* Uses MVC pattern
* Documented code
* Built from scratch

Know the Developer and Statistics:
This code and the associated web pages were developed and maintained by Saneem. The hunt was held between October 3, 2013 to October 17, 2013. It had 4500+ users and a total of 300,000+ answer tries. You can view it live at http://clueless.tathva.org.

If you have any questions, or anything to talk about, feel free to get in touch :)

Facebook: https://www.facebook.com/xaneem

Twitter: https://www.twitter.com/xaneem

How to Setup
============
1. This project runs on CodeIgniter. Download it first: http://ellislab.com/codeigniter
2. Extract the CodeIgniter files to your server folder, and copy (replace if already exists) all files from this repository to the same folder.
3. In the /config folder,
	a. In config.php, enter your "base_url" and "encryption_key", if you intent to change it.
	b. In database.php, fill up hostname, username, password and database name.
	c. In facebook.php, enter our appId and app secret.
4. In your phpMyAdmin, create a new database (with the name you entered in config.php), and import the tables.sql file.
5. Your installation should now be ready. To make yourself an admin, first log-in using Facebook, and in the "users" table, change your role to a number >1 (say, 10).
6. Let me know if you face any problems.