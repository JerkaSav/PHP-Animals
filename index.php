<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



$dbh = new PDO('mysql:host=localhost;dbname=zoo;port=3306;charset=utf8;', "animals", "animals", ) or die($mysqli->connection_error);

$query = "SELECT * FROM animals WHERE ':id' < 10";
$statement = $dbh->prepare($query, array(PDO::FETCH_ASSOC));
$statement->execute(array(':id' => 10));
$result = $statement->fetchAll();


$selectedName = '';
$column = '';
if (isset($_POST['sortByName'])) {
    $selectedName = $_POST['userInput'];
    $column = $_POST['column'];
    if ($column == 'name') {
        $querySelectByName = 'SELECT * FROM animals WHERE name like ?';
    } else {
        $querySelectByName = 'SELECT * FROM animals WHERE category like ?';
    }
    $statementByName = $dbh->prepare($querySelectByName, array(PDO::FETCH_ASSOC));
    $statementByName->execute(array("$selectedName%"));
    $resultByName = $statementByName->fetchAll();
}





// check to see that the file is an image
if (isset($_POST["submit"])) {
    $path_dir = "uploads/";
    $chosen_image = $path_dir . basename($_FILES["uploadedFile"]["name"]);
    $approvedUpload = 1;
    $typeOfImage = strtolower(pathinfo($chosen_image, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["uploadedFile"]["tmp_name"]);
    if ($check !== false) {
        echo "Filen är en bild- " . $check["mime"] . ".";
        $approvedUpload = 1;
    } else {
        echo "Filen är inte en bild.";
        $approvedUpload = 0;
    }
    // File size
    if ($_FILES["uploadedFile"]["size"] > 500000) {
        echo "Nu har du lagt upp en för stor file för våra djur att hantera!";
        $approvedUpload = 0;
    }

    // Limit file type
    if ($typeOfImage != "jpg" && $typeOfImage != "png" && $typeOfImage != "jpeg"
 ) {
        echo "Ledsen, bara JPG-, JPEG-, PNG- & GIF-filer är tillåtna.";
        $approvedUpload = 0;
    }
    // Check if $approvedUpload is set to 0 by an error
    if ($approvedUpload == 0) {
        echo "Ledsen, filen blev inte uppladdad.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $chosen_image)) {
            echo "Filen ". htmlspecialchars(basename($_FILES["uploadedFile"]["name"])). " har blivit uppladdad.";
        } else {
            echo "Något blev fel med uppladdningen.";
        }
    }
}



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
    <select id="names-animals" name='column'>
      <option value='name'>Namn</option>
      <option value='category'>Kategori</option>
      <input type="text" name='userInput'>
      <?php
      
          // foreach ($result as $animal) {
          //     if ($animal['name'] == $selectedName) {
          //         echo
          //     '<option Selected value='
          //     .str_replace(' ', '-', $animal['name'])
          //     .'>'
          //     .$animal['name']
          //     .'</option>';
          //     } else {
          //         echo
          //     '<option value='
          //     .str_replace(' ', '-', $animal['name'])
          //     .'>'
          //     .$animal['name']
          //     .'</option>';
          //     }
          // }
          ?>
      <input type="submit" value="submit" name="sortByName">
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
    </tr>
    <?php
    if (isset($_POST['sortByName'])) {
        foreach ($resultByName as $animal) {
            echo '<tr>'
              .'<td>'.$animal['id'] .'</td>'
              .'<td>'.$animal['name'] .'</td>'
              .'<td>'.$animal['category'] .'</td>'
              .'<td>'.$animal['birthday'] .'</td>'
              .'</tr>';
        }
    }
          ?>

  </table>



  <form action="" method="post" enctype="multipart/form-data">
    Välj en bild att ladda upp:
    <input type="file" name="uploadedFile" id="uploadedFile">
    <input type="submit" value="Ladda upp bild" name="submit">
  </form>


  <img src="<?php
echo $chosen_image
?>">

  </div>

  <table>

    <h2>PHP Formulär</h2>
    <form method="post">
      <label id="name"> Namn:</label><input type="text" name="name">
      <br><br>
      <label id="category"> Kategori:</label><input type="text" name="category">
      <br><br>
      <label id="birthday"> Födelsedag:</label><input type="date" name="birthday">
      <br><br>

      <button type="submit" name="save">save</button>

      <br><br>
    </form>

    <?php
    
if (isset($_POST['save'])) {
    if (!empty($_POST['name']) && !empty($_POST['category']) && !empty($_POST['birthday'])) {
        $name = $_POST['name'];
        $category = $_POST['category'];
        $birthday = $_POST['birthday'];
     
        $query = "insert into animals (name, category, birthday) values(?, ?, ?)";

        $statement = $dbh->prepare($query, array(PDO::FETCH_ASSOC));
        $statement->execute(array($name, $category, $birthday));

        echo "<meta http-equiv='refresh' content='0'>";
    }
}

?>

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
      </tr>
      <?php
          foreach ($result as $animal) {
              echo '<tr>'
              .'<td>'.$animal['id'] .'</td>'
              .'<td>'.$animal['name'] .'</td>'
              .'<td>'.$animal['category'] .'</td>'
              .'<td>'.$animal['birthday'] .'</td>'
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

  .error {
    color: #FF0000;
  }
</style>

</html>