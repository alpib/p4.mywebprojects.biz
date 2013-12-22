<div id="contentview">
<?php foreach($posts as $post): ?>

    <article>
        <h3><?=$post['first_name']?> <?=$post['last_name']?> posted:</h3>
 
        <h4><?=$post['content']?></h4>
        <p>
        <time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>">
        <?=Time::display($post['created'])?>
        </time>
        </p>
         <!-- delete option if the post belongs to user -->
        <?php if($post['user_id'] == $user->user_id): ?>
                
                <div id="deletebutton">
                <a href='/posts/confirm_deletepost/<?=$post['post_id']?>'>Delete</a>
                </div>
        <?php endif; ?>

</article>

<?php endforeach; ?>
</div>