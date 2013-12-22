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
</article>

<?php endforeach; ?>


<?php if($posts == "") : ?>
	<h3>Follow some members to read what they are discussing</h3>
    <a href='/posts/users'>All Members</a>

<?php endif; ?>

</div>