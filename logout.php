<?php
	session_start();
	unset($_SESSION['session_username']);
	session_destroy();
	header("location:login.php");
?>
<html>
<div id="welcome">
<h2>Вы вышли с сайта</h2>
  <p><a href="login.php">Войти</a> из системы</p>
</div>
</html>