<?php
	require_once('functions.php');
	if(!loggedin())
		header("Location: login.php");
	else
		include('header.php');
		connectdb();
		include('breadcrumb.php');
		include('menu.php');
?>
	</nav>
</div>
<div class="container"> <div class='well'> <i class="glyphicon glyphicon-tasks">&nbsp;</i>  Below is a list of submissions you have made. Click on any to edit it.</div>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Problem</th>
				<th>Attempts</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php
        // list all the submissions made by the user
        $query = "SELECT problem_id, status, attempts FROM solve WHERE username='".$_SESSION['username']."'";
        $result = mysql_query($query);
       	while($row = mysql_fetch_array($result)) {
       		$sql = "SELECT name FROM problems WHERE sl=".$row['problem_id'];
       		$res = mysql_query($sql);
       		if(mysql_num_rows($res) != 0) {
       			$field = mysql_fetch_array($res);
	       		echo("<tr><td><a href=\"solve.php?id=".$row['problem_id']."\">".$field['name']."</a></td><td><span class=\"badge badge-info\">".$row['attempts']);
       			if($row['status'] == 1)
       				echo("</span></td><td><span class=\"label label-warning\">Attempted</span></td></tr>\n");
       			else if($row['status'] == 2)
       				echo("</span></td><td><span class=\"label label-success\">Solved</span></td></tr>\n");
       		}
       	}
      ?>
		</tbody>
	</table>
	<?php
		include('copyright.php');
	?>
</div>
<?php
	include('footer.php');
?>
