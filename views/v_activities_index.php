<div id="contentview">
<?php foreach($activities as $activity): ?>

    <article>
        <h3><?=$activity['first_name']?> <?=$activity['last_name']?> did the following activities:</h3>
 
        <h4>Activity:<?=$activity['activitytype']?> for: <?=$activity['activitytime']?>mins. Calories Burned: <?=$activity['caloriesburned']?></h4>
        <p>Notes: <?=$activity['notes']?></p>
        <p>
        <time datetime="<?=Time::display($activity['created'],'Y-m-d G:i')?>">
        <?=Time::display($activity['created'])?>
        </time>
        </p>
         <!-- delete option if the activity belongs to user -->
        <?php if($activity['user_id'] == $user->user_id): ?>
                <div class='button' id="deletebutton">
                <a href='/activities/confirm_deleteactivity/<?=$activity['activity_id']?>'>Delete</a>
                </div>
        <?php endif; ?>

</article>

<?php endforeach; ?>
</div>
