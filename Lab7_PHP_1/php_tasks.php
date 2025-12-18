<?php

// задание 1: рекурсивное возведение в степень
function power($val, $pow) {
    // базовый случай когда степень равна нулю
    if ($pow == 0) {
        return 1;
    }
    // если степень отрицательная делим единицу на результат
    if ($pow < 0) {
        return 1 / power($val, -$pow);
    }
    // рекурсивно умножаем число на само себя в степени минус один
    return $val * power($val, $pow - 1);
}

echo "Задание 1:\n";
echo "2^3 = " . power(2, 3) . "\n";
echo "5^4 = " . power(5, 4) . "\n\n";


// задание 2: склонение времени
function getCurrentTime() {
    $hours = date('G');
    $minutes = date('i');

    // функция для склонения часов
    function declineHours($number) {
        $number = abs($number) % 100;
        $lastDigit = $number % 10;
        if ($number > 10 && $number < 20) return 'часов';
        if ($lastDigit == 1) return 'час';
        if ($lastDigit >= 2 && $lastDigit <= 4) return 'часа';
        return 'часов';
    }

    // функция для склонения минут
    function declineMinutes($number) {
        $number = abs($number) % 100;
        $lastDigit = $number % 10;
        if ($number > 10 && $number < 20) return 'минут';
        if ($lastDigit == 1) return 'минута';
        if ($lastDigit >= 2 && $lastDigit <= 4) return 'минуты';
        return 'минут';
    }

    return $hours . ' ' . declineHours($hours) . ' ' . $minutes . ' ' . declineMinutes($minutes);
}

echo "Задание 2:\n";
echo "Текущее время: " . getCurrentTime() . "\n\n";


// задание 3: числа делящиеся на три через while
echo "Задание 3:\n";
$i = 0;
while ($i <= 100) {
    // проверяем делится ли число на три без остатка
    if ($i % 3 == 0) {
        echo $i . " ";
    }
    $i++;
}
echo "\n\n";


// задание 4: четные и нечетные числа через do while
echo "Задание 4:\n";
$i = 0;
do {
    if ($i == 0) {
        echo $i . " – это ноль\n";
    } elseif ($i % 2 == 0) {
        echo $i . " – четное число\n";
    } else {
        echo $i . " – нечетное число\n";
    }
    $i++;
} while ($i <= 10);
echo "\n";


// задание 5: вывод чисел без тела цикла
echo "Задание 5:\n";
// используем print в третьей секции цикла для вывода
for ($i = 0; $i < 10; print $i++ . " ") {}
echo "\n\n";


// задание 6: многомерный массив с областями и городами
echo "Задание 6:\n";
$regions = [
    'Московская область' => ['Москва', 'Зеленоград', 'Клин', 'Подольск'],
    'Ленинградская область' => ['Санкт-Петербург', 'Всеволожск', 'Павловск', 'Кронштадт'],
    'Рязанская область' => ['Рязань', 'Касимов', 'Скопин', 'Сасово']
];

foreach ($regions as $region => $cities) {
    // выводим название области и список городов через запятую
    echo $region . ": " . implode(', ', $cities) . "\n";
}
echo "\n";


// задание 7: города на букву к
echo "Задание 7:\n";
foreach ($regions as $region => $cities) {
    echo $region . ": ";
    $citiesWithK = [];
    foreach ($cities as $city) {
        // проверяем начинается ли город с буквы к
        if (mb_substr($city, 0, 1) === 'К') {
            $citiesWithK[] = $city;
        }
    }
    // выводим найденные города или сообщение если их нет
    if (count($citiesWithK) > 0) {
        echo implode(', ', $citiesWithK) . "\n";
    } else {
        echo "нет городов на К\n";
    }
}
echo "\n";


// задание 8: транслитерация
$translitMap = [
    'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
    'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
    'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
    'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
    'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts', 'ч' => 'ch',
    'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '',
    'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
    'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
    'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I',
    'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
    'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
    'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'Ts', 'Ч' => 'Ch',
    'Ш' => 'Sh', 'Щ' => 'Sch', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '',
    'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya'
];

function transliterate($str, $map) {
    $result = '';
    // проходим по каждому символу строки
    for ($i = 0; $i < mb_strlen($str); $i++) {
        $char = mb_substr($str, $i, 1);
        // если символ есть в карте заменяем иначе оставляем как есть
        $result .= isset($map[$char]) ? $map[$char] : $char;
    }
    return $result;
}

echo "Задание 8:\n";
echo transliterate("Привет мир", $translitMap) . "\n\n";


// задание 9: транслитерация с заменой пробелов
function transliterateForUrl($str, $map) {
    // сначала транслитерируем строку
    $str = transliterate($str, $map);
    // заменяем пробелы на подчеркивания
    $str = str_replace(' ', '_', $str);
    return $str;
}

echo "Задание 9:\n";
echo transliterateForUrl("Привет мир", $translitMap) . "\n\n";

?>