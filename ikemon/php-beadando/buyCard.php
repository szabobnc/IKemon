<?php
include_once('storage.php');
include 'util.php';
session_start();
$storage = new Storage(new JsonIO('cards.json'));
$storage2 = new Storage(new JsonIO('users.json'));
$card = $storage->findById($_GET['id']);
$cards = $storage->findAll();
$users = $storage2->findAll();
$user = $storage2->findById($_SESSION['user']['id']);


$upUser = $user;
$updated = $card;
$s = numOfCards($_SESSION['user']['username'], $cards);
if($_SESSION['user']['money'] > $card['price'] && (int)$s < (int)"5"){
    $upUser['money'] -= $card['price']; 
    $_SESSION['user'] = $upUser;
    $users = $storage2 -> update($user['id'], $upUser);
    $updated['owner'] = $_SESSION['user']['username'];
    $cards = $storage-> update($_GET['id'],$updated);
}

function numOfCards($username, $cards){
    $sum = '0';
    foreach($cards as $c){
        if($c['owner'] == $username){
            $sum++;
        }
    }
    return (int)$sum;
}
redirect('index.php');

?>