<?php echo 'Hello you!';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



$dbh = new PDO('mysql:host=localhost;dbname=zoo;port=3306;charset=utf8;', "animals", "animals");
?>