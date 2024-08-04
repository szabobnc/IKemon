<?php

function redirect($page) {
    header("Location: $page");
    exit();
}

function logout(){
    session_destroy();
}