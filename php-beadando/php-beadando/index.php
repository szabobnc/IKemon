<?php
include_once 'storage.php';
include 'util.php';
$storage = new Storage(new JsonIO('cards.json'));
$cards = $storage->findAll();
session_start();
if(!isset($_POST['type']))
    $_POST['type'] = "all";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IKémon | Home</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/cards.css">
</head>

<body>
    <header>
        <h1>IKémon</h1>
        <ul>
            <li> <a href="index.php">Home</a></li>
            <?php 
            if(isset($_SESSION['user'])){
                echo "<li> <a href=\"userProfile.php\">Profile</a></li>";
            }
            else {
                echo "<li> <a href=\"login.php\">Login</a></li>";
                echo "<li> <a href=\"signup.php\">Sign up</a></li>";
            }
            ?>
        </ul>
        <?php 
            if(isset($_SESSION['user'])){
                echo "<div class=\"infoU\">",
                "username: ", "<a href=\"userProfile.php\">", $_SESSION['user']['username'], "</a>", "<br>",
                "money: ", $_SESSION['user']['money'], "<span class=\"icon\">💰</span>",
                "</div>";
            }
            ?>
        
    </header>
    <div id="content">
        <form method="post">
            <label for="type">Type:</label>
                    <select name="type" id="type">
                        <?php if(isset($_POST['type'])) echo "<option value=\"", $_POST['type'] ,"\">", $_POST['type'], "</option>"?>
                        <option value="all">all</option>
                        <option value="normal">normal</option>
                        <option value="fire">fire</option>
                        <option value="water">water</option>
                        <option value="electric">electric</option>
                        <option value="grass">grass</option>
                        <option value="ice">ice</option>
                        <option value="fighting">fighting</option>
                        <option value="poison">poison</option>
                        <option value="ground">ground</option>
                        <option value="psyhic">psyhic</option>
                        <option value="bug">bug</option>
                        <option value="rock">rock</option>
                        <option value="ghost">ghost</option>
                        <option value="dark">dark</option>
                        <option value="steel">steel</option>
                    </select>
            <input type="submit" name="filter" value="Filter cards">
        </form>
        <div id="card-list">
            <?php foreach($cards as $key => $card): ?>
            <?php if(isset($_POST['type']) && $_POST['type'] == 'all' || $_POST['type'] == $card['type'] ) : ?>
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
                <div>
                <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] !='admin') : ?>
                    <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] !='admin' && 'admin' == $card['owner']) : ?> 
                        <a href="buyCard.php?id=<?php echo $key?>" class="buyL">
                            <div class="buy">
                                <span class="card-price"><span class="icon">💰</span> <?php echo $card['price']?></span>
                            </div>
                        </a>
                    <?php elseif(isset($_SESSION['user']) && $_SESSION['user']['username'] == $card['owner']) : ?>
                        <span class="card-price">Owned</span>
                    <?php else : ?>
                        <span class="card-price">Taken</span>
                    <?php endif?>    
                <?php endif?>
                </div>
            </div>
            <?php endif?>
            <?php endforeach ?>
        
    </div>
            
    <footer>
        <p>IKémon | ELTE IK Webprogramozás | Szabó Bence</p>
    </footer>
</body>

</html>