<?php
try{
  $connection = Service\DBConnector::getConnection();
} catch (PDOException $exception) {
  http_response_code(500);
  echo 'Impossible to connect to the DB, contact the support';
  exit(1);
}
$id = 0;
if ( !empty($_GET['id'])) {
  $id = $_REQUEST['id'];
 }
if ( !empty($_GET['moviename'])) {
  $moviename = $_REQUEST['moviename'];
}
if ( !empty($_POST)) {
  $id = $_POST['id'];
  $sql = "DELETE FROM movies WHERE id = ?";
  $statement = $connection->prepare($sql);
  $id = intval($id);
  $statement->execute(array($id));
  header("Location: /index.php/account");
}
?>
<div class="container">
  <div class="span10 offset1">
    <h3>Deleting the movie <?php echo "$moviename"; ?> ?</h3>
    <form class="form-horizontal" action="/index.php/delete" method="post">
      <input type="hidden" name="id" value="<?php echo $id;?>"/>
      <p class="alert alert-error">Are you sure to delete ?</p>
      <div class="form-actions">
        <button type="submit" class="btn btn-danger">Yes</button>
        <a class="btn btn-info" href="/index.php/account">No</a>
      </div>
    </form>
  </div>
</div>
