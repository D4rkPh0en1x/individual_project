<?php 

$email = $password = "";
$email_err = $password_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    
    if(empty(trim($_POST["email"]))){
        $email_err = 'Please enter email.';
    } else{
        $email = trim($_POST["email"]);
    }
    
    
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }
    
    echo 'check if nothing is empty';
    
    if(empty($email_err) && empty($password_err)){
        echo 'entering if for db check';
        
        $pdo = Service\DBConnector::getConnection();
        
        $sql = "SELECT email, password FROM user WHERE email = :email";
        
        if($stmt = $pdo->prepare($sql)){
            echo 'entering second if';
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':email', $param_email, PDO::PARAM_STR);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                echo 'entering third if';
                // Check if email exists, if yes then verify password
                if($stmt->rowCount() == 1){
                   echo 'user ok';
                    if($row = $stmt->fetch()){
                        echo 'check password';
                        $db_password = $row['password'];
                        if($password === $db_password){
                            echo 'password ok';
                            /* Password is correct, so start a new session and
                             save the email to the session */
                            session_start();
                            $_SESSION['email'] = $email;
                            header("location: /index.php/account");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = 'The password you entered was not valid.';
                        }
                    }
                } else{
                    // Display an error message if email doesn't exist
                    $email_err = 'No account found with that email.';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        
        unset($stmt);
    }
    
    
    unset($pdo);
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Individual Project - Login</title>

</head>

<body>
  <h2>Please login to your account</h2>
  <div class="container">
          <div class="card card-container">

              <form method="post" class="form-signin">
                  
                  <input type="email" name="email" id="inputEmail" class="form-control" value="<?php echo htmlentities($_POST['email'] ?? '') ?>" placeholder="Email address" required autofocus>
                  <input type="password" name="password" id="inputPassword" class="form-control" value="<?php echo htmlentities($_POST['password'] ?? '') ?>" placeholder="Password" required>
                  <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
              </form>
              <a href="/index.php/register" class="register-account">
                  Register account
              </a>
          </div>
      </div>

    </body>
</html>
