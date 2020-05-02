<?php
$allHouses = [
    'house' => [1, 2, 3, 4, 5],
    'color' => ['Red', 'Blue', 'White', 'Yellow', 'Green'],
    'resident' => ['Norwegian', 'Englishman', 'Dane', 'German', 'Swede'],
    'cigarette' => ['Rothmans', 'Dunhill', 'Mallboro', 'PallMall', 'PhilippeMorice'],
    'pat' => ['Cat', 'Horse', 'Dog', 'Bird', 'Fish'],
    'drink' => ['Tea', 'Water', 'Milk', 'Beer', 'Coffee']
];
$allSortedHouses = [
    'firstHouse' => ['house'=> 1, 'color'=>'', 'resident'=>'', 'cigarette'=>'', 'pat'=>'', 'drink'=>''],
    'secondHouse' => ['house'=> 2, 'color'=>'', 'resident'=>'', 'cigarette'=>'', 'pat'=>'', 'drink'=>''],
    'thirdHouse' => ['house'=> 3, 'color'=>'', 'resident'=>'', 'cigarette'=>'', 'pat'=>'', 'drink'=>''],
    'fourthHouse' => ['house'=> 4, 'color'=>'', 'resident'=>'', 'cigarette'=>'', 'pat'=>'', 'drink'=>''],
    'fifthHouse' => ['house'=> 5, 'color'=>'', 'resident'=>'', 'cigarette'=>'', 'pat'=>'', 'drink'=>'']
];
//
// Функции для работы с исходным массивом
//
function delete_value_from_initial_array($needleValue){
    global $allHouses;
    foreach ($allHouses as &$arrData){
        if (in_array($needleValue, $arrData)){
            $valueKey = array_search($needleValue, $arrData);
            foreach ($arrData as $value){
                unset($arrData[$valueKey]);
            }
        }
    }
}
//
// Функции для работы с новым массивом
//
function add_value_to_sorted_array($toHouse, $characteristic, $newData){
    global $allSortedHouses;
    return $allSortedHouses[$toHouse][$characteristic] = $newData;
}

function get_value_by_house_number($houseNumber, $houseCharacteristic){
    global $allSortedHouses;
    foreach ($allSortedHouses as $house=>$arrays){
        foreach ($arrays as $item=>$value){
            if ($value == $houseNumber){
                return $allSortedHouses[$house][$houseCharacteristic];
            }
        }
    }
}

function get_house_from_sorted_array($needleValue){
    global $allSortedHouses;
    foreach ($allSortedHouses as $key=>$arrays){
        if (array_search($needleValue, $arrays)){
            return $key;
        }
    }
}

function get_house_number_from_sorted_array($needleValue){
    global $allSortedHouses;
    foreach ($allSortedHouses as $arrays){
        if (array_search($needleValue, $arrays)){
            $houseNumber = $arrays['house'];
            return $houseNumber;
        }
    }
}

function check_sorted_value_by_house($house, $column, $checkedValue){
    global $allSortedHouses;
    $value = $allSortedHouses[$house][$column];
    if ($value == $checkedValue){
        return true;
    } else {
        return false;
    }
}
// *********************************************************************************************************************
// Функции для условий задачи
//

//(Норвежец живет рядом с синим домом)
function blue_house_number($houseNumber){
    if ($houseNumber == 1){
        return $blueHouse = ++$houseNumber;
    } elseif ($houseNumber == 5) {
        return $blueHouse = --$houseNumber;
    } else {
        echo 'Нельзя определить однозначно номер голубого дома';
    }
}
//Тот, кто живет в центре, пьет молоко.
function middle_house($initialArray, $innerArrayName){
    $qty = count($initialArray[$innerArrayName]);
    $average = $qty / 2;
    return $middleHouse = round($average, 0, PHP_ROUND_HALF_UP);
}

//Зеленый дом находится левее белого.
$greenWhiteHouses = [];
function green_white_houses(){
    global $allHouses;
    global $allSortedHouses;
    global $greenWhiteHouses;
    $allColors = array_values($allHouses['color']);
    $sortedColors = array_column($allSortedHouses, 'color');
    $sortedHouses = array_column($allSortedHouses, 'house');
    $coloredHouses = array_combine($sortedHouses, $sortedColors);
    foreach ($coloredHouses as $house => $color){
        if (next($coloredHouses) === '' && $color === ''){
            $greenWhiteHouses[] = $house;
        }
    }
}
function whiteHouseNumber(){
    $greenHouse = get_house_number_from_sorted_array('Green');
    return $whiteHouse = $greenHouse + 1;
}

