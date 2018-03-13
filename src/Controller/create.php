<?php

try{
    $connection = Service\DBConnector::getConnection();

} catch (PDOException $exception) {
    http_response_code(500);
    echo 'Impossible to connect to the DB, contact the support';
    exit(1);
}

if ( !empty($_POST)) {
    $movienameError = null;
    $movieyearError = null;
    $moviequalityError = null;
    $moviedescriptionError = null;
    $moviename = $_POST['moviename'];
    $movieyear = $_POST['movieyear'];
    $moviequality = $_POST['moviequality'];
    $moviedescription = $_POST['moviedescription'];
    $valid = true;
    if (empty($moviename)) {
        $movienameError = 'Please enter Movie Name';
        $valid = false;
    }
    if (empty($movieyear)) {
        $movieyearError = 'Please enter Year';
        $valid = false;
    }
    if (empty($moviequality)) {
        $moviequalityError = 'Please enter the quality';
        $valid = false;
    }
    if (empty($moviedescription)) {
        $moviedescriptionError = 'Please enter a description';
        $valid = false;
    }
    if ($valid) {
        $sql = 'INSERT INTO movies (name,year,quality,description) values (?, ?, ?, ?)';
        $statement = $connection->prepare($sql);
        $movieyear = intval($movieyear);
        $moviequality = intval($moviequality);
        $statement->execute(array($moviename,$movieyear,$moviequality,$moviedescription));
        header("Location: /index.php/account");
    }
}
?>
<form class="form-horizontal" action="/index.php/create" method="post">
  <div class="control-group <?php echo !empty($movienameError)?'error':'';?>">
    <label class="control-label">Movie Name</label>
    <div class="controls">
        <input name="moviename" type="text" size="35" placeholder="Movie Name">
        <?php if (!empty($movienameError)): ?>
          <span class="help-inline"><?php echo $movienameError;?></span>
        <?php endif; ?>
    </div>
  </div>
  <div class="control-group <?php echo !empty($movieyearError)?'error':'';?>">
    <label class="control-label">Movie Year</label>
    <div class="controls">
      <input name="movieyear" type="text" size="35" placeholder="Movie Year">
      <?php if (!empty($movieyearError)): ?>
        <span class="help-inline"><?php echo $movieyearError;?></span>
      <?php endif; ?>
    </div>
  </div>
  <div class="control-group <?php echo !empty($moviequalityError)?'error':'';?>">
    <label class="control-label">Movie Quality (1=HD / 2=SD)</label>
    <div class="controls">
      <input name="moviequality" type="text" size="35" placeholder="Movie Quality">
      <?php if (!empty($moviequalityError)): ?>
        <span class="help-inline"><?php echo $moviequalityError;?></span>
      <?php endif; ?>
    </div>
  </div>
  <div class="control-group <?php echo !empty($moviedescriptionError)?'error':'';?>">
    <label class="control-label">Movie Description</label>
    <div class="controls">
      <textarea name="moviedescription" placeholder="Movie Description" rows="5" cols="80"></textarea>
      <?php if (!empty($moviedescriptionError)): ?>
        <span class="help-inline"><?php echo $moviedescriptionError;?></span>
      <?php endif; ?>
    </div>
  </div>
  <div class="form-actions">
    <button type="submit" class="btn btn-success">Create</button>
    <a class="btn btn-info" href="/index.php/account">Back</a>
  </div>
</form>
