<?php
// запуск сессии для работы с данными пользователя
session_start();

// проверка авторизации пользователя
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// сохранение текущей страницы как последней посещенной
$_SESSION['last_page'] = 'b.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Интернет-магазин авиабилетов - покупайте билеты онлайн">
    <title>Авиабилеты - Страница Б</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="style2.css" rel="stylesheet" type="text/css" media="all" />
    <style>
        /* стили для панели пользователя */
        .user-panel-top {
            background: white;
            padding: 10px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .user-panel-content {
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
<div class="user-panel-top">
    <div class="container">
        <div class="user-panel-content">
            <div class="user-info">
                <span class="user-name">Привет, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                <span class="text-muted">Вы на странице Б</span>
            </div>
            <div class="nav-buttons">
                <a href="a.php" class="btn-page">Перейти на страницу А</a>
                <form method="POST" action="logout.php" style="margin: 0;">
                    <button type="submit" class="btn-logout">Выйти</button>
                </form>
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#home">Авиабилеты</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#home">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#catalog">Каталог</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">О нас</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contacts">Контакты</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- главная страница -->
<section id="home">
    <!-- баннер -->
    <div class="hero-section">
        <div class="container">
            <h1>Найдите идеальный авиабилет</h1>
            <p class="lead">Более 1000 направлений по всему миру. Лучшие цены гарантированы!</p>
        </div>
    </div>

    <!-- форма поиска -->
    <div class="container">
        <div class="search-form fade-in">
            <h3 class="text-center mb-4">Поиск авиабилетов</h3>
            <form>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="from" class="form-label">Откуда</label>
                        <input type="text" class="form-control" id="from" placeholder="Москва" required pattern="[А-Яа-яA-Za-z\s]{2,50}">
                    </div>
                    <div class="col-md-6">
                        <label for="to" class="form-label">Куда</label>
                        <input type="text" class="form-control" id="to" placeholder="Париж" required pattern="[А-Яа-яA-Za-z\s]{2,50}">
                    </div>
                    <div class="col-md-4">
                        <label for="date-from" class="form-label">Дата вылета</label>
                        <input type="date" class="form-control" id="date-from" required min="2025-10-10">
                    </div>
                    <div class="col-md-4">
                        <label for="date-to" class="form-label">Дата возврата</label>
                        <input type="date" class="form-control" id="date-to" min="2025-10-10">
                    </div>
                    <div class="col-md-4">
                        <label for="passengers" class="form-label">Пассажиры</label>
                        <input type="number" class="form-control" id="passengers" value="1" min="1" max="9" required>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Найти билеты</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- популярные направления -->
    <section class="content-section">
        <div class="container">
            <h2 class="text-center mb-5">Популярные направления</h2>
            <div class="row">
                <div class="col-md-4">
                    <article class="card destination-card">
                        <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=800" alt="Париж">
                        <div class="card-body">
                            <h5 class="card-title">Париж</h5>
                            <p class="card-text">От 15 000 ₽</p>
                            <a href="#catalog" class="btn btn-primary">Подробнее</a>
                        </div>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="card destination-card">
                        <img src="https://images.unsplash.com/photo-1513581166391-887a96ddeafd?w=800" alt="Лондон">
                        <div class="card-body">
                            <h5 class="card-title">Лондон</h5>
                            <p class="card-text">От 18 000 ₽</p>
                            <a href="#catalog" class="btn btn-primary">Подробнее</a>
                        </div>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="card destination-card">
                        <img src="https://images.unsplash.com/photo-1546412414-e1885259563a?w=800" alt="Дубай">
                        <div class="card-body">
                            <h5 class="card-title">Дубай</h5>
                            <p class="card-text">От 25 000 ₽</p>
                            <a href="#catalog" class="btn btn-primary">Подробнее</a>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- преимущества -->
    <section class="content-section bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Почему выбирают нас</h2>
            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="feature-icon">💰</div>
                    <h4>Лучшие цены</h4>
                    <p>Гарантируем самые выгодные предложения на рынке</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="feature-icon">🔒</div>
                    <h4>Безопасность</h4>
                    <p>Защищенные платежи и конфиденциальность данных</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="feature-icon">⚡</div>
                    <h4>Быстро и удобно</h4>
                    <p>Бронирование за 5 минут, билеты на email</p>
                </div>
            </div>
        </div>
    </section>
</section>

<!-- каталог -->
<section id="catalog" class="content-section">
    <div class="container">
        <header class="page-header">
            <h1>Каталог авиабилетов</h1>
            <p class="lead">Все доступные направления</p>
        </header>

        <div class="row">
            <div class="col-md-6">
                <article class="ticket-card">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4>Москва → Париж</h4>
                            <p class="mb-1">🛫 Вылет: 15 октября, 10:00</p>
                            <p class="mb-1">🛬 Прилет: 15 октября, 13:30</p>
                            <p class="mb-0">⏱️ В пути: 4ч 30мин</p>
                        </div>
                        <div class="col-4 text-end">
                            <div class="price-tag">15 000 ₽</div>
                            <button class="btn btn-primary mt-2">Купить</button>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-md-6">
                <article class="ticket-card">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4>Москва → Лондон</h4>
                            <p class="mb-1">🛫 Вылет: 16 октября, 14:00</p>
                            <p class="mb-1">🛬 Прилет: 16 октября, 17:00</p>
                            <p class="mb-0">⏱️ В пути: 4ч 00мин</p>
                        </div>
                        <div class="col-4 text-end">
                            <div class="price-tag">18 000 ₽</div>
                            <button class="btn btn-primary mt-2">Купить</button>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<!-- о нас -->
<section id="about" class="about-section bg-light">
    <div class="container">
        <header class="page-header">
            <h1>О нас</h1>
            <p class="lead">Мы делаем путешествия доступными</p>
        </header>

        <div class="row mb-5">
            <div class="col-lg-6">
                <h3>Наша миссия</h3>
                <p>Это ведущий онлайн-сервис по продаже авиабилетов. Мы работаем с 2010 года и помогли более миллиону пассажиров найти идеальные билеты по лучшим ценам.</p>
                <p>Наша цель - сделать путешествия простыми, доступными и приятными для каждого клиента.</p>
            </div>
            <div class="col-lg-6">
                <h3>Наши преимущества</h3>
                <ul>
                    <li>Партнерство с 500+ авиакомпаниями</li>
                    <li>Круглосуточная поддержка клиентов</li>
                    <li>Гарантия лучшей цены</li>
                    <li>Простое бронирование за 5 минут</li>
                    <li>Безопасные онлайн-платежи</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- контакты -->
<section id="contacts" class="content-section">
    <div class="container">
        <header class="page-header">
            <h1>Контакты</h1>
            <p class="lead">Свяжитесь с нами удобным способом</p>
        </header>

        <div class="row mb-5">
            <div class="col-md-4">
                <div class="contact-info text-center">
                    <div class="contact-icon mx-auto">📞</div>
                    <h5>Телефон</h5>
                    <p><a href="tel:+79491234567">+7 (949) 123-45-67</a></p>
                    <p class="text-muted">Пн-Вс: 00:00 - 24:00</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-info text-center">
                    <div class="contact-icon mx-auto">📧</div>
                    <h5>Email</h5>
                    <p><a href="mailto:info@aviabilety.ru">info@aviabilety.ru</a></p>
                    <p class="text-muted">Ответим в течение 24 часов</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-info text-center">
                    <div class="contact-icon mx-auto">📍</div>
                    <h5>Адрес</h5>
                    <p>г. Донецк, пр. Театральный, д. 13</p>
                    <p class="text-muted">Офис открыт: Пн-Пт 9:00-18:00</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- футер -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>Авиабилеты</h5>
                <p>Ваш надежный партнер в мире путешествий с 2025 года.</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Ссылки</h5>
                <ul class="list-unstyled">
                    <li><a href="#home">Главная</a></li>
                    <li><a href="#catalog">Каталог</a></li>
                    <li><a href="#about">О нас</a></li>
                    <li><a href="#contacts">Контакты</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Контакты</h5>
                <p>Телефон: +7 (949) 123-45-67</p>
                <p>Email: info@aviabilety.ru</p>
                <p>Адрес: г. Донецк, пр. Театральный, д. 13</p>
            </div>
        </div>
        <div class="text-center mt-4 pt-4" style="border-top: 1px solid rgba(255,255,255,0.1);">
            <p>&copy; 2025 Авиабилеты. Все права защищены.</p>
        </div>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>