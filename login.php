<table>
  	<tr><tr>
 	<form method="POST"> 
  		<p>POST
  		<p><input type="text" name="login" value="">Логин:</p>
  		<p><input type="text" name="password" value="">Пароль:</p>
  		<p><input type="submit"></p>
 	</form>
 	</tr></td>
 </table>

<?php
echo "<h3>_GET</h3>";
foreach ($_GET as $key => $value) {
	echo "$key = $value<br>";
}


echo "<br><br>";
echo "<h3>_POST</h3>";
foreach ($_POST as $key => $value) {
echo "$key = $value<br>";
}
echo "<br><br>";
echo "<h3>_SERVER</h3>";

foreach ($_SERVER as $key => $value) {
echo "$key = $value<br>";
}
echo "<br><br>";
echo "<h3>_COOKIE</h3>";
foreach ($_COOKIE as $key => $value) {
echo "$key = $value<br>";



}

?>
