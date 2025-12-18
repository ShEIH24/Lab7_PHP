<?php
class SimpleXLSX {
    private static $error = '';
    private $rows = [];

    public static function parse($filename) {
        if (!file_exists($filename)) {
            self::$error = 'Файл не найден';
            return false;
        }

        // Проверяем, можем ли использовать ZipArchive
        if (class_exists('ZipArchive')) {
            return self::parseWithZip($filename);
        } else {
            self::$error = 'Расширение ZIP не установлено. Сохраните файл как CSV.';
            return false;
        }
    }

    private static function parseWithZip($filename) {
        $zip = new ZipArchive();
        if ($zip->open($filename) !== true) {
            self::$error = 'Не удалось открыть XLSX файл';
            return false;
        }

        // Читаем SharedStrings (общие строки)
        $sharedStrings = [];
        $sharedStringsXML = $zip->getFromName('xl/sharedStrings.xml');
        if ($sharedStringsXML) {
            $xml = simplexml_load_string($sharedStringsXML);
            foreach ($xml->si as $si) {
                $sharedStrings[] = (string)$si->t;
            }
        }

        // Читаем данные листа
        $sheetData = $zip->getFromName('xl/worksheets/sheet1.xml');
        $zip->close();

        if (!$sheetData) {
            self::$error = 'Не удалось прочитать данные листа';
            return false;
        }

        $xml = simplexml_load_string($sheetData);
        if (!$xml) {
            self::$error = 'Ошибка парсинга XML';
            return false;
        }

        $instance = new self();

        foreach ($xml->sheetData->row as $row) {
            $rowData = [];
            $colIndex = 0;

            foreach ($row->c as $cell) {
                $cellValue = '';

                // Получаем индекс колонки из адреса ячейки (A1, B1, и т.д.)
                $cellAddress = (string)$cell['r'];
                preg_match('/([A-Z]+)/', $cellAddress, $matches);
                $col = $matches[1];
                $currentColIndex = self::columnIndexFromString($col);

                // Заполняем пропущенные колонки
                while ($colIndex < $currentColIndex) {
                    $rowData[] = '';
                    $colIndex++;
                }

                // Определяем тип ячейки
                $cellType = (string)$cell['t'];

                if ($cellType == 's') {
                    // Строка из SharedStrings
                    $stringIndex = (int)$cell->v;
                    $cellValue = isset($sharedStrings[$stringIndex]) ? $sharedStrings[$stringIndex] : '';
                } else {
                    // Число или другой тип
                    $cellValue = isset($cell->v) ? (string)$cell->v : '';
                }

                $rowData[] = $cellValue;
                $colIndex++;
            }

            $instance->rows[] = $rowData;
        }

        return $instance;
    }

    private static function columnIndexFromString($col) {
        $index = 0;
        $len = strlen($col);
        for ($i = 0; $i < $len; $i++) {
            $index = $index * 26 + (ord($col[$i]) - ord('A'));
        }
        return $index;
    }

    public function rows() {
        return $this->rows;
    }

    public static function parseError() {
        return self::$error;
    }
}