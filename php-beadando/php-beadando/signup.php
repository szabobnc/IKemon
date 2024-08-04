<?php
include_once 'storage.php';
include 'util.php';
$storage = new Storage(new JsonIO('users.json'));
$users = $storage->findAll();
$error = array();
if(array_key_exists('add', $_POST)) {
if( !empty($_POST['username']) && 
    !empty($_POST['email']) &&
    !empty($_POST['password1']) &&
    !empty($_POST['password2'])){ 
    $user = findUsername($_POST['username']);
    if($user == ''){
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            array_push($error,"Invalid email format");
        }
        if ($_POST['password1'] != $_POST['password2']){
            array_push($error, "Invalid password");
        }
        if($error == []) {
            $userData = [
                'username' => $_POST['username'],
                'password' => $_POST['password1'],
                'email' => $_POST['email'],
                'role' => "user",
                'money' => 600
            ];
            $users = $storage -> add($userData);
            $_SESSION['user'] = $userData;
            redirect('index.php');
        }
    } else array_push($error, "This username is already taken") ;
} else array_push($error, "Missing elements");
}

function findUsername($un){
    global $users;
    $user = '';
    foreach($users as $u){
        if($un == $u['username']){
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
    <title>IKémon | Sign up</title>
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
        <h2> Sign up</h2>
        <?php foreach($error as $e) : ?>
            <div class="error">
                <?php echo $e?>
            </div>
        <?php endforeach?>
        <form method="post" class="input">
                <div>
                    <label for="username">Username: </label><br>
                    <input type="text" name="username" id="username" value="<?= $_POST['username'] ?? ''?>">
                </div>
                <div>
                    <label for="email">E-mail: </label><br>
                    <input type="email" name="email" id="email" value="<?= $_POST['email'] ?? ''?>">
                </div>
                <div>
                    <label for="password">Password: </label><br>
                    <input type="password" name="password1" id="password1" value="<?= $_POST['password1'] ?? ''?>">
                </div>
                <div>
                    <label for="password">Password again: </label><br>
                    <input type="password" name="password2" id="password2" value="<?= $_POST['password2'] ?? ''?>">
                </div>
                <div>
                    <button type="submit" name="add">Sign up</button>
                </div>
        </form>
    </div>
</body>