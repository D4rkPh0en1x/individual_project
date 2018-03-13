<?php
try{
    $connection = Service\DBConnector::getConnection();
} catch (\PDOException $exception) {
    http_response_code(500);
    echo 'Impossible to connect to the DB, contact the support';
    exit(10);
}
if(!isset($_SESSION['email']) || empty($_SESSION['email'])){
  header("location: /index.php/login");
  exit;
}
?>
  <div class="page-header">
      <h4>Hi, <b><?php echo htmlspecialchars($_SESSION['email']); ?></b>. Welcome to the world of movies.</h4>
  </div>
 	<p><a href="/index.php/logout" class="btn btn-danger">Logout</a>
 	<a href="/index.php/create" class="btn btn-success">Create</a></p>
 	<hr/>
  <div>
  <?php
  $sql = 'SELECT * FROM movies order by name asc';
  $statement = $connection->prepare($sql);
  $statement->execute();
  $resultall = $statement->fetchall();
  foreach ($resultall as $row){
    $movieid=$row['id'];
    $moviename=$row['name'];
    $movieyear=$row['year'];
    $moviequality=$row['quality'];
    if ($moviequality == 0) {
        $moviequality = "SD - Standart Definition";
    }
    if ($moviequality == 1) {
        $moviequality = "HD - High Definition";
    }
    $moviedescription=$row['description'];
    ?>
    <div class="moviecontainer">
      <p class="control-label">Moviename</p>
      <?php echo $moviename; ?>
      <hr />
      <p class="control-label">Description</p>
      <?php echo $moviedescription; ?>
      <hr />
      <p class="control-label">Year of the movie</p>
      <?php echo $movieyear; ?>
      <hr />
      <p class="control-label">Quality of the movie</p>
      <?php echo $moviequality; ?>
      <hr />
      <div class="moviebuttons">
        <?php
        echo '<a class="btn btn-info" href="/index.php/read?id='.$movieid.'">Read</a>';
        echo '<a class="btn btn-success" href="/index.php/update?id='.$movieid.'">Update</a>';
        echo '<a class="btn btn-danger" href="/index.php/delete?id='.$movieid.'&moviename='.$moviename.'">Delete</a>';
        ?>
      </div>
    </div>
  <?php
  }
  ?>
</div>
