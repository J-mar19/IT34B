<?php 
require_once '../config/config.php';

$_SESSION = [];

session_destroy();

header('Location:' . BASE_URL . '/index.php');
exit;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>