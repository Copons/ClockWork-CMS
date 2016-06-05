<div id="login">

<!--<h2>Login</h2>-->

<form action="pages/login/login.php" enctype="multipart/form-data" method="post" style="margin-top: 15px">

<p>Username:<br />
<input id="username" name="username" type="text" size="20" tabindex="1" <?php if (isset($_COOKIE['loginTry']) && $_COOKIE['loginTry']>'3') echo 'readonly="readonly" ' ?>/></p>

<p>Password:<br />
<input id="password" name="password" type="password" size="20" tabindex="2" <?php if (isset($_COOKIE['loginTry']) && $_COOKIE['loginTry']>'3') echo 'readonly="readonly" ' ?>/></p>

<p id="p-entra"><input id="entra" name="entra" type="submit" value="Login" tabindex="3" <?php if (isset($_COOKIE['loginTry']) && $_COOKIE['loginTry']>'3') echo 'readonly="readonly" ' ?>/></p>

</form>

</div>
