<?php
class posts_controller extends base_controller {

    public function __construct() {
        parent::__construct();

        # Make sure user is logged in if they want to use anything in this controller
        if(!$this->user) {
            die("Members only. <a href='/users/login'>Login</a>");
        }
    }

    public function add() {

        # Setup view
        $this->template->content = View::instance('v_posts_add');
        $this->template->title   = "New Post";

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
        DB::instance(DB_NAME)->insert('posts', $_POST);

        # Send them back to home page
        Router::redirect('/posts/index');

    }

    public function confirm_deletepost($post_id) {
        # Set up the View
        $this->template->content = View::instance('v_posts_deletepost');
        $this->template->title   = "Confirm delete?";
        $this->template->content->post_id = $post_id;

        # Render template
        echo $this->template;

    }


    public function p_deletepost($post_id) {
        $data = "WHERE post_id = ".$post_id; 
        DB::instance(DB_NAME)->delete('posts',$data);

        Router::redirect('/users/profile'); 
    }


    public function index() {

    # Set up the View
    $this->template->content = View::instance('v_posts_index');
    $this->template->title   = "Posts";

    # Build the query
    $q = "SELECT 
            posts .* , 
            users.first_name, 
            users.last_name
        FROM posts
        INNER JOIN users 
            ON posts.user_id = users.user_id";

    # Run the query
    $posts = DB::instance(DB_NAME)->select_rows($q);

    # Pass data to the View
    $this->template->content->posts = $posts;

    # Render the View
    echo $this->template;

    }

    public function users() {

    # Set up the View
    $this->template->content = View::instance("v_posts_users");
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
    Router::redirect("/posts/users");

    }

    public function unfollow($user_id_followed) {

    # Delete this connection
    $where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$user_id_followed;
    DB::instance(DB_NAME)->delete('users_users', $where_condition);

    # Send them back
    Router::redirect("/posts/users");

    }



    public function followedposts() {

    # Set up the View
    $this->template->content = View::instance('v_posts_followedposts');
    $this->template->title   = "What Chitchatters you follow are saying";

    # Query
    $q = 'SELECT 
            posts.content,
            posts.created,
            posts.user_id AS post_user_id,
            users_users.user_id AS follower_id,
            users.first_name,
            users.last_name
        FROM posts
        INNER JOIN users_users 
            ON posts.user_id = users_users.user_id_followed
        INNER JOIN users 
            ON posts.user_id = users.user_id
        WHERE users_users.user_id = '.$this->user->user_id;

    # Run the query, store the results in the variable $posts
    $posts = DB::instance(DB_NAME)->select_rows($q);

    # Pass data to the View
    $this->template->content->posts = $posts;

    # Render the View
    echo $this->template;

}
    

    public function editpost($edited) {
            # Set up the View
            $this->template->content = View::instance('v_posts_editpost');
                    
            # Build the query to get the post
           $q2 = "SELECT posts .* , 
                    users.first_name, 
                    users.last_name
                    FROM posts
                    INNER JOIN users 
                    ON posts.user_id = users.user_id
                    WHERE users.user_id = ".$this->user->user_id."
                    ORDER BY posts.created DESC"
                    ;

            # Execute the query to get all the users.
            # Store the result array in the variable $post
            $_POST['editable'] = DB::instance(DB_NAME)->select_row($q);
            
            # Pass data to the view
            $this->template->content->post = $_POST['editable'];
            
            # print_r($_POST);
            # Render template
                echo $this->template;         

    }
    
    public function p_editpost($id) {
                        
                  
            # Set the modified time
            $_POST['modified'] = Time::now();
            
            # Be sure to Associate this post with this user
            $_POST['user_id'] = $this->user->user_id;
         
                # set up the where conditon and update the post.
                $where_condition = 'WHERE post_id = '.$id;
                $updated_post = DB::instance(DB_NAME)->update('posts', $_POST, $where_condition);

                # Send them back
               Router::redirect('/users/profile');
    }



} # End of class

