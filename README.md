Treasure-Hunt (Clueless - Tathva 2013)
======================================

A fully functional online treasure hunt built in CodeIgniter, for Clueless 2013, conducted as a part of Tathva, at NIT Calicut, India.

Features:
* Responsive UI, built using Bootstrap 3.0
* Log-in with Facebook (only)
* Implements good security - session encryption, mySQL safety features, etc. Level answers are encrypted (md5) in the database. No passwords are stored as only Facebook login is being used.
* Logs for answer tries, with user details and IP address.
* Admin interface for all user details, level upload, and to view answer log for each user.
* Leaderboard
* Winners and Rules pages (manual update)

Technical Specs:
* Bootstrap 3.0
* CodeIgniter 2.x ([Download here](https://github.com/bcit-ci/CodeIgniter/archive/2.2.2.zip). Newer 3.x versions not supported yet)
* PHP 5.4.0 or newer
* Facebook PHP SDK
* Uses MVC pattern
* Documented code
* Built from scratch

Know the Developer and Statistics:
This code and the associated web pages were developed and maintained by Saneem. The hunt was held between October 3, 2013 to October 17, 2013. It had 4500+ users and a total of 300,000+ answer tries. You can view it live at http://clueless.tathva.org.

You're free to make improvements to the project. Do make a pull request if it could help others :)

Twitter: @xaneem


How to Setup
============
1. This project runs on CodeIgniter 2.x [Download it here](https://github.com/bcit-ci/CodeIgniter/archive/2.2.2.zip).
2. Extract the CodeIgniter files to your server folder, and copy (replace if already exists) all files from this repository to the same folder.
3. In the /config folder,
  1. In config.php, enter your "base_url" and "encryption_key", if you intent to change it.
  2. In database.php, fill up hostname, username, password and database name.
  3. In facebook.php, enter your appId and app secret. (Get it from developers.facebook.com/apps)
4. In your phpMyAdmin, create a new database (with the name you entered in config.php), and import the tables.sql file.
5. Your installation should now be ready. To make yourself an admin, first log-in using Facebook, and in the "users" table, change your role to a number >1 (say, 10).
6. Let me know if you face any problems.

Setting up the Facebook Login
=============================
The Facebook integration code has been updated to work correctly, but there are a lot of improvements possible. Feel free to submit a PR.

- Create a new app at https://developers.facebook.com
- Click Add Product -> Login with Facebook
- Click on Facebook Login -> Quick Start (on the left navigation)
- Select Web, enter URL of your website where you'll host the site and click continue.
- Click Facebook Login -> Settings (on the left navigation)
- Add your website URL to 'Valid OAuth redirect URIs' and disable 'Use Strict Mode for Redirect URIs'

Note:
Some hosting providers are seen to cause problems with the Facebook login feature, resulting in a redirect loop. Please make sure it is a problem with the actual code before you open an issue.

License
=======
This project is licensed under GNU GENERAL PUBLIC LICENSE Version 2.
You're free to use this project for any purpose, but you
SHOULD provide the source code of any derivation freely available,
along with the proper attribution to the original project creator.

See the file LICENSE.
