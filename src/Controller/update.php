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
}
if ( !empty($_POST)) {
  $movienameError = null;
  $moviename = $_POST['moviename'];
  $movieyear = $_POST['movieyear'];
  $moviequality = $_POST['moviequality'];
  $moviedescription = $_POST['moviedescription'];
  $valid = true;
  if (empty($moviename)) {
    $nameError = 'Please enter Movie Name';
    $valid = false;
  }
  if (empty($movieyear)) {
    $nameError = 'Please enter Year';
    $valid = false;
  }
  if (empty($moviequality)) {
    $nameError = 'Please enter the quality';
    $valid = false;
  }
  if ($valid) {
      $sql = "UPDATE movies set name = ?, year = ?, quality = ?, description = ? WHERE id = ?";
      $statement = $connection->prepare($sql);
      $statement->execute(array($moviename,$movieyear,$moviequality,$moviedescription,$id));
      header("Location: /index.php/account");
  }
} else {
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
<form class="form-horizontal" action="/index.php/update?id=<?php echo $id?>" method="post">
  <div class="control-group <?php echo !empty($movienameError)?'error':'';?>">
    <label class="control-label">Movie Name</label>
    <div class="controls">
      <input name="moviename" type="text" size="35" placeholder="Movie Name" value="<?php echo !empty($moviename)?$moviename:'';?>">
      <?php if (!empty($movienameError)): ?>
        <span class="help-inline"><?php echo $movienameError;?></span>
      <?php endif; ?>
    </div>
  </div>
  <div class="control-group <?php echo !empty($movieyearError)?'error':'';?>">
    <label class="control-label">Movie Year</label>
    <div class="controls">
      <input name="movieyear" type="text" size="4" placeholder="Movie Year" value="<?php echo !empty($movieyear)?$movieyear:'';?>">
      <?php if (!empty($movieyearError)): ?>
        <span class="help-inline"><?php echo $movieyearError;?></span>
      <?php endif; ?>
    </div>
  </div>
  <div class="control-group <?php echo !empty($moviequalityError)?'error':'';?>">
    <label class="control-label">Movie Quality (1=HD / 2=SD)</label>
    <div class="controls">
      <input name="moviequality" type="text" size="4" placeholder="Movie Quality" value="<?php echo !empty($moviequality)?$moviequality:'';?>">
      <?php if (!empty($moviequalityError)): ?>
        <span class="help-inline"><?php echo $moviequalityError;?></span>
      <?php endif; ?>
    </div>
  </div>
  <div class="control-group <?php echo !empty($moviedescriptionError)?'error':'';?>">
    <label class="control-label">Movie Description</label>
    <div class="controls">
      <textarea name="moviedescription" placeholder="Movie Description" rows="5" cols="80"><?php echo !empty($moviedescription)?$moviedescription:'';?></textarea>
      <?php if (!empty($moviedescriptionError)): ?>
        <span class="help-inline"><?php echo $moviedescriptionError;?></span>
      <?php endif; ?>
    </div>
  </div>
  <div class="form-actions">
    <button type="submit" class="btn btn-success">Update</button>
    <a class="btn btn-info" href="/index.php/account">Back</a>
  </div>
</form>
