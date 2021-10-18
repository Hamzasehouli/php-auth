<?php
include('./config.php');
// Initialize the session

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: signup.php");
    
    exit;
}


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $username = strtolower(trim($_POST['username']));
    $password = trim($_POST['password']);
    $username_err = null;
    $password_err= null;

    if(empty(trim($username))){
        $username_err = 'Please provide a valid username';
    }else{
        $username = strtolower(trim($username));
    }
     if (empty($password)){
        $password_err = 'Please enter a valid password'; 
    }else{
        $password = trim($password);
    }

    if(empty($username_err) && empty($email_err)){
        try{
           
            // echo "Connected successfully";
            // $statement = $connect->prepare("INSERT INTO user(username, email, password) VALUES(:username, :email, :hashedPassword)");
            // $statement->bindValue(':username', $username);
            // $statement->bindValue(':email', $email);
            // $statement->bindValue(':hashedPassword', $hashedPassword);
            // $statement->execute();

            if($statement = $connect->prepare('SELECT id, username, password FROM user WHERE username = :username')){
                $statement->bindValue(":username", $username);

                $statement->execute();
                    echo 'hahah';
                
                   
                    // Check if username exists, if yes then verify password
                    $row = $statement->fetch();
                        $id = $row["id"];
                        $usern = $row["username"];
                        $hashed_password = $row["password"];
                       password_verify($password, $hashed_password);
                            session_start();
                            $_SESSION['loggedin']=true;
                            $_SESSION['id'] = $id;
                            $_SESSION['username'] = $usern;
                            header("location: welcome.php");
                       
            }
            

          


                
           
            unset($statement);
            
        }catch(PDOException $e){
            // echo "Connection failed: " . $e->getMessage();
        }
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>S'inscrire</title>
</head>

<body>
    <section class="section__form">
        <form class="form" action="login.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Nom d'utilisateur</label>
                <input name="username" type="text" class="form-control" id="username"
                    aria-describedby="emailHelp"><span><?php if(!empty($username_err)){
                    echo $username_err;
                    } ?></span>

            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input name="password" type="password" class="form-control" id="password"><span><?php if(!empty($password_err)){
                    echo $password_err;
                    } ?></span>
            </div>

            <button type="submit" class="btn btn-primary">Se connecter</button>
            <a href="signup.php" class="btn btn-primary">Tu n'as pas un compte? s'inscrire ici</a>
        </form>
    </section>
</body>

</html>