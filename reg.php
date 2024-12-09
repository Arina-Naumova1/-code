<?php

if (isset($_POST["register"])) {

    if (!empty($_POST['full_name']) && !empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        
        $full_name = htmlspecialchars($_POST['full_name']);
        $email = htmlspecialchars($_POST['email']);
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        $connection = mysqli_connect("localhost", "username", "password", "database");

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
    } else {
        $message = "Вы не ввели логин или пароль!"; //добавить хэширование
    }
}
?>
 

<?php if (!empty($message)) { echo "<p class='error'>" . "MESSAGE: " . $message . "</p>"; } ?>