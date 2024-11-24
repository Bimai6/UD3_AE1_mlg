<form action="login.php" method="post">
    <div>
        <label for="username">Nombre de usuario:</label>
        <input type="text" id="username" name="username">
    </div>
    <div>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password">
    </div>
    <input type="submit" value="Iniciar sesión">
    <?php
if (isset($_GET['error'])) {
    echo "<p>Error: " . htmlspecialchars($_GET['error']) . "</p>";
}
?>
</form>