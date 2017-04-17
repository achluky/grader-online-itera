<?php
	require_once('functions.php');
	if(loggedin())
		header("Location: index.php");
	else if(isset($_POST['action'])) {
		$username = mysql_real_escape_string($_POST['username']);
		if($_POST['action']=='login') {
			if(trim($username) == "" or trim($_POST['password']) == "")
				header("Location: login.php?derror=1"); // empty entry
			else {
				// code to login the user and start a session
				connectdb();
				$query = "SELECT salt,hash FROM users WHERE username='".$username."'";
				$result = mysql_query($query);
				$fields = mysql_fetch_array($result);
				$currhash = crypt($_POST['password'], $fields['salt']);
				if($currhash == $fields['hash']) {
					$_SESSION['username'] = $username;
					header("Location: index.php");
				} else
					header("Location: login.php?error=1");
			}
		} else if($_POST['action']=='register') {
			// register the user
			$email = mysql_real_escape_string($_POST['email']);
			if(trim($username) == "" or trim($_POST['password']) == "" or trim($email) == "")
				header("Location: login.php?derror=1"); // empty entry
			else {
				// create the entry in the users table
				connectdb();
				$query = "SELECT salt,hash FROM users WHERE username='".$username."'";
				$result = mysql_query($query);
				if(mysql_num_rows($result)!=0)
					header("Location: login.php?exists=1");
				else {
					$salt = randomAlphaNum(5);
					$hash = crypt($_POST['password'], $salt);
					$sql="INSERT INTO `users` ( `username` , `salt` , `hash` , `email` ) VALUES ('".$username."', '$salt', '$hash', '".$email."')";
					mysql_query($sql);
					header("Location: login.php?registered=1");
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title><?php echo(getName()); ?> Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<!-- Le styles -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- <link href="css/blog.css" rel="stylesheet"> -->
<style>
body {
  padding-top: 20px;
  padding-bottom: 20px;
}
.navbar {
  margin-bottom: 20px;
}
</style>
<link href="css/bootstrap-responsive.css" rel="stylesheet">

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

<!-- Le fav and touch icons -->
<link rel="shortcut icon" href="http://twitter.github.com/bootstrap/assets/ico/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-57-precomposed.png">
</head>

<body>

<div class="container">

	<nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
		<a class="navbar-brand" href="#"><?php echo(getName()); ?></a> 
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="<?php echo $base_url;?>">Home</a></li>
            <li><a href="<?php echo $base_url;?>about.php">Tentang</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>


		<?php
        if(isset($_GET['logout']))
          echo("<div class=\"alert alert-info\"><a class=\"close\" data-dismiss=\"alert\" href=\"#\">×</a>\nYou have logged out successfully!\n</div>");
        else if(isset($_GET['error']))
          echo("<div class=\"alert alert-danger\"><a class=\"close\" data-dismiss=\"alert\" href=\"#\">×</a>\nIncorrect username or password!\n</div>");
        else if(isset($_GET['registered']))
          echo("<div class=\"alert alert-success\"><a class=\"close\" data-dismiss=\"alert\" href=\"#\">×</a>\nYou have been registered successfully! Login to continue.\n</div>");
        else if(isset($_GET['exists']))
          echo("<div class=\"alert alert-danger\"><a class=\"close\" data-dismiss=\"alert\" href=\"#\">×</a>\nUser already exists! Please select a different username.\n</div>");
        else if(isset($_GET['derror']))
          echo("<div class=\"alert alert-danger\"><a class=\"close\" data-dismiss=\"alert\" href=\"#\">×</a>\nPlease enter all the details asked before you can continue!\n</div>");
      ?>
		<div class="well well-large">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#login" data-toggle="tab">Login</a></li>
				<li class=""><a href="#create" data-toggle="tab">Buat Akun</a></li>
			</ul>
			<br/>
			<div id="myTabContent" class="tab-content">
				<div class="tab-pane active" id="login">
					<form method="post" action="login.php" class="bs-docs-example form-horizontal">
						<input type="hidden" name="action" value="login"/>
						<div class="control-group">
							<label for="inputIcon">Username</label>
							<div class="controls">
								<div class="input-prepend"> <span class="add-on">
									<i class="icon-envelope"></i></span>
									<input type="text" name="username" class="form-control">
									</input>
								</div>
							</div>
							<br/>
							<label class="control-label" for="inputIcon">Password</label>
							<div class="controls">
								<div class="input-prepend"> <span class="add-on"><i class="icon-envelope"></i></span>
									<input type="password" name="password" class="form-control" />
								</div>
							</div>
						</div>
						<br/>
						<input class="btn btn-info btn-block" type="submit" name="submit" value="Login"/>
					</form>
				</div>
				<div class="tab-pane" id="create">
					<form method="post" action="login.php" class="bs-docs-example form-horizontal">
						<input type="hidden" name="action" value="register"/>
						<div class="control-group">
							<label for="inputIcon">Username</label>
							<div class="controls">
								<div class="input-prepend"> <span class="add-on"><i class="icon-envelope"></i></span>
									<input type="text" name="username" class="form-control" />
								</div>
							</div>
							<br/>
							<label for="inputIcon">Password</label>
							<div class="controls">
								<div class="input-prepend"> <span class="add-on"><i class="icon-envelope"></i></span>
									<input type="password" name="password" class="form-control" />
								</div>
							</div>
							<br/>
							<label for="inputIcon">E-mail</label>
							<div class="controls">
								<div class="input-prepend"> <span class="add-on"><i class="icon-envelope"></i></span>
									<input type="email" name="email" class="form-control" />
								</div>
							</div>
						</div>
						<br/>
						<input class="btn btn-info btn-block" type="submit" name="submit" value="Register"/>
					</form>
				</div>
			</div>
		</div>
      	<hr>
		<?php
		include('copyright.php');
		?>

</div>



<!-- /container -->

<?php
	include('footer.php');
?>