//Зеленый дом находится левее белого.
//Англичанин живет в красном доме.
function color_norwegian_house(){
    global $greenWhiteHouses;
    global $allHouses;
    global $allSortedHouses;
    $allColors = array_values($allHouses['color']);
    $norwegianHouseNumber = get_house_number_from_sorted_array('Norwegian');
    $resident = $allSortedHouses['firstHouse']['resident'];
    if (check_sorted_value_by_house('firstHouse', 'resident', 'Englishman')){
        $yellowKey = array_search('Yellow', $allColors);
        unset($allColors[$yellowKey]);
    } else {
        $redKey = array_search('Red', $allColors);
        unset($allColors[$redKey]);
    }
    if (!in_array($norwegianHouseNumber, $greenWhiteHouses)){
        $greenKey = array_search('Green', $allColors);
        $whiteKey = array_search('White', $allColors);
        unset($allColors[$greenKey]);
        unset($allColors[$whiteKey]);
    } else {
        echo 'Нельзя однозначно определить цвет норвежского дома';
    }
//Возвращаем оставшийся цвет
    foreach ($allColors as $color){
        return $color;
    }
}

//Зеленый дом находится левее белого.
//В зеленом доме пьют кофе.
function green_coffee_house(){
    global $greenWhiteHouses;
    foreach ($greenWhiteHouses as $value){
        $houseDrink = get_value_by_house_number($value, 'drink');
        if ($houseDrink == 'Coffee'){
            return $value;
        } elseif (!$houseDrink == 'Coffee' && $houseDrink == ''){
            return $value;
        }
    }
}

//Англичанин живет в красном доме.
function red_house_number(){
    global $allHouses;
    global $allSortedHouses;
    $allColors = array_values($allHouses['color']);
    $sortedColors = array_column($allSortedHouses, 'color');
    $sortedHouses = array_column($allSortedHouses, 'house');
    $coloredHouses = array_combine($sortedHouses, $sortedColors);
    if (count($allColors) == 1){
        foreach ($allColors as $color){
            foreach ($coloredHouses as $house => $color){
                if ($color == ''){
                    return $house;
                }
            }
        }
    } else {
        echo "Нельзя красный дом определить однозначно";
    }

}
function englishman_house($house, $column, $color){
    if (check_sorted_value_by_house($house, $column, $color)){
        return $house;
    } else {
        echo $house . ' не красный';
    }
}

// *********************************************************************************************************************
// Решения. Применение функций
//

// Норвежец живет в первом доме.
$Norwegian = add_value_to_sorted_array('firstHouse', 'resident', 'Norwegian');
delete_value_from_initial_array($Norwegian);

// Норвежец живет рядом с синим домом.
$norwegianHouseNumber = get_house_number_from_sorted_array('Norwegian');
$blueHouseNumber = blue_house_number($norwegianHouseNumber);
$blueHouse = get_house_from_sorted_array($blueHouseNumber);
$Blue = add_value_to_sorted_array($blueHouse, 'color', 'Blue');
delete_value_from_initial_array($Blue);

// Тот, кто выращивает лошадей, живет в синем доме.
$horseHouse = get_house_from_sorted_array('Blue');
$Horse = add_value_to_sorted_array($horseHouse, 'pat', 'Horse');
delete_value_from_initial_array($Horse);

//Тот, кто живет в центре, пьет молоко.
$milkHouse = middle_house($allHouses, 'house');
$thirdHouse = get_house_from_sorted_array($milkHouse);
$Milk = add_value_to_sorted_array($thirdHouse, 'drink', 'Milk');
delete_value_from_initial_array($Milk);

//Зеленый дом находится левее белого.
//Англичанин живет в красном доме.
$suitableGreenWhite = green_white_houses();
$norwegianHouseColor = color_norwegian_house();
$norwegianHouse = get_house_from_sorted_array($norwegianHouseNumber);
$Yellow = add_value_to_sorted_array($norwegianHouse, 'color', $norwegianHouseColor);
delete_value_from_initial_array($Yellow);

//Тот, кто живет в желтом доме, курит Dunhill.
$dunhillHouse = get_house_from_sorted_array('Yellow');
$Dunhill = add_value_to_sorted_array($dunhillHouse, 'cigarette', 'Dunhill');
delete_value_from_initial_array($Dunhill);

//Зеленый дом находится левее белого.
//В зеленом доме пьют кофе.
$greenCoffeeHouseNumber= green_coffee_house();
$greenCoffeeHouse = get_house_from_sorted_array($greenCoffeeHouseNumber);
$coffee = add_value_to_sorted_array($greenCoffeeHouse, 'drink', 'Coffee');
$green = add_value_to_sorted_array($greenCoffeeHouse, 'color', 'Green');
delete_value_from_initial_array($coffee);
delete_value_from_initial_array($green);

$whiteHouseNumber = whiteHouseNumber();
$whiteHouse = get_house_from_sorted_array($whiteHouseNumber);
$white = add_value_to_sorted_array($whiteHouse, 'color', 'White');
delete_value_from_initial_array($white);

// Осталяся последний цвет: красный
$redHouseNumber = red_house_number();
$redHouse = get_house_from_sorted_array($redHouseNumber);
$red = add_value_to_sorted_array($redHouse, 'color', 'Red');
delete_value_from_initial_array($red);

//Англичанин живет в красном доме.
$englishmanHouse = englishman_house($redHouse, 'color', $red);
$englishman = add_value_to_sorted_array($englishmanHouse, 'resident', 'Englishman');
delete_value_from_initial_array($englishman);


//Вывод первоначального массива и отсортированного в соответствии с условиями
var_export($allHouses);
var_export($allSortedHouses);