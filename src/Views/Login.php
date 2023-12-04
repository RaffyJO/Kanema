<?php

require_once('src/Views/templates/source.php');
if (!isset($TPL)) {
    $TPL = new source();
    $TPL->title = "Login";
    $TPL->bodycontent = __FILE__;
    include "src/Views/layout/layout.php";
    exit;
}
?>
<form method="post" action="/auth">
    <input type="text" name="username" id="username" placeholder="Username" required>
    <br>
    <input type="password" name="password" id="password" placeholder="Paswsword" required>
    <br>
    <input type="submit" value="submit">
</form>