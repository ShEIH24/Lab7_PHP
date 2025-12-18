<?php
// запуск сессии для работы с данными пользователя
session_start();

// проверка авторизации пользователя
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// сохранение текущей страницы как последней посещенной
$_SESSION['last_page'] = 'a.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Краснодар - Страница А</title>
    <link href="style1.css" rel="stylesheet" type="text/css" media="all" />
    <style>
        /* стили для панели пользователя */
        .user-panel {
            background: rgba(255, 255, 255, 0.95);
            padding: 10px 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .user-panel .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .user-name {
            font-weight: 600;
            color: #764ba2;
        }
        .nav-buttons {
            display: flex;
            gap: 10px;
        }
        .nav-buttons a, .nav-buttons button {
            padding: 8px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .btn-page {
            background: #667eea;
            color: white;
        }
        .btn-page:hover {
            background: #764ba2;
            transform: translateY(-2px);
        }
        .btn-logout {
            background: #f5576c;
            color: white;
        }
        .btn-logout:hover {
            background: #dc3545;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
<!-- панель пользователя -->
<div class="user-panel">
    <div class="container">
        <div class="user-info">
            <span class="user-name">Привет, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <span class="text-muted">Вы на странице А</span>
        </div>
        <div class="nav-buttons">
            <a href="b.php" class="btn-page">Перейти на страницу Б</a>
            <form method="POST" action="logout.php" style="margin: 0;">
                <button type="submit" class="btn-logout">Выйти</button>
            </form>
        </div>
    </div>
</div>

<header>
    <nav class="container">
        <div class="logo">BaDroH</div>
        <ul class="nav-links">
            <li><a href="#home">Главная</a></li>
            <li><a href="#history">История</a></li>
            <li><a href="#infrastructure">Инфраструктура</a></li>
            <li><a href="#culture">Культура</a></li>
        </ul>
    </nav>
</header>
<main class="container">
    <div id="home" class="page nav-content">
        <h1>Краснодар - Южная столица России</h1>

        <p style="font-size: 1.2rem; text-align: center; margin-bottom: 2rem; color: #666;">
            Краснодар — административный центр Краснодарского края, крупнейший экономический и культурный центр Северного Кавказа. Город с богатой историей, современной инфраструктурой и уникальной атмосферой южного гостеприимства.
        </p>

        <div class="photo-grid">
            <div class="photo-item">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4d/Krasnodar_teatr.jpg/1599px-Krasnodar_teatr.jpg" alt="Центр Краснодара">
                <div class="photo-caption">Центральная часть города</div>
            </div>
            <div class="photo-item">
                <img src="https://cdn.tripster.ru/photos/6aedd86e-036a-46bc-acfd-2b6380c0b631.jpg" alt="Парк">
                <div class="photo-caption">Парк Галицкого</div>
            </div>
            <div class="photo-item">
                <img src="https://avatars.dzeninfra.ru/get-zen_doc/271828/pub_6851644abc48c83f9135f7d4_68516495bed6096951411ab7/scale_1200" alt="Архитектура">
                <div class="photo-caption">Красная улица</div>
            </div>
            <div class="photo-item">
                <img src="https://d.searchengines.guru/3/398/0dnfejrf2x4o13__a92ea4f0.jpg" alt="Фонтан">
                <div class="photo-caption">Инфраструктура</div>
            </div>
            <div class="photo-item">
                <img src="https://krd.ru/upload/resize_cache/iblock/8e5/misthar29aiz0w68fcsu0898zbm2sp98/1284_720_2/teatrm.jpg" alt="Театр">
                <div class="photo-caption">Краснодарский академический театр драмы имени М. Горького</div>
            </div>
            <div class="photo-item">
                <img src="https://tvkrasnodar.ru/upload/iblock/0ef/0ef4e4c30a21742e454e7306f584e049.jpg" alt="Стадион">
                <div class="photo-caption">Стадион Краснодар</div>
            </div>
        </div>

        <div class="news-block">
            <h2>Актуальные события</h2>
            <div class="news-item">
                <h3>Фестиваль «Кубанская ярмарка»</h3>
                <p>В центре города проходит традиционный фестиваль кубанской культуры с выставкой народных промыслов, концертами и дегустацией местных продуктов.</p>
            </div>
            <div class="news-item">
                <h3>Открытие нового культурного центра</h3>
                <p>На ул. Красной открылся современный культурный центр с выставочными залами, театральной студией и образовательными программами.</p>
            </div>
            <div class="news-item">
                <h3>Реконструкция парка Горького</h3>
                <p>Завершается масштабная реконструкция центрального парка города с обновлением инфраструктуры и созданием новых зон отдыха.</p>
            </div>
        </div>
    </div>
</main>
</body>
</html>