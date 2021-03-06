<?php
/* Phoenix2
** Modal Window
==
This dialogue adds a new corpus to the currently active project (according to the $ps session) and redirects to a given site.
*/
?>
<h1>Add Corpus</h1>
<p>To add a new corpus to the current project, please fill in the details below:</p>
<form method="post" action="?action=AddCorpus&next=<?php echo $_GET['next']; ?>">
    <fieldset>
        <legend class="required">Name</legend>
        <input name="name" id="name" type="text" class="text w33" />
        <p>Name and comments are only internal descriptions and will neither be written to the actual xml file nor exportet.</p>
        <legend>Comment</legend>
        <textarea name="comment" id="comment" class="w66 h100"></textarea>
    </fieldset>
    <input type="submit" class="button" value="Create corpus" name="add_corpus" />
</form>