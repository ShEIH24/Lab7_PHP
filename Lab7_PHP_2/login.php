<?php
// запуск сессии
session_start();

// если пользователь уже авторизован перенаправляем на главную
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// переменная для сообщений об ошибках
$error = '';

// обработка отправки формы входа
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // базовая валидация
    if (empty($username) || empty($password)) {
        $error = 'Все поля обязательны для заполнения';
    } else {
        // чтение пользователей из файла
        $users = [];
        if (file_exists('users.json')) {
            $users = json_decode(file_get_contents('users.json'), true) ?? [];
        }

        // поиск пользователя и проверка пароля
        $userFound = false;
        foreach ($users as $user) {
            if ($user['username'] === $username && password_verify($password, $user['password'])) {
                // сохранение данных пользователя в сессию
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];

                $userFound = true;

                // перенаправление на главную страницу
                header('Location: index.php');
                exit();
            }
        }

        if (!$userFound) {
            $error = 'Неверный логин или пароль';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .auth-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 450px;
            width: 100%;
        }
        .auth-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .auth-header h2 {
            color: #764ba2;
            font-weight: bold;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: transform 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .auth-link {
            text-align: center;
            margin-top: 20px;
        }
        .auth-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        .auth-link a:hover {
            color: #764ba2;
        }
    </style>
</head>
<body>
<div class="auth-container">
    <div class="auth-header">
        <h2>Вход в систему</h2>
        <p class="text-muted">Войдите в свой аккаунт</p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="username" class="form-label">Логин</label>
            <input type="text" class="form-control" id="username" name="username"
                   required value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Войти</button>
    </form>

    <div class="auth-link">
        Нет аккаунта? <a href="reg.php">Зарегистрироваться</a>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>