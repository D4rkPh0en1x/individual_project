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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h3>Hi, <b><?php echo htmlspecialchars($_SESSION['email']); ?></b>. Welcome to our site.</h3>
    </div>
   	<p><a href="/index.php/logout" class="btn btn-danger">Sign Out of Your Account</a></p>
   	<hr/>
    <div>

    <?php

    $sql = 'SELECT * FROM movies';
    $statement = $connection->prepare($sql);

    $statement->execute();


    // $resultall = $connection->query($sql); //pay attention if use exec or query -> unsecure

    //case of fetchall
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

        <div>
        <p>Moviename: <?php echo $moviename; ?></p>
        <p>Description: <?php echo $moviedescription; ?></p>
        <p>Year of the movie: <?php echo $movieyear; ?></p>
        <p>Quality of the movie: <?php echo $moviequality; ?></p>
        <?php
        echo '<a class="btn btn-success" href="/index.php/update?id='.$movieid.'">Update</a>';
        ?>




        <hr/>
        </div>
        <?php
    }


    ?>

    </div>



</body>
</html>
