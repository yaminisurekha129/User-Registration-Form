# User-Registration-Form
User Perspective
● Create a login form and registration form in PHP using Bootstrap styles
● Registration form should take inputs first name, last name, email, phone
number, profile pic, gender, password
● Validations should be added to the registration form using
javascript/jquery
○ First name, last name should be at least 3 characters
○ email address should accept only Gmail
○ phone number should be a combination of country code and
phone number which accepts only the number
○ Password should at least be 8 characters with 1 capital letter,
special character, and number
○ The profile pic size should be less than 2MB
○ All fields are mandatory
● If any validation fails show the respective error message and focus the
field
● If all validations are done successfully submit the form and send an
email to the user with the successfully registered message and store
the data in the MySQL table with the name ‘user’ if the email already
exists in the user table display an error message
● The login form should take inputs email and password
● The user should be able to log in with a registered email
○ Display an error message when a password is wrong
○ If the email doesn’t exist display an error message
● If the user login successfully redirect to the welcome page with their
information



Process:
1.Create Database forms in phpmyadmin and create table called registration.
2.Connect the database with mysql using php.
3.Create registration form for user registration having--First name,Last name,email.phone number,profile pic,gender,password.
4.Create welcome page and connect it to login page.If credentials are valid ok or else redirect to login page again in welcome page.

