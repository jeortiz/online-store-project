<div id="content">
    <?php include_once("includes/errors.inc.php"); ?>
    <div>
        <form method="post" action="login.php">
<!--            <label for="user-name">Name:</label><br />-->
<!--            <input type="text" name="user-name" id="user-name" value="--><?//= $name ?><!--"/><br/>-->

            <label for="user-password">Admin password:</label><br />
            <input type="password" name="user-password" id="user-password" value=""/><br/>

            <div class="g-recaptcha" data-sitekey="6LeevwMTAAAAAFezh4fMD8tm_zvC8lI0MchzU46a"></div>

            <input type="submit" name="submit-login" value="Login" />
        </form>
    </div>
</div>