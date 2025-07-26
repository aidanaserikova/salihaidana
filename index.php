<?php
session_start();
require_once 'conn.php'; 

$loginError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUsername = $_POST['username'] ?? '';
    $inputPassword = $_POST['password'] ?? '';
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $inputUsername);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && $inputPassword === $user['password']) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['username'];
        header('Location: main.php'); 
        exit;
    } else {
        $loginError = 'Şifreni mi unuttun? Bu, ilk kez buluştuğumuz yer ve tarih.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salih&Aidana</title>
    <link rel="icon" type="image/png" href="images/pink.gif">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: rgba(255, 255, 255, 0.9);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 350px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background-color: #a2d5f2;
            border-radius: 50%;
            opacity: 0.3;
        }

        .login-container::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 100px;
            height: 100px;
            background-color: #ff9a9e;
            border-radius: 50%;
            opacity: 0.3;
        }

        h1 {
            color: #ff6b81;
            margin-bottom: 30px;
            font-size: 28px;
            position: relative;
            z-index: 1;
        }

        .heart {
            color: #ff6b81;
            font-size: 24px;
            margin: 0 5px;
        }

        .input-group {
            margin-bottom: 25px;
            position: relative;
        }

        .input-group input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #ddd;
            border-radius: 50px;
            font-size: 16px;
            transition: all 0.3s;
            box-sizing: border-box;
            background-color: #f8f9fa;
        }

        .input-group input:focus {
            border-color: #a2d5f2;
            outline: none;
            box-shadow: 0 0 10px rgba(162, 213, 242, 0.5);
        }

        .input-group label {
            position: absolute;
            left: 20px;
            top: 15px;
            color: #999;
            transition: all 0.3s;
            pointer-events: none;
        }

        .input-group input:focus + label,
        .input-group input:valid + label {
            top: -10px;
            left: 15px;
            font-size: 12px;
            background-color: white;
            padding: 0 5px;
            color: #a2d5f2;
        }

        button {
            background: linear-gradient(to right, #ff6b81, #a2d5f2);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(162, 213, 242, 0.4);
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(162, 213, 242, 0.6);
        }

        .forgot-password {
            margin-top: 20px;
            font-size: 14px;
        }

        .forgot-password a {
            color: #a2d5f2;
            text-decoration: none;
            transition: color 0.3s;
        }

        .forgot-password a:hover {
            color: #ff6b81;
        }

        .love-decoration {
            position: absolute;
            font-size: 20px;
            color: #ff6b81;
            opacity: 0.5;
        }

        .love1 { top: 10px; left: 20px; }
        .love2 { top: 30px; right: 25px; }
        .love3 { bottom: 40px; left: 30px; }
        .love4 { bottom: 20px; right: 40px; }
        
        .error-message {
            color: #ff6b81;
            margin-top: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <span class="love-decoration love1">❤</span>
        <span class="love-decoration love2">❤</span>
        <span class="love-decoration love3">❤</span>
        <span class="love-decoration love4">❤</span>
        
        <h1>Seni çok özledim <span class="heart">❤</span></h1>
        
        <form id="loginForm" method="POST">
            <div class="input-group">
                <input type="text" id="username" name="username" required>
                <label for="username">Kullanıcı adı</label>
            </div>
            
            <div class="input-group">
                <input type="password" id="password" name="password" required>
                <label for="password">Şifre</label>
            </div>
            
            <button type="submit">Giriş <span class="heart">❤</span></button>
            
            <?php if (!empty($loginError)): ?>
                <div class="error-message"><?php echo htmlspecialchars($loginError); ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>