<?php
class activities_controller extends base_controller {

    public function __construct() {
        parent::__construct();

        # Make sure user is logged in if they want to use anything in this controller
        if(!$this->user) {
            die("Members only. <a href='/users/login'>Login</a>");
        }
    }

    public function add() {

        # Setup view
        # Set up the View
        $client_files_head = Array("/js/BeActive.js");
        $this->template->client_files_head = Utils::load_client_files($client_files_head);
        $this->template->content = View::instance('v_activities_add');
        $this->template->title   = "New Activity";

        # Render template
        echo $this->template;

    }

    public function p_add() {

        # Associate this post with this user
        $_POST['user_id']  = $this->user->user_id;

        # Unix timestamp of when this post was created / modified
        $_POST['created']  = Time::now();
        $_POST['modified'] = Time::now();


        # Insert
        # Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
        DB::instance(DB_NAME)->insert('activities', $_POST);

        # Send them back to home page
        Router::redirect('/activities/index');

    }

    public function confirm_deleteactivity($activity_id) {
        # Set up the View
        $this->template->content = View::instance('v_activities_deleteact');
        $this->template->title   = "Confirm delete?";
        $this->template->content->activity_id = $activity_id;

        # Render template
        echo $this->template;

    }


    public function p_deleteact($activity_id) {
        $data = "WHERE activity_id = ".$activity_id; 
        DB::instance(DB_NAME)->delete('activities',$data);

        Router::redirect('/activities/index'); 
    }


    public function index() {

    # Set up the View
    $this->template->content = View::instance('v_activities_index');
    $this->template->title   = "Activities";

    # Build the query
    $q = "SELECT 
            activities .* , 
            users.first_name, 
            users.last_name
        FROM activities
        INNER JOIN users 
            ON activities.user_id = users.user_id";

    # Run the query
    $activities = DB::instance(DB_NAME)->select_rows($q);

    # Pass data to the View
    $this->template->content->activities = $activities;

    # Render the View
    echo $this->template;

    }

    public function myactivities() {

    # Set up the View
    $client_files_head = Array(
        "http://code.highcharts.com/highcharts.js",
        "http://code.highcharttable.org/master/jquery.highchartTable-min.js",
        "/js/highchart.js","/js/jquery.dataTables.js", 
        "/css/jquery.dataTables_themeroller.css",
        "/css/demo_table.css");

    $this->template->client_files_head = Utils::load_client_files($client_files_head);
    $this->template->content = View::instance('v_activities_myactivities');
    $this->template->title   = "My Activities";

    # Build the query
    $q = "SELECT 
            activities.activitytype, 
            activities.activitytime,
            activities.caloriesburned,
            activities.date
        FROM activities

        WHERE user_id = ".$this->user->user_id;

    # Run the query
    $activities = DB::instance(DB_NAME)->select_rows($q);

    # Pass data to the View
    $this->template->content->activities = $activities;

    # Render the View
    echo $this->template;

    }

    public function users() {

    # Set up the View
    $this->template->content = View::instance("v_activities_users");
    $this->template->title   = "Users";

    # Build the query to get all the users
    $q = "SELECT *
        FROM users";

    # Execute the query to get all the users. 
    # Store the result array in the variable $users
    $users = DB::instance(DB_NAME)->select_rows($q);

    # Build the query to figure out what connections does this user already have? 
    # I.e. who are they following
    $q = "SELECT * 
        FROM users_users
        WHERE user_id = ".$this->user->user_id;

    # Execute this query with the select_array method
    # select_array will return our results in an array and use the "users_id_followed" field as the index.
    # This will come in handy when we get to the view
    # Store our results (an array) in the variable $connections
    $connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');

    # Pass data (users and connections) to the view
    $this->template->content->users       = $users;
    $this->template->content->connections = $connections;

    # Render the view
    echo $this->template;
    }

    public function follow($user_id_followed) {

    # Prepare the data array to be inserted
    $data = Array(
        "created" => Time::now(),
        "user_id" => $this->user->user_id,
        "user_id_followed" => $user_id_followed
        );

    # Do the insert
    DB::instance(DB_NAME)->insert('users_users', $data);

    # Send them back
    Router::redirect("/activities/users");

    }

    public function unfollow($user_id_followed) {

    # Delete this connection
    $where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$user_id_followed;
    DB::instance(DB_NAME)->delete('users_users', $where_condition);

    # Send them back
    Router::redirect("/activities/users");

    }

} # End of class

