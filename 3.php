<?php

/**
 * @charset UTF-8
 *
 * Задание 3
 * В данный момент компания X работает с двумя перевозчиками
 * 1. Почта России
 * 2. DHL
 * У каждого перевозчика своя формула расчета стоимости доставки посылки
 * Почта России до 10 кг берет 100 руб, все что cвыше 10 кг берет 1000 руб
 * DHL за каждый 1 кг берет 100 руб
 * Задача:
 * Необходимо описать архитектуру на php из методов или классов для работы с
 * перевозчиками на предмет получения стоимости доставки по каждому из указанных
 * перевозчиков, согласно данным формулам.
 * При разработке нужно учесть, что количество перевозчиков со временем может
 * возрасти. И делать расчет для новых перевозчиков будут уже другие программисты.
 * Поэтому необходимо построить архитектуру так, чтобы максимально минимизировать
 * ошибки программиста, который будет в дальнейшем делать расчет для нового
 * перевозчика, а также того, кто будет пользоваться данным архитектурным решением.
 *
 */

# Использовать данные:
# любые



//Решение: 

//Для каждого перевозчика создается класс-стратегия, реализующий интерфейс PriceCalculatorStrategy в котоорм расчитывается стоимость перевозки с учетом уникальной формулы.
//В конструкторе основного класса приложения создается private метод в который передается перевозчик и происходит выбор стратегии для расчета стоимости.
//Так же в основном классе создается метод, который вызывает метод для расчетов стоимости из выбраного класса-стратегии

class Main {
    $strategy = NULL;
    $mass;
    $distance;

    public function __construct($carrier) {

        $this->strategy = сhooseCalculateStrategy($carrier);
    }

    private function сhooseCalculateStrategy() {
        switch ($carrier) {
            case "RusPost": 
                return new StrategyRusPostCalculate();
            case "DHL": 
                return new StrategyDHLCalculate();
        }
    }

    public function calculate($mass, $distance) {
        return $this->strategy->calculatePrice($mass, $distance);
    }
}

interface PriceCalculatorStrategy {
    public function calculatePrice($mass, $distance);
}

class StrategyRusPostCalculate implements PriceCalculatorStrategy {
    calculatePrice(float $mass, float $distance) {
        if ($mass < 10) { 
            $summ = $mass * 100 + $distance;
        } else {
            $summ = $mass * 1000 + $distance;
        }
        return $summ;
    }
}

class StrategyDHLCalculate implements PriceCalculatorStrategy {
    calculatePrice(float $mass, float $distance) {
        return $mass * 100 + $distance;
    }
}
