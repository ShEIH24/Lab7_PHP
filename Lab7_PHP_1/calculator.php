<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Калькулятор</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
        }
        .calculator {
            border: 2px solid #333;
            padding: 20px;
            border-radius: 8px;
        }
        input[type="number"] {
            width: 95%;
            padding: 10px;
            margin: 5px 0;
            font-size: 16px;
        }
        .buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin: 10px 0;
        }
        button {
            padding: 15px;
            font-size: 18px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
        }
        button:hover {
            background-color: #45a049;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            background-color: #f0f0f0;
            border-radius: 4px;
            font-size: 18px;
        }
    </style>
</head>
<body>
<div class="calculator">
    <h2>Калькулятор</h2>
    <form method="POST" action="">
        <input type="number" step="any" name="num1" placeholder="Первое число"
               value="<?php echo isset($_POST['num1']) ? htmlspecialchars($_POST['num1']) : ''; ?>" required>
        <input type="number" step="any" name="num2" placeholder="Второе число"
               value="<?php echo isset($_POST['num2']) ? htmlspecialchars($_POST['num2']) : ''; ?>" required>

        <div class="buttons">
            <button type="submit" name="operation" value="+">+</button>
            <button type="submit" name="operation" value="-">-</button>
            <button type="submit" name="operation" value="*">×</button>
            <button type="submit" name="operation" value="/">÷</button>
        </div>
    </form>

    <?php
    // проверяем отправлена ли форма
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['operation'])) {
        $num1 = floatval($_POST['num1']);
        $num2 = floatval($_POST['num2']);
        $operation = $_POST['operation'];
        $result = 0;
        $error = '';

        // определяем операцию и выполняем вычисление
        switch ($operation) {
            case '+':
                $result = $num1 + $num2;
                $operationSign = '+';
                break;
            case '-':
                $result = $num1 - $num2;
                $operationSign = '-';
                break;
            case '*':
                $result = $num1 * $num2;
                $operationSign = '×';
                break;
            case '/':
                // проверяем деление на ноль
                if ($num2 == 0) {
                    $error = 'Ошибка: деление на ноль!';
                } else {
                    $result = $num1 / $num2;
                }
                $operationSign = '÷';
                break;
            default:
                $error = 'Неизвестная операция';
        }

        // выводим результат или ошибку
        echo '<div class="result">';
        if ($error) {
            echo '<strong>' . htmlspecialchars($error) . '</strong>';
        } else {
            echo '<strong>Результат:</strong><br>';
            echo htmlspecialchars($num1) . ' ' . $operationSign . ' ' . htmlspecialchars($num2) . ' = ' . htmlspecialchars($result);
        }
        echo '</div>';
    }
    ?>
</div>
</body>
</html>