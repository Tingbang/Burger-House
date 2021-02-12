<?php
    session_start();
    setcookie($cookie_name,$cookie_value,time() - 3600, "/"); //Destroys cookies
    session_destroy();
    header("Location: index.php");
?>