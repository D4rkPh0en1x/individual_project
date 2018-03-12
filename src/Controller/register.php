<?php

try{
    $connection = Service\DBConnector::getConnection();
    
} catch (\PDOException $exception) {
    http_response_code(500);
    echo 'Impossible to connect to the DB, contact the support';
    exit(10);
}

$sqlcountry = 'SELECT * FROM countries';
$statement = $connection->prepare($sqlcountry);

$statement->execute();
$allcountries = $statement->fetchall();


if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;
        $firstname = $_POST['firstname'] ?? null;
        $lastname = $_POST['lastname'] ?? null;
        $phonenumber = $_POST['phonenumber'] ?? null;
        $phonenumber = intval($phonenumber);
        $street = $_POST['street'] ?? null;
        $streetnumber = $_POST['streetnumber'] ?? null;
        $streetnumber = intval($streetnumber);
        $postalcode = $_POST['postalcode'] ?? null;
        $postalcode = intval($postalcode);
        $locality = $_POST['locality'] ?? null;
        $country = $_POST['country'] ?? null;
        $country = intval($country);
        $region = $_POST['region'] ?? null;
              
        $sql = "INSERT INTO user(email,password,firstname,lastname,phonenumber,street,streetnumber,postalcode,locality,region,country) VALUES (\"$email\", \"$password\", \"$firstname\", \"$lastname\", \"$phonenumber\", \"$street\", \"$streetnumber\", \"$postalcode\", \"$locality\", \"$region\", \"$country\" )";
        $affected = $connection->exec($sql);
        
        if (!$affected){
            echo implode(', ', $connection->errorInfo());
            return;
        }
        
        $_SESSION['user_id'] = $connection->lastInsertId();
        $_SESSION['email'] = $email;
        
        header("location: /index.php/login");
        return;
   // }
}

?>


<h3>Please register over this formular</h3>

  <div class="container">
          <div class="card card-container">

              <form method="POST" class="form-signin">
                  
                  <input type="email" name="email" id="inputEmail" class="form-control" value="<?php echo htmlentities($_POST['email'] ?? '') ?>" placeholder="Email address" required autofocus>
                  <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
				  <input type="text" id="firstname" name="firstname" class="form-control"  placeholder="First Name" required value="<?php echo htmlentities($_POST['firstname'] ?? '') ?>"/>
				  <input type="text" id="lastname" name="lastname" class="form-control"  placeholder="Last Name" required value="<?php echo htmlentities($_POST['lastname'] ?? '') ?>"/>

	  			
		          <input type="number" id="phonenumber" name="phonenumber" class="form-control" value="<?php echo htmlentities($_POST['phonenumber'] ?? '') ?>" placeholder="Phone Number" required>
		
				  <input type="text" id="street" name="street" class="form-control" value="<?php echo htmlentities($_POST['street'] ?? '') ?>" placeholder="Street Name" required>
                  <input type="number" id="streetnumber" name="streetnumber" class="form-control" value="<?php echo htmlentities($_POST['streetnumber'] ?? '') ?>" placeholder="House Number" required>
                  <input type="number" id="postalcode" name="postalcode" class="form-control" value="<?php echo htmlentities($_POST['postalcode'] ?? '') ?>" placeholder="Postal Code" required>
                  <input type="text" id="locality" name="locality" class="form-control" value="<?php echo htmlentities($_POST['locality'] ?? '') ?>" placeholder="Locality" required>
    
                    <?php                   
                    
                    echo '<select id="country" name="country" class="form-control" placeholder="Country">';
                    foreach ($allcountries as $row){
                    echo "<option value='" . $row['id'] . "'>" . $row['country_name'] . "</option>";
                    }
                    echo "</select>";
                    
                    ?>

                  <input type="text" id="region" name="region" class="form-control" value="<?php echo htmlentities($_POST['region'] ?? '') ?>" placeholder="Region - if exists">
                  <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Register</button>

              </form>
              <a href="/index.php/login" class="login-account">
                  Login to your account
              </a>
          </div>
      </div>