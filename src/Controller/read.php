<?php
try{
    $connection = Service\DBConnector::getConnection();
} catch (PDOException $exception) {
  http_response_code(500);
  echo 'Impossible to connect to the DB, contact the support';
  exit(1);
}
$id = null;
if ( !empty($_GET['id'])) {
  $id = $_GET['id'] ?? null;
  $id = intval($id);
}
if ( null==$id ) {
  header("Location: /index.php/account");
}else {
  $sql = 'SELECT * FROM movies WHERE id = ?';
  $statement = $connection->prepare($sql);
  $statement->execute(array($id));
  $resultall = $statement->fetchall();
  foreach ($resultall as $row){
    $movieid=$row['id'];
    $moviename=$row['name'];
    $movieyear=$row['year'];
    $moviequality=$row['quality'];
    $moviedescription=$row['description'];
  }
}
?>
<h3>Read informations of the movie</h3>
<div class="container moviecontainer">
  <div class="span10 offset1">
    <div class="form-horizontal" >
      <div class="control-group">
        <label class="control-label">Movie Name</label>
        <div class="controls">
          <label class="checkbox">
            <?php echo $moviename;?>
          </label>
          <hr />
        </div>
      </div>
      <div class="control-group">
        <label class="control-label">Movie Year</label>
        <div class="controls">
          <label class="checkbox">
            <?php echo $movieyear;?>
          </label>
          <hr />
        </div>
      </div>
      <div class="control-group">
        <label class="control-label">Movie Quality</label>
        <div class="controls">
          <label class="checkbox">
            <?php echo $moviequality;?>
          </label>
          <hr />
        </div>
      </div>
      <div class="control-group">
        <label class="control-label">Movie Description</label>
        <div class="controls">
          <label class="checkbox">
            <?php echo $moviedescription;?>
          </label>
          <hr />
        </div>
      </div>
      <div class="form-actions">
        <a class="btn btn-info" href="/index.php/account">Back</a>
      </div>
    </div>
  </div>
</div>
