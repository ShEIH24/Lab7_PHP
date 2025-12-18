<?php
// запуск сессии
session_start();

// уничтожение всех данных сессии
session_unset();
session_destroy();

// перенаправление на страницу входа
header('Location: login.php');
exit();
?>