<div id="contentview">
<form method='POST' action='/posts/p_editpost/<?=$post['post_id']; ?>'>
    <br><br>
    <label for='content'>Edit your post:</label><br>
    <textarea name='content' id='content' required><?=nl2br($post['content'])?>></textarea>

    <br><br>
    <input type='submit' value='Update post'>

</form> 
</div>

