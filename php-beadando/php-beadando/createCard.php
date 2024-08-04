<?php
include_once 'storage.php';
include 'util.php';
$storage = new Storage(new JsonIO('cards.json'));
$cards = $storage->findAll();
$error = [];
if(array_key_exists('add', $_POST)) { 
    if(isset($_POST['type']) &&
        $_POST['type'] != 'def' &&
        !empty($_POST['name']) &&
        !empty($_POST['hp']) &&
        !empty($_POST['attack']) &&
        !empty($_POST['defense']) &&
        !empty($_POST['price']) &&
        !empty($_POST['img'])){
            $card_data = [
                'name' => $_POST['name'],
                'type' => $_POST['type'],
                'hp' => $_POST['hp'],
                'attack' => $_POST['attack'],
                'defense' => $_POST['defense'],
                'price' => $_POST['price'],
                'description' => $_POST['desc'],
                'image' => $_POST['img'],
                'owner' => "admin"
            ];
            $cards = $storage->add($card_data);
            redirect('userProfile.php');
        } else array_push($error, "Please fill every field");
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IKémon | New card</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/cards.css">
</head>

<body>
    <header>
        <h1>IKémon</h1>
        <ul>
            <li> <a href="index.php">Home</a></li>
            <li> <a href="userProfile.php">Profile</a></li>
            </ul>
    </header>
    <div class="content">
    <?php if($error != []) : ?>
        <div class="error">
            <?php foreach($error as $e) : ?>
                <div>
                    <?php echo $e?>
                </div>
            <?php endforeach?>
        </div>
    <?php endif?>
           
            
        <form method="post" class="input">
                <div>
                    <label for="type">Type:</label>
                    <select name="type" id="type">
                        <option value="def">Choose type here</option>
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
                </div>
                <div>
                    <label for="name">Name: </label><br>
                    <input type="text" name="name" id="name" value="<?= $_POST['name'] ?? ''?>">
                </div>
                <div>
                    <label for="hp">Health: </label><br>
                    <input type="number" min="0" name="hp" id="hp" value="<?= $_POST['hp'] ?? ''?>">
                </div>
                <div>
                    <label for="attack">Attack: </label><br>
                    <input type="number" min="0" name="attack" id="attack" value="<?= $_POST['attack'] ?? ''?>">
                </div>
                <div>
                    <label for="defense">Defense: </label><br>
                    <input type="number" min="0" name="defense" id="defense" value="<?= $_POST['defense'] ?? ''?>">
                </div>
                <div>
                    <label for="price">Price: </label><br>
                    <input type="number" min="0" name="price" id="price" value="<?= $_POST['price'] ?? ''?>">
                </div>
                <div>
                    <label for="desc">Description: </label><br>
                    <textarea type="text" name="desc" id="desc" value="<?= $_POST['desc'] ?? ''?>">Type description here...</textarea>
                </div>
                <div>
                    <label for="img">Image: </label><br>
                    <input type="url" name="img" id="img" value="<?= $_POST['img'] ?? ''?>">
                </div>
                <div>
                    <button type="submit" name="add">Add to collection</button>
                </div>
        </form>
    </div>
</body>