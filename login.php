<?
session_start();

$servername = "localhost";
$username = "ivanova.ya.d";
$password = "3227";
$dbname = "ivanova.ya.d";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Соединение не удалось: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Подготовленный запрос для предотвращения SQL-инъекций
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Проверка пароля
        if (password_verify($pass, $row['password'])) {
            // Успешный вход
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $row['username'];
            header("Location: welcome.php");
            exit;
        } else {
            echo "Неверный пароль.";
        }
    } else {
        echo "Пользователь не найден.";
    }
}

$conn->close();
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href=https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css>
    <link rel="stylesheet " type="text/css " href="css/style.css ">
    <meta http-equiv="X-UA-Compatible " content="ie=edge ">
    <title>Главная</title>
</head>

<body>
    <form method="POST ">
        <p>Введите свою почту и пароль.</p>
        <p>Логин: <input type="text " name="login " class="form-control " placeholder="Enter email "></p>
        <p>Пароль: <input type="text " name="password " class="form-control " placeholder="Password "></p>
        <p>Нет аккаунта? <a href="reg.html " class="btn btn-primary btn-lg active " role="button " aria-pressed="true ">Создайте его за минуту</a></p>
    </form>
</body>