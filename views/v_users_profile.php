<div id="contentview">
    <div id="contentviewpaneleft">
        <h2>Profile for: <?=$user->first_name?></h2>
        <p> <label for='first_name'>First Name: </label><?=$user->first_name?></p>
        <p> <label for='last_name'>Last Name: </label><?=$user->last_name?></p>
        <p> <label for='email'>Email: </label><?=$user->email?></p>



    </div>

    <div id="contentviewpaneright">
    <?php if ($user->avatar != "/uploads/avatars/defaultimage.jpeg"): ?>
        <div id="cropped">
        <img src="<?=$user->avatar?>" alt="<?=$user->first_name?> <?=$user->last_name?>" width="300" height="300">
                    
    <?php endif; ?>


    <form role="form" method='POST' enctype="multipart/form-data" action='/users/new_photo_upload/'>
        Upload a photo for your profile:
        <br>
        <input type="file" name="avatar" id="avatar" accept="image/*" >
        <br>
         <input type="submit" name="Upload" value='Upload'>
        <br>
        </form>
    </div>
        
</div>  

    <?php if(isset($myActivities)) : ?>
        <?=$myActivities?>
    <?php endif; ?>

    <?php if(isset($allActivities)) : ?>
        <h4>Recent Activity</h4>
        <?=$allActivities?>
    <?php endif; ?>       
