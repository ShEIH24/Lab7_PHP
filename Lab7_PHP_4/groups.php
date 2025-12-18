<?php
// функция для чтения xlsx файла
function readXLSXFile($filename) {
    if (!file_exists($filename)) {
        return ['error' => 'файл не найден'];
    }

    // Используем SimpleXLSX библиотеку (встроенная)
    require_once 'simplexlsx.php';

    if ($xlsx = SimpleXLSX::parse($filename)) {
        $students = [];
        $rows = $xlsx->rows();

        // Пропускаем заголовок
        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            if (count($row) >= 5) {
                $students[] = [
                        'number' => $row[0],
                        'surname' => $row[1],
                        'name' => $row[2],
                        'patronymic' => $row[3],
                        'group' => $row[4]
                ];
            }
        }
        return $students;
    } else {
        return ['error' => SimpleXLSX::parseError()];
    }
}

// функция для чтения csv файла (запасной вариант)
function readCSVFile($filename) {
    $students = [];

    if (!file_exists($filename)) {
        return ['error' => 'файл не найден'];
    }

    $file = fopen($filename, 'r');
    if (!$file) {
        return ['error' => 'не удалось открыть файл'];
    }

    // пропускаем заголовок
    $header = fgetcsv($file, 1000, ';');

    // читаем все строки
    while (($data = fgetcsv($file, 1000, ';')) !== false) {
        if (count($data) >= 5) {
            $students[] = [
                'number' => $data[0],
                'surname' => $data[1],
                'name' => $data[2],
                'patronymic' => $data[3],
                'group' => $data[4]
            ];
        }
    }

    fclose($file);
    return $students;
}

// основная функция чтения
function readGroupList() {
    // пробуем xlsx файл
    if (file_exists('group_list.xlsx')) {
        return readXLSXFile('group_list.xlsx');
    }

    // если нет xlsx, пробуем csv
    if (file_exists('group_list.csv')) {
        return readCSVFile('group_list.csv');
    }

    return ['error' => 'файл группы не найден (ищем group_list.xlsx или group_list.csv)'];
}

// получение параметров фильтрации
$filterName = isset($_GET['filter']) ? trim($_GET['filter']) : '';
$showData = isset($_GET['show']) ? true : false;

// чтение данных при нажатии кнопки
$students = [];
$error = '';

if ($showData) {
    $result = readGroupList();

    if (isset($result['error'])) {
        $error = $result['error'];
    } else {
        $students = $result;

        // применение фильтра по имени
        if (!empty($filterName)) {
            $students = array_filter($students, function($student) use ($filterName) {
                $fullName = $student['surname'] . ' ' . $student['name'] . ' ' . $student['patronymic'];
                return stripos($fullName, $filterName) !== false;
            });
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список группы</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        h1 {
            color: #764ba2;
            margin-bottom: 20px;
            text-align: center;
        }

        .controls {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 20px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            background: #764ba2;
        }

        .filter-input {
            flex: 1;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .filter-input:focus {
            outline: none;
            border-color: #667eea;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            color: black;
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        tr:hover {
            background: #f5f5f5;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .info {
            background: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        .count {
            text-align: center;
            margin-top: 15px;
            color: #666;
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Список группы</h1>

    <?php if ($error): ?>
        <div class="error">
            Ошибка: <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if (!$showData): ?>
        <div class="info">
            Нажмите кнопку "Показать список", чтобы загрузить данные из файла Excel
        </div>
    <?php endif; ?>

    <div class="controls">
        <form method="GET" style="display: flex; gap: 10px; flex: 1; flex-wrap: wrap;">
            <input
                type="text"
                name="filter"
                class="filter-input"
                placeholder="Фильтр по ФИО (например: Иван или Иванов)"
                value="<?php echo htmlspecialchars($filterName); ?>"
            >
            <input type="hidden" name="show" value="1">
            <button type="submit" class="btn">Применить фильтр</button>
        </form>

        <?php if (!$showData): ?>
            <a href="?show=1" class="btn">Показать список</a>
        <?php else: ?>
            <a href="?" class="btn">Скрыть список</a>
        <?php endif; ?>
    </div>

    <?php if ($showData && !empty($students)): ?>
        <table>
            <thead>
            <tr>
                <th>№</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Группа</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['number']); ?></td>
                    <td><?php echo htmlspecialchars($student['surname']); ?></td>
                    <td><?php echo htmlspecialchars($student['name']); ?></td>
                    <td><?php echo htmlspecialchars($student['patronymic']); ?></td>
                    <td><?php echo htmlspecialchars($student['group']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="count">
            Всего студентов: <?php echo count($students); ?>
        </div>
    <?php elseif ($showData && empty($students) && !$error): ?>
        <div class="info">
            По вашему запросу ничего не найдено. Попробуйте изменить фильтр.
        </div>
    <?php endif; ?>
</div>
</body>
</html>