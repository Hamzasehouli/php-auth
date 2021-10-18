<?php 
require_once('./config.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $username_err = null;
    $password_err= null;
    $email_err = null;
    $hashedPassword = password_hash($password,PASSWORD_DEFAULT);

    if(empty(trim($username))){
        $username_err = 'Please provide a valid username';
    }
     if(empty(trim($email))){
        $email_err = 'Please provide a valid email';
    }
     if (empty($password)){
        $password_err = 'Please enter a valid password'; 
    }else{
        $username = strtolower($username);
        $email = strtolower($email);
        $password = strtolower($password);
        try{
            $connect = new PDO("mysql:host=localhost;port=3306;dbname=users", 'root', '');
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully";
            $statement = $connect->prepare("INSERT INTO user(username, email, password) VALUES(:username, :email, :hashedPassword)");
            $statement->bindValue(':username', $username);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':hashedPassword', $hashedPassword);
            $statement->execute();
            
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
        <form class="form" action="signup.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Nom d'utilisateur</label>
                <input name="username" type="text" class="form-control" id="username" aria-describedby="emailHelp">
                <span><?php if(!empty($username_err)){
                    echo $username_err;
                    } ?></span>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input name="email" type="email" class="form-control" id="email">
                <span><?php if(!empty($email_err)){
                    echo $email_err;
                    } ?></span>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input name="password" type="password" class="form-control" id="password"><span><?php if(isset($password_err)){
                    echo $password_err;
                    } ?></span>
            </div>

            <button type="submit" class="btn btn-primary">S'inscrire</button>
            <a href="login.php" class="btn btn-primary">Tu as deja un compte? se connecter ici</a>
        </form>
    </section>
</body>

</html>