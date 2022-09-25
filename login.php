<?php
$is_invalid = false;

if($_SERVER["REQUEST_METHOD"] === "POST"){
    //Connect to the PHP database file using the database.php file
    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("SELECT * FROM user
            WHERE email = '%s'",
            $mysqli->real_escape_string($_POST["email"]));
            
            $result = $mysqli->query($sql);

            $user = $result->fetch_assoc();

            if ($user) {
                if (password_verify($_POST["password"], $user["password_hash"])) {
                    die("Login Successful");
                }
            }

    $is_invalid = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
<body>
    <h1>Login</h1>
    <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>

    <form method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email"
        value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
        <label for="password">Password</label>
        <input type="password">
        <button>Login</button>
    </form>
</body>