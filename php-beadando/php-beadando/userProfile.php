<?php
session_start();
include 'util.php';
include_once 'storage.php';
$storage = new Storage(new JsonIO('cards.json'));
$cards = $storage->findAll();

if(array_key_exists('logout', $_POST)) { 
    logout();
    redirect('index.php');
}
if(array_key_exists('create', $_POST)) { 
    redirect('createCard.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IKémon | Profile</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/profile.css">
    <link rel="stylesheet" href="styles/cards.css">
</head>

<body>
    <header>
        <h1>IKémon</h1>
        <ul>
            <li> <a href="index.php">Home</a></li>
        </ul>
    </header>
    <div class="content">
        <div class="profile">
            <h2>User profile</h2>
            <div>
                Username: <?php echo $_SESSION['user']['username']?>
            </div>
            <div>
                Password: <?php echo $_SESSION['user']['password']?>
            </div>
            <div>
                E-mail: <?php echo $_SESSION['user']['email']?>
            </div>
            <div>
                Money: <?php echo $_SESSION['user']['money']?> <span class="icon">💰</span> <br> 
            </div>
            <br>
            <form method="post">
                <div>
                    <?php if($_SESSION['user']['role'] == 'admin') : ?>
                        <input type="submit" name="create" value="Create new card" />
                    <?php endif?>
                </div>
                <div>
                    <input type="submit" name="logout" value="Logout" /> 
                </div>
            </form>
        </div>
        <h2>My cards:</h2>
        <div id="card-list">
            <?php foreach($cards as $key => $card): ?>
                <?php if($card['owner'] == $_SESSION['user']['username']) : ?>
                <div class="pokemon-card">
                <div class="image clr-<?php echo $card['type']?>">
                    <img src=<?= $card['image']?> alt="">
                </div>
                <div class="details">
                    <h2><a href="details.php?id=<?php echo $key ?>"> <?php echo $card['name']?></a></h2>
                    <span class="card-type"><span class="icon">🏷</span> </span>
                    <span class="attributes">
                        <span class="card-hp"><span class="icon">❤</span> <?php echo $card['hp']?></span>
                        <span class="card-attack"><span class="icon">⚔</span> <?php echo $card['attack']?></span>
                        <span class="card-defense"><span class="icon">🛡</span> <?php echo $card['defense']?></span>
                    </span>
                </div>
                <?php if($_SESSION['user']['role'] != 'admin') : ?>
                    <a href="sellCard.php?id=<?php echo $key?>" class="buyL">
                        <div class="buy">
                            <span class="card-price"><span class="icon">💰</span> <?php echo $card['price']?></span>
                        </div>
                    </a>
                <?php endif?>
                </div>
                <?php endif?>
            <?php endforeach ?>
        </div>
    </div>
    <footer>
        <p>IKémon | ELTE IK Webprogramozás | Szabó Bence</p>
    </footer>
</body>