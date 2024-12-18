<?php
if (isset($_POST["register"])) {
    $errors = [];

    $full_name = trim($_POST['full_name']);
    if (empty($full_name)) {
        $errors[] = "Полное имя обязательно.";
    }

    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $errors[] = "Введите корректный email.";
    }

    $username = preg_replace('/[^a-zA-Z0-9_]/', '', trim($_POST['username']));
    if (empty($username)) {
        $errors[] = "Имя пользователя обязательно.";
    }

    $password = trim($_POST['password']);
    if (empty($password)) {
        $errors[] = "Пароль обязателен.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Пароль должен содержать не менее 8 символов.";
    }

    if (empty($errors)) {
        try {
            $connection = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $connection->prepare("SELECT COUNT(*) FROM usertbl WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetchColumn() > 0) {
                $errors[] = "Имя пользователя уже существует.";
            } else {
                $stmt = $connection->prepare("SELECT COUNT(*) FROM usertbl WHERE email = ?");
                $stmt->execute([$email]);
                if ($stmt->fetchColumn() > 0) {
                    $errors[] = "Email уже существует.";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $connection->prepare("INSERT INTO usertbl (full_name, email, username, password) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$full_name, $email, $username, $hashed_password]);

                    echo "<p class='success'>Регистрация прошла успешно!</p>";
                }
            }
        } catch (PDOException $e) {
            $errors[] = "Ошибка базы данных: " . $e->getMessage();
        }
    }
    if (!empty($errors)) {
        echo "<ul class='error'>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul>";
    }
}
?>

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
                <label for="full_name">Полное имя:</label>
                <input type="text" name="full_name" class="form-control" id="full_name" placeholder="Полное имя" required>
            </div>
            <div class="form-group">
                <label for="username">Имя пользователя:</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="Имя пользователя" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Введите email" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Пароль" required>
            </div>
            <div class="form-group">
                <button type="submit" name="register" class="btn btn-info btn-lg btn-block">Зарегистрироваться</button>
            </div>
            <p class="text-center">Уже зарегистрированы? <a href="login.php" class="btn btn-info">Войдите в систему</a></p>
        </form>
    </div>
</body>

</html>

<?php include("includes/footer.php"); ?>
