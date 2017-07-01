<?php
    require_once('../functions.php');
    if(!loggedin())
        header("Location: login.php");
    else if($_SESSION['username'] !== 'admin')
        header("Location: login.php");
    else
        include('header.php');
        connectdb();
        date_default_timezone_set('UTC');
        require_once('menu.php');
?>
    </ul>
  </div>
</div>
</div>
</div>

<div class="container">
  <?php
        if(isset($_GET['changed']))
          echo("<div class=\"alert alert-info\">\n<i class=\"glyphicon glyphicon-info-sign\">&nbsp;</i>Settings Saved!\n</div>");
        else if(isset($_GET['passerror']))
          echo("<div class=\"alert alert-danger\">\n<i class=\"glyphicon glyphicon-info-sign\">&nbsp;</i>The old password is incorrect!\n</div>");
        else if(isset($_GET['derror']))
          echo("<div class=\"alert alert-danger\">\n<i class=\"glyphicon glyphicon-info-sign\">&nbsp;</i>Please enter all the details asked before you can continue!\n</div>");
  ?>
  <ul class="nav nav-tabs">
    <li class="active"><a href="#">Umum</a></li>
    <li><a href="problems.php">Soal</a></li>
    <li><a href="scoring.php">Penilaian</a></li>
  </ul>
  <div>
    <div>
        <form method="post" action="update.php" class="bs-docs-example form-horizontal">
          <?php
              $query = "SELECT name, start, end, c, cpp, java, python FROM prefs";
              $result = mysql_query($query);
              $fields = mysql_fetch_array($result);
          ?>
          <h3>List Event</h3>
          <?php
              $query = "SELECT ev_id, title, start, end, c, cpp, java, python FROM event LIMIT 10";
              $result = mysql_query($query);
          ?>
          <ol>
          <?php 
	          	while($row = mysql_fetch_array($result)) {
          ?>
            <li><a href="event.php?ev=<?php echo $row['ev_id']?>"><?php echo $row['title']; ?></a></li>
          <?php 
              }
          ?>
          </ol>
          <p><a href="event.php?action=add"><i class="glyphicon glyphicon-plus">&nbsp;</i>add event</a></p>
          <hr/>
          <input type="hidden" name="action" value="settings" />
          <input name="name" type="text" placeholder="Name of event" value="<?php echo($fields['name']);?>" class="form-control" required />
          <br/>
          <div id="datetimepicker1" class="input-append date">
            <input data-format="dd/MM/yyyy hh:mm:ss" type="text" placeholder="Start Time" class="form-control" name="start" value="20/02/2017 20:20:22" required></input>
            <span class="add-on"> 
                <i data-time-icon="icon-time" data-date-icon="icon-calendar"> </i> 
            </span> 
          </div>
          <div id="datetimepicker2" class="input-append date">
            <input data-format="dd/MM/yyyy hh:mm:ss" type="text" placeholder="End Time" class="form-control" name="end" value="20/02/2017 20:20:22" required>
            </input>
            <span class="add-on"> <i data-time-icon="icon-time" data-date-icon="icon-calendar"> </i> </span> 
          </div>
          <h4>Languages</h4>
          <div class="checkbox">
            <label>
              <input name="cpp" type="checkbox" <?php if($fields['cpp']==1) echo("checked=\"true\"");?>/>
              C++
            </label>
          </div>
          <div class="checkbox">
            <label>
              <input name="c" type="checkbox" <?php if($fields['c']==1) echo("checked=\"true\"");?>/>
              C
            </label>
          </div>
          <br/>
          <input class="btn btn-primary" type="submit" name="submit" value="Save"/>
        </form>
    </div>
  </div>
  <?php
  include('../copyright.php');
  ?>
</div>
<?php
    include('footer.php');
?>
