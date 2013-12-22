<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<!-- Common CSS -->
    <link rel=stylesheet type="text/css" href="/css/master.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/hot-sneaks/jquery-ui.css">
    
    <!-- JS File we want on every page -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    
    <!-- Google Font Link -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head>

<body>	
    <div id="wrapper">

    <div id="header">
        <div id"appname">
            BeActive
        </div>
    </div> <!-- end of header -->

    
        <div id='navbar'>
            <ul>
            <li><a href='/'>Home</a></li>

            <!-- Menu for users who are logged in -->
            <?php if($user): ?>
            
            <li><a href='/users/logout'>Logout</a></li>
            <li><a href='/users/profile'>Profile</a></li>
            <li><a href='/activities/add'>Add Activity</a></li>
            <li><a href='/activities/myactivities'>My Activity</a></li>
            <li><a href='/activities/index'>All</a></li>
            <li><a href='/posts/add'>Comment</a></li>
            <li><a href='/posts/followedposts'>My Followers</a></li>
            <li><a href='/posts/users'>Members</a></li>
            <li><a href='/posts/index'>Discussion</a></li>

            <!-- Menu options for users who are not logged in -->
            <?php else: ?>

            <li><a href='/users/signup'>Sign up</a></li>
            <li><a href='/users/login'>Log in</a></li>

            <?php endif; ?>
            </ul>
        </div> <!-- end of navbar -->
          
        

         <!--start content text-->

	     <?php if(isset($content)) echo $content; ?>

	     <?php if(isset($client_files_body)) echo $client_files_body; ?>

    </div> <!-- end of wrapper -->

    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/hot-sneaks.js"></script>
</body>
</html>
				