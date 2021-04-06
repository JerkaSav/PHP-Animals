<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



$dbh = new PDO('mysql:host=localhost;dbname=zoo;port=3306;charset=utf8;', "animals", "animals");

$query = "SELECT name FROM animals WHERE ':id' < 10";
$statement = $dbh->prepare($query, array(PDO::FETCH_ASSOC));
$statement->execute(array(':id' => 10));
$result = $statement->fetchAll();




?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Animals</title>
</head>

<body>
  <table>
    <tr>
      <th>
        Namn
      </th>
    </tr>
    <?php
          foreach ($result as $animal) {
              echo '<tr>'
              .'<td>'.$animal['name'] .'</td>'
              .'</tr>';
          }
          ?>

  </table>
  </div>
</body>
<style>
  table,
  th,
  td {
    border: 1px solid black;
    border-collapse: collapse;
  }

  th,
  td {
    padding: 15px;
  }

  th {
    text-align: left;
  }

  table {
    border-spacing: 5px;
    width: 500px;
  }

  table tr:nth-child(even) {
    background: #eee;
  }

  table tr:nth-child(odd) {
    background: #fff;
  }

  table th {
    background: #666666;
    color: white;
  }

  .flex {
    display: flex;

  }

  div {
    margin: 10px;
  }

  .max-pris {
    margin-left: 20px;
  }

  form {
    display: flex;
    flex-direction: column;
    margin-bottom: 10px;
  }
</style>

</html>