<?php

function sessionStatus() {
    
    if (isset($_SESSION['success'])) {
        echo "<p class= 'success'>" . $_SESSION['success'] . "</p>";

        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo "<p class='error' style = '    display: box;
    color: red;
    text-align : center;
    font-weight: bold;
    font-size: 17px; 
    margin-bottom: 7px;'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }

}