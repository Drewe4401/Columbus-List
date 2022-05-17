<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
    </head>
<body>
    <header>
        <h1>Columbus List</h1>
    </header>
    <main>
        <form id="login_form" class="form_class" action="login.php" method="post">
		<h1>Sign in</h1>
		<?php if (isset($_GET['error'])) { ?>
			<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
            <div class="form_div">
                <label>Email:</label>
                <input class="field_class" name="ename" type="text" placeholder="Please enter columbus email" autofocus>
                <label>Password:</label>
                <input id="pass" class="field_class" name="password" type="password" placeholder="Enter password">
                <button class="submit_class" type="submit" form="login_form">Enter</button><br>
                <p>Don't have an account? <a href="signup.php">Sign Up here</a>.</p>
            </div>
            <div class="info_div">
            </div>
        </form>
    </main>
</body>
</html>