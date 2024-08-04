<?php

    include_once('storage.php');
    include 'util.php';
    session_start();
    $storage1 = new Storage(new JsonIO('cards.json'));
    $storage2 = new Storage(new JsonIO('users.json'));
    $card = $storage1->findById($_GET['id']);
    $cards = $storage1->findAll();
    $users = $storage2->findAll();
    $user = $storage2->findById($_SESSION['user']['id']);


    $price = (int)($card['price']*0.9);
    
    $upUser = $user;
    $updated = $card;

    $upUser['money'] += $price; 
    $_SESSION['user'] = $upUser;
    $users = $storage2 -> update($user['id'], $upUser);
    $updated['owner'] = "admin";
    $cards = $storage1-> update($_GET['id'], $updated);

    redirect('index.php');
?>