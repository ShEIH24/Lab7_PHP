<?php
// обработка выбора стиля пользователем
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['style'])) {
    $style = $_POST['style'];

    // проверка что выбранный стиль корректный
    $allowedStyles = ['style1', 'style2', 'style3'];
    if (in_array($style, $allowedStyles)) {
        // сохранение стиля в cookies на 30 дней
        setcookie('site_style', $style, time() + (30 * 24 * 60 * 60), '/');

        // перенаправление на главную с обновленным стилем
        header('Location: setting.php?success=1');
        exit();
    }
}

// получение текущего стиля
$currentStyle = isset($_COOKIE['site_style']) ? $_COOKIE['site_style'] : 'style1';

// проверка параметра успешного сохранения
$success = isset($_GET['success']) ? true : false;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Настройки стиля</title>
    <link rel="stylesheet" href="<?php echo $currentStyle; ?>.css">
    <style>
        /* дополнительные стили для страницы настроек */
        .settings-container {
            max-width: 1000px;
            margin: 3rem auto;
            padding: 2rem;
        }

        .success-message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .style-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .style-option {
            border: 3px solid transparent;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .style-option:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .style-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .style-option input[type="radio"]:checked + label {
            border-color: #28a745;
        }

        .style-option label {
            display: block;
            cursor: pointer;
            border: 3px solid #ddd;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .style-preview {
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: bold;
            color: white;
            position: relative;
        }

        .style-preview-1 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .style-preview-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .style-preview-3 {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
        }

        .style-info {
            padding: 1.5rem;
            background: white;
        }

        .style-info h3 {
            margin: 0 0 0.5rem 0;
            font-size: 1.3rem;
        }

        .style-info p {
            margin: 0;
            color: #666;
            font-size: 0.9rem;
        }

        .current-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #28a745;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .submit-btn {
            margin-top: 2rem;
            text-align: center;
        }

        .submit-btn button {
            padding: 1rem 3rem;
            font-size: 1.1rem;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 2rem;
            color: inherit;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            transform: translateX(-5px);
        }
    </style>
</head>
<body>
<header class="hero">
    <div class="container">
        <h1 class="hero-title">Выбор стиля</h1>
        <p class="hero-subtitle">Выберите стиль оформления</p>
    </div>
</header>

<main class="container">
    <div class="settings-container">
        <a href="index.php" class="back-link">← Назад</a>

        <h1>Настройки стиля</h1>

        <?php if ($success): ?>
            <div class="success-message">
                ✓ Стиль изменен! Обновите страницу (F5).
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="style-options">
                <div class="style-option">
                    <input type="radio" name="style" value="style1" id="style1"
                            <?php echo $currentStyle === 'style1' ? 'checked' : ''; ?>>
                    <label for="style1">
                        <div class="style-preview style-preview-1">
                            <?php if ($currentStyle === 'style1'): ?>
                                <span class="current-badge">Текущий</span>
                            <?php endif; ?>
                            Стиль 1
                        </div>
                        <div class="style-info">
                            <h3>Стиль 1</h3>
                            <p>Синий градиент</p>
                        </div>
                    </label>
                </div>

                <div class="style-option">
                    <input type="radio" name="style" value="style2" id="style2"
                            <?php echo $currentStyle === 'style2' ? 'checked' : ''; ?>>
                    <label for="style2">
                        <div class="style-preview style-preview-2">
                            <?php if ($currentStyle === 'style2'): ?>
                                <span class="current-badge">Текущий</span>
                            <?php endif; ?>
                            Стиль 2
                        </div>
                        <div class="style-info">
                            <h3>Стиль 2</h3>
                            <p>Оранжевый градиент</p>
                        </div>
                    </label>
                </div>

                <div class="style-option">
                    <input type="radio" name="style" value="style3" id="style3"
                            <?php echo $currentStyle === 'style3' ? 'checked' : ''; ?>>
                    <label for="style3">
                        <div class="style-preview style-preview-3">
                            <?php if ($currentStyle === 'style3'): ?>
                                <span class="current-badge">Текущий</span>
                            <?php endif; ?>
                            Стиль 3
                        </div>
                        <div class="style-info">
                            <h3>Стиль 3</h3>
                            <p>Темный градиент</p>
                        </div>
                    </label>
                </div>
            </div>

            <div class="submit-btn">
                <button type="submit" class="btn btn-primary">Применить</button>
            </div>
        </form>
    </div>
</main>
</body>
</html>