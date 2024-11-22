<? 
inclube(bd.php);

if (isset($_POST['go'])) {

    $login = $_POST['login'];
    $password = $_POST['password'];

    if (!$login || !$password || !$name)
    {
        echo = 'Вы не ввели логин или пароль!';
    }
   if (!error) {

    $query = "INSERT  INTO 'users' ('id', 'login', 'password') VALUES ('NULL', '$login', '$password');";
    mysqli_query($link, $query);
    echo = 'Вы успешно создали пользователя'
   } else { echo $error; exit; }

}


?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Главная</title>
</head>

<body>
    <form method="POST">
        <p>Имя пользователя: <input type="text" name="name" class="form-control" placeholder="User Name"></p>
        <p>Логин: <input type="text" name="login" class="form-control" placeholder="Enter email"></p>
        <p>Пароль: <input type="text" name="password" class="form-control" placeholder="Password"></p>
        <p><input type="submit" name="go" class="btn btn-primary" valua="Сохранить"></p>
        <p>Уже зарегистрированы? <a href="login.html">Войдите в систему</a></p>
    </form>
</body>

</html>