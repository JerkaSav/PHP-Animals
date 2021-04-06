<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$selectedName = str_replace('-', ' ', $_POST['animals']);
$dbh = new PDO('mysql:host=localhost;dbname=zoo;port=3306;charset=utf8;', "animals", "animals");

$query = "SELECT * FROM animals WHERE ':id' < 10";
$statement = $dbh->prepare($query, array(PDO::FETCH_ASSOC));
$statement->execute(array(':id' => 10));
$result = $statement->fetchAll();


$querySelectByName = 'SELECT * FROM animals WHERE name = ?';
$statementByName = $dbh->prepare($querySelectByName, array(PDO::FETCH_ASSOC));
$statementByName->execute(array($selectedName));
$resultByName = $statementByName->fetchAll()
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
  <label for="names-animals">Välj ett djur</label>
  <form action="" method="post">
    <select id="names-animals" name='animals'>
      <?php
          foreach ($result as $animal) {
              if ($animal['name'] == $selectedName) {
                  echo
              '<option Selected value='
              .str_replace(' ', '-', $animal['name'])
              .'>'
              .$animal['name']
              .'</option>';
              } else {
                  echo
              '<option value='
              .str_replace(' ', '-', $animal['name'])
              .'>'
              .$animal['name']
              .'</option>';
              }
          }
          ?>
      <input type="submit" value="submit">
      <?php echo str_replace('-', ' ', $_POST['animals']) ?>
    </select>
  </form>
  <table>
    <tr>
      <th>
        #
      </th>
      <th>
        Namn
      </th>
      <th>
        Kategori
      </th>
      <th>
        Födelsedag
      </th>
      <th>
        Bild Url
      </th>
    </tr>
    <?php
          foreach ($resultByName as $animal) {
              echo '<tr>'
              .'<td>'.$animal['id'] .'</td>'
              .'<td>'.$animal['name'] .'</td>'
              .'<td>'.$animal['category'] .'</td>'
              .'<td>'.$animal['birthday'] .'</td>'
              .'<td>'.$animal['img'] .'</td>'
              .'</tr>';
          }
          ?>

  </table>

  <table>
    <tr>
      <th>
        #
      </th>
      <th>
        Namn
      </th>
      <th>
        Kategori
      </th>
      <th>
        Födelsedag
      </th>
      <th>
        Bild Url
      </th>
    </tr>
    <?php
          foreach ($result as $animal) {
              echo '<tr>'
              .'<td>'.$animal['id'] .'</td>'
              .'<td>'.$animal['name'] .'</td>'
              .'<td>'.$animal['category'] .'</td>'
              .'<td>'.$animal['birthday'] .'</td>'
              .'<td>'.$animal['img'] .'</td>'
              .'</tr>';
          }
          ?>

  </table>
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
    margin-bottom: 50px;
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
</style>

</html>