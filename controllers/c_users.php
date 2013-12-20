<?php
class users_controller extends base_controller {

    public function __construct() {
        # Call the base constructor
        parent::__construct();
        #echo "users_controller construct called<br><br>";
    } 

    public function index() {
        echo "This is the index page";
    }

    public function signup() {
        //echo "This is the signup page";
        # Setup view
        $this->template->content = View::instance('v_users_signup');
        $this->template->title   = "Signup";

        # Pass data to the view
        $this->template->content->error = $error;

        # Render template
        echo $this->template;
    }

    public function p_signup() {

        # Set Up view
        $this->template->content = View::instance('v_users_signup');
        $this->template->title = "Sign Up";

        $client_files_head = Array("/js/jquery-1.10.2.min.js","/js/jstz-1.0.4.min.js","http://cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.4/jstz.min.js");
        $this->template->client_files_head = Utils::load_client_files($client_files_head);
                
        # No errors yet
        $error = false;

        # Initiate error
        $this->template->content->error = '<br>';
                
        # If not submitted yet 
        if(!$_POST) {
            echo $this->template;
                return;
                }
                
        # Begin Error Checking

        # If a field was blank, return error
            foreach($_POST as $field_name => $value) {
                if(empty($value)) {
                $this->template->content->error .= str_replace('_',' ', (ucfirst($field_name))).' was blank.<br>';
                $error = true;
                        }
                }        
                
        # Set the limit of the number of characters in fields
        $limit = 25;

        # If a field was more than 25 characters, add a message to the error View variable
        foreach($_POST as $field_name => $value) {
                if(strlen($value) > $limit) {
                $this->template->content->error .= str_replace('_',' ', (ucfirst($field_name))).' was more than 25 characters.<br>';
                $error = true;
                        }
                }        
                
        # Verify email is in correct format, but not blank, send error if bad format
        if (!filter_var(($_POST["email"]), FILTER_VALIDATE_EMAIL) && (!empty($_POST["email"]))) {
            $this->template->content->error_email = 'Email address not in correct format.<br>';
            $error = true;
                }

        # Sanitize 
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        # Compare form email with database emails 
        $q = "SELECT * FROM users WHERE email = '".$_POST['email']."'"; 
            
        # Return any emails that match form email
        $email_exists = DB::instance(DB_NAME)->select_row($q);

        # Email exists in the database return error message
        if($email_exists) {
            $this->template->content->error_email = 'Email address already exists. Try a different one or login<br>';
            $error = true;
        } 

        # End of Error Checking

        # If there are no errors after submission
        if(!$error) {    

        # More data we want stored with the user
        $_POST['created']  = Time::now();
        $_POST['modified'] = Time::now();
        $_POST['avatar'] = 'defaultimage.jpeg';

        # Encrypt the password  
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);            

        # Create an encrypted token via their email address and a random string
        $_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());

        # Insert this user into the database
        $user_id = DB::instance(DB_NAME)->insert('users', $_POST);

        # Place email and password values in variables
        $email =$_POST['email'];
        $pword =$_POST['password'];

        # Send to signup success page
        # Setup view
        $this->template->content = View::instance('v_users_signupsuccess');
        # Login view within this view        
        $this->template->content->login = View::instance('v_users_login');
        $this->template->title   = "Signed Up";

