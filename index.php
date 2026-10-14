<?php
require_once 'config/config.php';

if(isset($_SESSION['user_id'])){
    header('Location: ' . BASE_URL . '/app/' . $_SESSION['user_role'] . '/index.php');
    exit;
}

$error='';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $login = trim($_POST['login'] ?? '');
    $password =$_POST['password'] ?? '';

 $error = 'Invalid login credentials';

    if ($login=== '' || $password === ''){
        //Log Incomplete
        logActivity($pdo,null,$login,'login','failed');
    }else{

    $result = loginUser($pdo,$login,$password);
        
        if(loginUser($pdo,$login,$password)){
            //Log in complete login attempt
            logActivity(
                $pdo,$_SESSION['user_id'],
                $_SESSION['user_email'],
                'login',
                'success'
            );

        
            header('Location: ' . BASE_URL . '/app/' . $_SESSION['user_role'] . '/index.php');
            exit;

            
        }elseif($result=== 'active_session'){
            echo 'This account is already logged in on another device';
            $error = 'This account is already logged in on another device';

        }else{
            $error = 'Invalid login credetials';
        }
    }

}

   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
 <style>
        body { font-family: sans-serif; background: #96bcbc; display: grid; place-items: center; min-height: 100vh; margin: 0; }
        form { background: #ffffff; padding: 30px; border-radius: 12px; width: 320px; box-shadow: 0 8px 30px rgba(0,0,0,.1); }
        label { display: block; font-weight: bold; margin-bottom: 6px; }
        input { width: 100%; padding: 12px; margin-bottom: 18px; border: 1px solid #0b0b0b; border-radius: 8px; box-sizing: border-box; font-size: 1rem; }
        button { width: 100%; padding: 12px; background: #2f5bea; color: #fff; border: 0; border-radius: 8px; font-size: 1rem; font-weight: bold; cursor: pointer; }
    </style>
<body>
    
<form method="POST">
    <label>Username or Email</label>
    <input type="text"
            name="login"
            required>
    <br>
    <br>
    <label>Password</label>
    <input type="password"
            name="password"
            required>
    <br>
    <button type="submit">Sign In</button>
</form>

<?php if(isset($_GET['timeout'])): ?>
    <p>Your session has expired due to inactivity. Please log in agian</p>
    <?php endif; ?>
    
</body>
</html>