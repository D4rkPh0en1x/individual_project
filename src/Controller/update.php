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
    // keep track validation errors
    $nameError = null;
    $emailError = null;
    $mobileError = null;
    
    // keep track post values
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    
    // validate input
    $valid = true;
    if (empty($name)) {
        $nameError = 'Please enter Name';
        $valid = false;
    }
    
    if (empty($email)) {
        $emailError = 'Please enter Email Address';
        $valid = false;
    } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $emailError = 'Please enter a valid Email Address';
        $valid = false;
    }
    
    if (empty($mobile)) {
        $mobileError = 'Please enter Mobile Number';
        $valid = false;
    }
    
    // update data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE customers  set name = ?, email = ?, mobile =? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($name,$email,$mobile,$id));
        Database::disconnect();
        header("Location: index.php");
    }
} else {
    
    
    
    
    
    $sql = 'SELECT * FROM movies WHERE id = ?';
    $statement = $connection->prepare($sql);
    
    $statement->execute(array($id));
    
    
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
    
}

}

?>



                    <form class="form-horizontal" action="/index.php/update.php?id=<?php echo $id?>" method="post">
                      <div class="control-group <?php echo !empty($movienameError)?'error':'';?>">
                        <label class="control-label">Movie Name</label>
                        <div class="controls">
                            <input name="moviename" type="text"  placeholder="Movie Name" value="<?php echo !empty($moviename)?$moviename:'';?>">
                            <?php if (!empty($movienameError)): ?>
                                <span class="help-inline"><?php echo $movienameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                   
                      
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="index.php">Back</a>
                        </div>
                        
                    </form>
                    