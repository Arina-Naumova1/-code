<?php
session_start();

require_once("includes/connection.php");
include("includes/header.php");

if (isset($_SESSION["session_username"])) {
    header("Location: intropage.php");
    exit();
}

if ($conn->connect_error) {
    die("Соединение не удалось: " . $conn->connect_error);
}

if (isset($_POST["login"])) {
    if (!empty($_POST['login']) && !empty($_POST['password'])) { 
        $login = htmlspecialchars($_POST['login']); 
        $password = htmlspecialchars($_POST['password']);
        
        $stmt = $conn->prepare("SELECT password FROM usertbl WHERE username = ?");
        
        if ($stmt) { 
            $stmt->bind_param("s", $login);
            $stmt->execute();
            $stmt->store_result();
            
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($dbpassword);
                $stmt->fetch();
                
                if (password_verify($password, $dbpassword)) {
                    $_SESSION['session_username'] = $login;     
                    header("Location: intropage.php");
                    exit();
                } else {
                    echo "Неверное имя пользователя или пароль!";
                }
            } else {
                echo "Неверное имя пользователя или пароль!";
            }
            
            $stmt->close();
        } else {
            echo "Ошибка выполнения запроса!"; 
        }
    } else {
        echo "Все поля обязательны для заполнения!";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Авторизация</title>
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card" style="width: 24rem;">
            <div class="card-body">
                <h5 class="card-title text-center">Авторизация</h5>
                <form method="POST">
                    <div class="form-group">
                        <label for="login">Логин</label>
                        <input type="text" name="login" class="form-control" id="login" placeholder="Введите имя пользователя" required> 
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Введите пароль" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-info btn-block">Войти</button>
                </form>
                <div class="text-center mt-3">
                    <p>Нет аккаунта? <a href="reg.html" class="btn btn-info">Создайте его за минуту</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php include("includes/footer.php"); ?>
