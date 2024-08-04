<?php
include_once 'storage.php';
include 'util.php';
$storage = new Storage(new JsonIO('users.json'));
$users = $storage->findAll();
$error = false;
$e = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!empty($_POST['username']) && !empty($_POST['password'])){ 
        $user = findUser($_POST['username'], $_POST['password']);
        if(!empty($user)){
            session_start();
            $_SESSION['user'] = $user;
            redirect('index.php');
        } else $e = 'Invalid username or password!';
    }
    $e = 'Insert username and password!';
}

function findUser($un, $pw){
    global $users;
    $user = '';
    foreach($users as $u){
        if($un == $u['username'] && $pw == $u['password']){
            $user = $u;
        }
    }
    return $user;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IKémon | Login</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/cards.css">
</head>

<body>
    <header>
        <h1>IKémon</h1>
        <ul>
            <li> <a href="index.php">Home</a></li>
            <li> <a href="login.php">Login</a></li>
            <li> <a href="signup.php">Sign up</a></li>
        </ul>
    </header>
    <div class="content">
        
        <?php if($e != '') : ?>
            <div class="error">
                <?php echo $e?>
            </div>
        <?php endif?>
        <form method="post" class="input">
                <div>
                    <label for="username">Username: </label><br>
                    <input type="text" name="username" id="username" value="<?= $_POST['username'] ?? ''?>">
                <div>
                </div>
                    <label for="password">Password: </label><br>
                    <input type="password" name="password" id="password" value="<?= $_POST['password'] ?? ''?>">
                <div>
                </div>
                    <input type="submit" value="Login"></button>
                </div>
        </form>
    </div>
</body>