        # Display template
        echo $this->template;

        } else {
                        
        # Display template
        echo $this->template;
        }

    } #end of p_signup

    public function login($error = NULL) {
        
        if($this->user) { #If they are already logged in
        Router::redirect('/users/profile');
        }

        # Setup view
        $this->template->content = View::instance('v_users_login');
        $this->template->title   = "Login";

        # Pass data to the view
        $this->template->content->error = $error;

        # Render template
        echo $this->template;

    }  #end of login

    public function p_login() {

        # Begin Error Checking of Login Form of blank fields

            # Checking to see if email field and password field is blank
                if(empty($_POST['email']) && empty($_POST['password'])) {
                        # Send them back to the index page and display both message
                Router::redirect("/users/login/both");

            # If just email was blank
                } elseif(empty($_POST['email'])) {
                        # Send them back to the index page and display email message
                Router::redirect("/users/login/email");

            # If just password was blank
                } elseif(empty($_POST['password'])) {
                        # Send them back to the index page and display password message
                    Router::redirect("/users/login/pword");
                }
                
        # End of Error Checking

        # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        # Hash submitted password so we can compare it against one in the db
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

        # Search the db for this email and password
        # Retrieve the token if it's available
        $q = "SELECT token 
          FROM users 
          WHERE email = '".$_POST['email']."' 
          AND password = '".$_POST['password']."'";

        $token = DB::instance(DB_NAME)->select_field($q);
        
        if(!$token) {  # If no matching token, login failed
        Router::redirect("/users/login/error"); # Send back to the login page 
        } 

        else {   # login succeeded! 
        /* 
        Store this token in a cookie using setcookie()
        Important Note: *Nothing* else can echo to the page before setcookie is called
        Not even one single white space.
        param 1 = name of the cookie
        param 2 = the value of the cookie
        param 3 = when to expire
        param 4 = the path of the cooke (a single forward slash sets it for the entire domain)
        */
        setcookie("token", $token, strtotime('+1 year'), '/');

        # Send them to the main page - or whever you want them to go
        Router::redirect("/users/profile");
        }

    }  #end of p_login

    public function logout() {
        //echo "This is the logout page";
        # Generate and save a new token for next login
        $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

        # Create the data array we'll use with the update method
        # In this case, we're only updating one field, so our array only has one entry
        $data = Array("token" => $new_token);

        # Do the update
        DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

        # Delete their token cookie by setting it to a date in the past - effectively logging them out
        setcookie("token", "", strtotime('-1 year'), '/');

        # Send them back to the main index.
        Router::redirect("/");

    }  #end of logout

    public function profile($user_name = NULL) {

        # If user is blank, they're not logged in; redirect them to the login page
        if(!$this->user) {
        Router::redirect('/users/login');
        }

        # Setup view
        $this->template->content = View::instance('v_users_profile');
        $this->template->title   = "Profile";

        # Pass data to the view
        $this->template->content->error = $error;

        # Create variable to reference logged in user in query
        $this_user_id = $this->user->user_id;

        # This selects all activities from logged in user 
        $q = "SELECT 
            activities.activitytype, 
            activities.activitytime,
            activities.caloriesburned,
            activities.date
        FROM activities

        WHERE user_id = ".$this->user->user_id;

        # Find logged in user activities in DB
        $activities = DB::instance(DB_NAME)->select_rows($q);

        if($activities) {
            # Display logged in user's post on their profile page
            $client_files_head = Array("http://code.highcharts.com/highcharts.js","http://code.highcharttable.org/master/jquery.highchartTable-min.js","/js/highchart.js");
            $this->template->client_files_head = Utils::load_client_files($client_files_head);

            $this->template->content->myActivities = View::instance('v_users_activities');
            $this->template->content->myActivities->activities = $activities;
        
        # If user has no activities yet then show recent posts from all users
        } else {
            # This selects all posts from all users
            $q = "SELECT posts.* , users.first_name, users.timezone, users.avatar
            FROM posts
            JOIN users 
            WHERE posts.user_id = users.user_id 
            ORDER BY posts.created DESC
            LIMIT 5";

            # Find 5 recent posts from all users
            $posts = DB::instance(DB_NAME)->select_rows($q);

            # Display recent posts from all users on the signed in profile page
            $this->template->content->allPosts = View::instance('v_users_posts');
            $this->template->content->allPosts->posts = $posts;
        }

        # Render template
        echo $this->template;
  
  
    }   #end of profile

    public function new_photo_upload() {
        // if user specified a new image file, upload it
        if ($_FILES['avatar']['error'] == 0){
            //upload an image
            $avatar = Upload::upload($_FILES, "/uploads/avatars/", array("jpg", "JPG", "jpeg", "JPEG", "gif", "GIF", "png", "PNG"), $this->user->user_id);

            $data = Array("avatar" => $avatar);
            DB::instance(DB_NAME)->update("users", $data, "WHERE user_id = ".$this->user->user_id);

            // resize the image and make a thumbnail version resize image.  This code is not working
            //$imgObj = new Image($_SERVER["DOCUMENT_ROOT"] . '/uploads/avatars/' . $avatar);
            //$imgObj->resize(100,100, "crop");
            //$imgObj->save_image($_SERVER["DOCUMENT_ROOT"] . '/uploads/avatars/' . $avatar); 

             # Redirect
           Router::redirect("/users/profile");
        }

        // Redirect back to the profile page
        Router::redirect('/users/profile'); 
    }    

} # end of the class