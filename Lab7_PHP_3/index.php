<?php
// получение выбранного стиля из cookies или установка значения по умолчанию
$selectedStyle = isset($_COOKIE['site_style']) ? $_COOKIE['site_style'] : 'style1';

// проверка что выбранный стиль существует
$allowedStyles = ['style1', 'style2', 'style3'];
if (!in_array($selectedStyle, $allowedStyles)) {
    $selectedStyle = 'style1';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная - Выбор стиля оформления</title>
    <link rel="stylesheet" href="<?php echo $selectedStyle; ?>.css">
</head>
<body>
<header class="hero">
    <div class="container">
        <h1 class="hero-title">Стиль</h1>
        <p class="hero-subtitle">Демонстрация смены стилей через cookies</p>
        <a href="setting.php" class="btn btn-primary">Изменить стиль</a>
    </div>
</header>

<main class="container">
    <section>
        <h2>Заголовок первого уровня</h2>
        <p>Это обычный текст для демонстрации. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        <p>Еще один абзац текста с различным содержанием. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
    </section>

    <section>
        <h3>Заголовок второго уровня</h3>
        <p>Демонстрация списков и текстового контента:</p>
        <ul>
            <li>Первый элемент списка</li>
            <li>Второй элемент списка</li>
            <li>Третий элемент списка</li>
        </ul>
    </section>

    <section class="features-grid">
        <div class="feature-card">
            <h3>Карточка 1</h3>
            <p>Пример текста в карточке для демонстрации стилей оформления</p>
        </div>
        <div class="feature-card">
            <h3>Карточка 2</h3>
            <p>Еще один пример текста в другой карточке</p>
        </div>
        <div class="feature-card">
            <h3>Карточка 3</h3>
            <p>И третья карточка для полной демонстрации</p>
        </div>
    </section>

    <section class="current-style">
        <div class="style-info">
            <h3>Текущий стиль</h3>
            <p class="style-name">
                <?php
                $styleNames = [
                        'style1' => 'Стиль 1',
                        'style2' => 'Стиль 2',
                        'style3' => 'Стиль 3'
                ];
                echo $styleNames[$selectedStyle];
                ?>
            </p>
            <p><a href="setting.php">Изменить стиль</a></p>
        </div>
    </section>
</main>
</body>
</html>