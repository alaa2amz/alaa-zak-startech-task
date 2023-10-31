RUN INSTRUCTIONS:
	the followoing is commands to run one after other assuming linux terminal. 
	* git clone https://github.com/alaa2amz/alaa-zak-startech-task.git
	* cd alaa-zak-startech-task.git
	* composer install
	* touch database/database.sqlite
	* php artisan migrate
	* php artisan db:seed
	* npm install
	* npm run build
	* php artisan serve



NOTES:
these notes are
	* .env is committed to make running easier
	
	* mail server in .env is set to log so the verification mail which contains 4 digits pin code
	  can be read from storage/logs/laravel.log to ease testing and debugging.

	* the command "php artisan db:seed" in instructions above will seed the database for testing with the following
		** 10 random users each with password: "password" as normal users
		** admin@admin.com password: "password" assigned admin role
		** notadmin@notadmin password: "password" as a normal user
		** 50 random products with images
		** assign every user with random number of product from 1 to 7

	* the command "php artisan db:seed" can be run more than onece to double up the data

	* assign product to user is implemented by many to many using intermediate table(pivot table)
	  product_user. for easing testing I did not apply constrain on (user_id,product_id) so
          so each user can be assigned the same product more than one. but I it was better to add quantity
	  field in pivot table and squach the repated product and incrementing the quantity from time to time
          but mean while we would loose track  of the repeated assigment time stamps. so after all it does
	  depends on the business needs.

	* user roles is implemented by roles table and many to many via role_user table
	  migration populate the roles table of id 1 for admin by default. and laters
	  more can be added

	* localhast:8000/products and  localhast:8000/users is guarded by is Admin middleware
	  so the normal user will be redirected upon attemptin load those two pages
	  but the normal user can check his products from localhast:8000/myproducts

	* in localhast:8000/products page beside every product there is list of 
	  assigined users and "assign to user" button to assign it to more users
	  and full crud operations for products is avalable

	* in localhast:8000/users page beside every user there is list of 
          assigined products and full crud operations for users is available

	* please let me know if part of the site that didnt work well to do more debugging

	thanks in advance
	alaa zakariya 2023
