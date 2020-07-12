## MYBOS Dashboard Notes - Build With Laravel

Following are the instructions to set up locally or deploy this Project.


- Clone the Project from the following git repository on github.
  
      - git clone https://github.com/suduval/mybos.git
      
       - cd mybos
      
       - composer install
      
       - edit .env and put your db credentials
      
       - php artisan migrate

Once the above steps are done, the project is ready.

 now run

   - php artisan serve

You can access the api from http://localhost:8000
Please remember to change the APP_URL to above before run tests.

Demo:

![ERD Diagram](resources/images/MyBos_Notes.gif)

