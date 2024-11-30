<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP projekt</title>
    <link href="./css/index.css" rel="stylesheet">
</head>

<body>
    <div class="main-container">
        <h1>Send your greetings!</h1>
        <form class="greeting-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <label>Message</label>
            <input name="message" type="text">
            <button type="submit">Send</button>
        </form>
    </div>
</body>

</html>

<?php
require_once 'inc/db.php';

if ($_POST) {
    $message = htmlspecialchars($_POST["message"]);
    if (empty($message)) {
        echo "nothing was sent";
    } else {
        echo "" . $message . "";

        try {
            $db = new Database();

        } catch (Exception $e) {
            echo "" . $e->getMessage() . "";
        }
    }
}
?>