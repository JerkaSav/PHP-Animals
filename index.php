<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



$dbh = new PDO('mysql:host=localhost;dbname=zoo;port=3306;charset=utf8;', "animals", "animals");

$query = "SELECT name FROM animals WHERE ':id' < 10";
$statement = $dbh->prepare($query, array(PDO::FETCH_ASSOC));
$statement->execute(array(':id' => 10));
$result = $statement->fetchAll();

foreach ($result as $animal) {
    echo $animal['name'] . "<br />";
}
