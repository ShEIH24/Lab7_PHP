<?php
// запуск сессии
session_start();

// переменные для сообщений об ошибках и успехе
$error = '';
$success = '';

// обработка отправки формы регистрации
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // валидация введенных данных
    if (empty($username) || empty($email) || empty($password)) {
        $error = 'Все поля обязательны для заполнения';
    } elseif (strlen($username) < 3) {
        $error = 'Логин должен содержать минимум 3 символа';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Неверный формат email';
    } elseif (strlen($password) < 6) {
        $error = 'Пароль должен содержать минимум 6 символов';
    } elseif ($password !== $confirm_password) {
        $error = 'Пароли не совпадают';
    } else {
        // чтение существующих пользователей из файла
        $users = [];
        if (file_exists('users.json')) {
            $users = json_decode(file_get_contents('users.json'), true) ?? [];
        }

        // проверка существования пользователя с таким логином или email
        $userExists = false;
        foreach ($users as $user) {
            if ($user['username'] === $username || $user['email'] === $email) {
                $userExists = true;
                break;
            }
        }

        if ($userExists) {
            $error = 'Пользователь с таким логином или email уже существует';
        } else {
            // создание нового пользователя и сохранение в файл
            $newUser = [
                'id' => uniqid(),
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $users[] = $newUser;
            file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            $success = 'Регистрация успешна! Теперь вы можете войти';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
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
        <h2>Регистрация</h2>
        <p class="text-muted">Создайте новый аккаунт</p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success" role="alert">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="username" class="form-label">Логин</label>
            <input type="text" class="form-control" id="username" name="username"
                   required minlength="3" maxlength="50"
                   value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email"
                   required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" class="form-control" id="password" name="password"
                   required minlength="6">
            <small class="text-muted">Минимум 6 символов</small>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">Подтвердите пароль</label>
            <input type="password" class="form-control" id="confirm_password"
                   name="confirm_password" required minlength="6">
        </div>

        <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
    </form>

    <div class="auth-link">
        Уже есть аккаунт? <a href="login.php">Войти</a>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>