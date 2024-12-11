<?php

if (isset($_POST["register"])) {

    if (!empty($_POST['full_name']) && !empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        
        $full_name = htmlspecialchars($_POST['full_name']);
        $email = htmlspecialchars($_POST['email']);
        $username = htmlspecialchars($_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Шифрование пароля

        $connection = mysqli_connect("localhost", "username", "password", "database");

        if (!$connection) {
            die("Ошибка подключения: " . mysqli_connect_error());
        }

        $stmt = mysqli_prepare($connection, "SELECT * FROM usertbl WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $numrows = mysqli_num_rows($result);

        if ($numrows == 0) {
            $sql = "INSERT INTO usertbl (full_name, email, username, password) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $full_name, $email, $username, $password);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                $message = "Вы успешно создали пользователя";
            } else {
                $message = "ОШИБКА!";
            }
        } else {
            $message = "Имя пользователя уже создано";
        }

        mysqli_close($connection); // Закрытие соединения
    } else {
        $message = "Вы не ввели все необходимые поля!";
    }
}
?>

<?php if (!empty($message)) { echo "<p class='error'>" . "MESSAGE: " . $message . "</p>"; } ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация</title>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Регистрация</h2>
        <form method="POST">
            <div class="form-group">
                <label for="username">Имя пользователя:</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="User Name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <button type="submit" name="register" class="btn btn-info btn-lg btn-block">Зарегистрироваться</button>
            </div>
            <p class="text-center">Уже зарегистрированы? <a href="login.html" class="btn btn-info">Войдите в систему</a></p>
        </form>
    </div>
</body>

</html>

<?php include("includes/footer.php"); ?>