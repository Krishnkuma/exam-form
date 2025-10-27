                         ----------------------------------SETUP OF PROJECT------------------------------

Step 1: Clone the Repository

Clone the project from GitHub and navigate into the project folder:

git clone https://github.com/Krishnkuma/exam-form.git
cd exam-form


Step 2: Install Composer Dependencies

Install all the necessary PHP dependencies using Composer:

composer install

Step 3: Configure Environment File

Laravel uses an .env file to manage environment variables.
Copy the example environment file to create a new one:

cp .env.example .env


Then, open the .env file and update your database and app configurations:

DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

Step 4: Generate Application Key

Generate a unique application key for your Laravel app:

php artisan key:generate


Step 5: Run Database Migrations

To create the required database tables, run the Laravel migrations:

php artisan migrate
php artisan db:seed


Step 6: Create Storage Link

php artisan storage:link

Step 7: Start the Development Server

php artisan serve


Once the server starts, open your browser and go to:

http://127.0.0.1:8000






                    ----------------------------PROJECT DOCUMENTATION------------------------


1. Run the Project

Start the Laravel development server using the following command:

php artisan serve


The application will run at:

http://127.0.0.1:8000



User Roles
1. Admin

The admin account cannot be created manually through registration.

The default admin credentials are added via database seeding.

Run the following command to create the default admin user:

php artisan db:seed

Admin Login Credentials

Email: dcs@gmail.com

Password: dcs@gmail.com

Admin Features

View all registered students.

View individual student forms and payment receipts.

Check payment details including Payment ID.

2. Student

Students can create a new account using the registration form.

During registration, students must enter:

Name

Email

Password (minimum 6 characters, maximum 16 characters)

Student Features

Login by selecting the Student role.

Access the Student Dashboard after successful login.

Fill out the form and proceed to pay the fee of ₹500 using the Razorpay payment gateway.

After successful payment, the student can view and download the fee receipt.

Payment Gateway

Integrated Gateway: Razorpay

Fee Amount: ₹500

After a successful transaction, payment details and receipts are stored and accessible to both student and admin.
