Hello
To run this project on your device you need to follow the following steps
Install the php work environment on your device Use xampp because it is simple
Run php and mysql via xampp
After downloading the project and unzipping it, move its folder to the htdocs folder located in the xampp installation path
Then open the project folder
Run CMD in the project folder path and then run the command
composer install
After finishing, go to your code editor and open the project folder
Search for the .env file and open it
Next to the word DB_DATABASE you will find the name of the database blog_app Copy it
Go in your browser to
http://localhost/phpmyadmin
Create a database with the same name blog_app
Go back to CMD and run the command
php artisan migrate:fresh --seed
Then run the command
php artisan key:generate
Then run the command
php artisan serve
Then open the browser and go To
http://127.0.0.1:8000
And now you have the most beautiful blog implemented under the supervision of ITI. God bless them and thank you for your time.
