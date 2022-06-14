<?php

/**
 * @charset UTF-8
 *
 * Задание 2. Работа с массивами и строками.
 *
 * Есть список временных интервалов (интервалы записаны в формате чч:мм-чч:мм).
 *
 * Необходимо написать две функции:
 *
 *
 * Первая функция должна проверять временной интервал на валидность
 * 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм)
 * 	возвращать boolean
 *
 *
 * Вторая функция должна проверять "наложение интервалов" при попытке добавить новый интервал в список существующих
 * 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм)
 *  возвращать boolean
 *
 *  "наложение интервалов" - это когда в промежутке между началом и окончанием одного интервала,
 *   встречается начало, окончание или то и другое одновременно, другого интервала
 *
 *  пример:
 *
 *  есть интервалы
 *  	"10:00-14:00"
 *  	"16:00-20:00"
 *
 *  пытаемся добавить еще один интервал
 *  	"09:00-11:00" => произошло наложение
 *  	"11:00-13:00" => произошло наложение
 *  	"14:00-16:00" => наложения нет
 *  	"14:00-17:00" => произошло наложение
 */

# Можно использовать список:

$list = array (
	'09:00-11:00',
	'11:00-13:00',
	'15:00-16:00',
	'17:00-20:00',
	'20:30-21:30',
	'21:30-22:30',
);



//Решение: 

function dateValidation($interval = ''):bool {
    if (preg_match('/\d{2}:\d{2}-\d{2}:\d{2}/', $interval)) {
        $arrIntervalTimeArray = convertTimeHandler($interval);
        
        return ($arrIntervalTimeArray['startDateTime'] < $arrIntervalTimeArray['endDateTime']) ? true : false;
    } else {
        return false;
    };
}

function checkIntervalsCrossing($interval = '') {
    if (dateValidation($interval)) {
        global $list;
        $arrCurIntervalTime = convertTimeHandler($interval);
        
        foreach ($list as $val) {
            $arrIntervalTime = convertTimeHandler($val);
            if ($arrIntervalTime['startDateTime'] < $arrCurIntervalTime['endDateTime'] && $arrCurIntervalTime['startDateTime'] < $arrIntervalTime['endDateTime']) {
                return true;
            break;
            }
        }
    } else {
        return false;
    }
}

function convertTimeHandler($interval) {
    $endTime = substr(stristr($interval, '-'), 1);
    $startTime = stristr($interval, '-', true);
    
    $arrIntervalTimeArray['startDateTime'] = strtotime(date('Y-m-d')  ." ". $startTime);
    $arrIntervalTimeArray['endDateTime'] = strtotime(date('Y-m-d')  ." ". $endTime);
    
    return $arrIntervalTimeArray;
}
  
checkIntervalsCrossing();
?>