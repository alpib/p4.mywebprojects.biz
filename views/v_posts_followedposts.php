<div id="contentview">

<?php if($posts == "") : ?>
	<h3>Follow some Chitchatters to find out what they are talking about</h3>
    <a href='/posts/users'>All Chitchatters</a>

<?php endif; ?>


<?php foreach($posts as $post): ?>

<article>

    <h2><?=$post['first_name']?> <?=$post['last_name']?> posted:</h2>

    <p><?=$post['content']?></p>
    <h5>
    <time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>">
        <?=Time::display($post['created'])?>
    </time>
    </h5>
</article>

<?php endforeach; ?>
</div>