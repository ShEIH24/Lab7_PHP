<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Загрузка файлов</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
        }
        .upload-form {
            border: 2px solid #333;
            padding: 30px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        input[type="file"] {
            margin: 20px 0;
            padding: 10px;
        }
        button {
            padding: 12px 30px;
            font-size: 16px;
            cursor: pointer;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 4px;
        }
        button:hover {
            background-color: #0b7dda;
        }
        .result {
            margin-top: 20px;
            padding: 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
        }
        .error {
            background-color: #f44336;
        }
    </style>
</head>
<body>
<div class="upload-form">
    <h2>Форма загрузки файлов</h2>

    <!-- enctype нужен для отправки файлов -->
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="file" name="uploadfile" required>
        <br>
        <button type="submit" name="upload">Загрузить файл</button>
    </form>

    <?php
    // проверяем была ли отправка файла
    if (isset($_POST['upload']) && isset($_FILES['uploadfile'])) {
        $file = $_FILES['uploadfile'];

        // проверяем не было ли ошибки при загрузке
        if ($file['error'] === UPLOAD_ERR_OK) {
            // папка для загруженных файлов
            $uploadDir = 'uploads/';

            // создаем папку если её нет
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // получаем оригинальное имя файла
            $fileName = basename($file['name']);
            // формируем полный путь для сохранения
            $uploadPath = $uploadDir . $fileName;

            // перемещаем файл из временной папки в нашу
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                echo '<div class="result">';
                echo '<strong>Файл успешно загружен!</strong><br>';
                echo 'Имя файла: ' . htmlspecialchars($fileName) . '<br>';
                echo 'Размер: ' . round($file['size'] / 1024, 2) . ' КБ<br>';
                echo 'Тип: ' . htmlspecialchars($file['type']);
                echo '</div>';
            } else {
                echo '<div class="result error">';
                echo '<strong>Ошибка при сохранении файла!</strong>';
                echo '</div>';
            }
        } else {
            // выводим код ошибки если что-то пошло не так
            echo '<div class="result error">';
            echo '<strong>Ошибка загрузки!</strong><br>';
            echo 'Код ошибки: ' . $file['error'];
            echo '</div>';
        }
    }
    ?>
</div>
</body>
</html>