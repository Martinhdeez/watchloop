<?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $db = new Db();

        $user_id = $_SESSION['user_id'];
        $name = $_POST['title'];
        $description = $_POST['description'];
        $location = $_POST['location'];
        $price = $_POST['price'];

        
    }