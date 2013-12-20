<div id="contentview">
<?php foreach($posts as $post): ?>

    <article>
        <h2><?=$post['first_name']?> <?=$post['last_name']?> posted:</h2>
 
        <p><?=$post['content']?></p>
        <h4>
        <time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>">
        <?=Time::display($post['created'])?>
        </time>
        </h4>
         <!-- delete option if the post belongs to user -->
        <?php if($post['user_id'] == $user->user_id): ?>
                
                <div id="deletebutton">
                <a href='/posts/confirm_deletepost/<?=$post['post_id']?>'>Delete</a>
                </div>
        <?php endif; ?>

</article>

<?php endforeach; ?>
</div>