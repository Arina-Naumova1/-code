<?php
if(isset($_POST['login'])) {
  $errors = array();
  if(trim($_POST['login']) == '') {
    $errors[] = "Введите логин";
  }
  if(trim($_POST['email']) == '') {
    $errors[] = "Введите Email";
  }
  if(trim($_POST['name']) == '') {
    $errors[] = "Введите Имя";
  }
  if($_POST['password'] == '') {
    $errors[] = "Введите пароль";
  }
  if($_POST['password_2'] != $_POST['password']) {
    $errors[] = "Повторный пароль введен не верно!";
  }
  if (mb_strlen($_POST['name']) < 3 || mb_strlen($_POST['name']) > 50){   
    $errors[] = "Недопустимая длина имени";
  }
  if (strlen($_POST['password']) < 2 || strlen($_POST['password']) > 8){
    $errors[] = "Недопустимая длина пароля (от 2 до 8 символов)";
  }

  $connect = mysqli_connect($dbhost, $dbuser, $dbpassword, $database) or die("Connection Error: " . mysqli_error($connect));
  if (!$connect) {
    die("Connection Error: " . mysqli_connect_error());
  }

  $login = mysqli_real_escape_string($connect, trim($_POST['login']));
  $pass = hash('sha256', trim($_POST['password']));

  $SQL = "SELECT * FROM users WHERE login = '$login'";// AND pass = '$pass'";
  $check_user = mysqli_query($connect, $SQL) or die("Query Error: " . mysqli_error($connect));
  
  if (mysqli_num_rows($check_user) > 0) {
    echo "<h2>Такой пользователь уже существует</h2>";
  } else {
    $SQL = "INSERT INTO users (login, pass) VALUES ('$login', '$pass')";
    $insert = mysqli_query($connect, $SQL) or die("Query Error: " . mysqli_error($connect));
  
    if (!$insert) {
      $_SESSION["messageSQL"] = mysqli_error($connect);
    } else {
      echo "<h2>Учётная запись создана</h2>";
    }
  }

  mysqli_close($connect);
}
?>
