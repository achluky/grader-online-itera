<?php
	require_once('functions.php');
	if(!loggedin())
		header("Location: login.php");
	else
		include('header.php');
		connectdb();
?>

<li class="active"><a id="Clock"></a>
<li>
<li><a href="index.php">Problems</a></li>
<li><a href="submissions.php">Submissions</a></li>
<li><a href="scoreboard.php">Scoreboard</a></li>
<li class="active"><a href="#">Account</a></li>
<li><a href="logout.php">Logout</a></li>
</ul>
</div>
<!--/.nav-collapse -->
</div>
</div>
</div>
<div class="container">
  <?php
        if(isset($_GET['changed']))
          echo("<div class=\"alert alert-success\">\nAccount settings updated!\n</div>");
        else if(isset($_GET['passerror']))
          echo("<div class=\"alert alert-danger\">\nThe old password you entered is wrong. Please enter the correct password and try again.\n</div>");
        else if(isset($_GET['derror']))
          echo("<div class=\"alert alert-danger\">\nPlease enter all the details asked before you can continue!\n</div>");
    ?>
  <div class='well'> Account settings for <?php echo($_SESSION['username']);?></div>
  <hr/>
  <form method="post" action="update.php" class="bs-docs-example form-horizontal">
    <input type="hidden" name="action" value="password"/>
    <div class="control-group">
      <h3>Change Password</h3>
      <label class="control-label" for="inputIcon">Old password</label>
      <div class="controls">
        <input type="password" name="oldpass" class="form-control" />
      </div>
      <label class="control-label" for="inputIcon">New password</label>
      <div class="controls">
        <input type="password" name="newpass" class="form-control" />
      </div>
      <br/>
      <input class="btn btn-primary" type="submit" name="submit" value="Change Password"/>
    </div>
  </form>
  <hr/>

  <form method="post" action="update.php" class="bs-docs-example form-horizontal">
    <input type="hidden" name="action" value="email"/>
    <h3>Change Email</h3>
    <?php
          	$query = "SELECT email FROM users WHERE username='".$_SESSION['username']."'";
          	$result = mysql_query($query);
          	$fields = mysql_fetch_array($result);
          ?>
    <label class="control-label" for="inputIcon">Email</label>
    <input type="email" name="email" value="<?php echo $fields['email'];?>" class="form-control"/>
    <br/>
    <input class="btn btn-primary" type="submit" name="submit" value="Change Email"/>
  </form>
</div>
<!-- /container -->
<?php
	include('footer.php');
?>
