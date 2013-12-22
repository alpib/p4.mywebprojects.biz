<div id="contentview">
<form method='POST' action='/users/p_signup'>
    <h5>
    <div class='error'>
    <?php if(isset($error_email)) echo $error_email; ?>        
    <?php if(isset($error)) echo $error; ?>        
    </div>
    </h5>

    <h3>Please signup here:</h3>
    <h5>All fields are required</h5>
    <h3>
    First Name<br>
    <input class='searchfield' type='text' required name='first_name' placeholder='First name'>
    <br>

    Last Name<br>
    <input class='searchfield' type='text' required name='last_name' placeholder='Last name'>
    <br>

    Email<br>
    <input class='searchfield' type='text' required name='email' placeholder='Enter email'>
    <br>

    Password<br>
    <input class='searchfield' type='password' required name='password' placeholder='Enter password'>
    <br>
    
    <br>
    
    <input id='button' type='submit' value='Signup'>
    <br>
    </h3>
    <div id="output"> </div>

</form>
</div>