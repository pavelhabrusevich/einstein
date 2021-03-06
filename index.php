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
            foreach ($coloredHouses as $house => $col){
                if ($col == ''){
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

// Напиток норвежца
//Датчанин пьет чай.
//Тот, кто курит Philip Morris, пьет пиво
//Тот, кто живет в центре, пьет молоко.
//В зеленом доме пьют кофе.
function norwegian_drink(){
    global $norwegianHouse;
    if (check_sorted_value_by_house($norwegianHouse, 'resident', 'Dane')){
        return 'Tea';
    } elseif (check_sorted_value_by_house($norwegianHouse, 'cigarette', 'PhilippeMorice')){
        return 'Beer';
    } elseif (check_sorted_value_by_house($norwegianHouse, 'house', '3')){
        return 'Milk';
    } elseif (check_sorted_value_by_house($norwegianHouse, 'color', 'Green')){
        return 'Coffee';
    } else {
        return 'Water';
    }
}

//Сосед того, кто курит Rothmans, пьет воду.
function rothmans_house(){
    global $allSortedHouses;
    $sortedHouses = array_column($allSortedHouses, 'house');
    $sortedDrinks = array_column($allSortedHouses, 'drink');
    $sortedCigarettes = array_column($allSortedHouses, 'cigarette');
    $houseDrink = array_combine($sortedHouses, $sortedDrinks);
    $houseCigarette = array_combine($sortedHouses, $sortedCigarettes);
    $i = 0;
    foreach ($houseDrink as $house => $drink){
        if ($drink == ''){
            $houseDrink[$house] = ++$i;
        }
    }
    foreach ($houseCigarette as $house => $cigarette){
        if ($cigarette == ''){
            $houseCigarette[$house] = 'empty';
        }
    }
    $drinkCigarette = array_combine($houseDrink, $houseCigarette);
    foreach ($drinkCigarette as $drink => $cigarette){
        if ($drink == 'Water'){
            if (prev($drinkCigarette) == 'empty'){
                $rothmansKey = key($drinkCigarette);
                $drinkCigarette[$rothmansKey] = 'Rothmans';
            } else {
                reset($drinkCigarette);
            }
            if (next($drinkCigarette) == 'empty'){
                $rothmansKey = key($drinkCigarette);
                $drinkCigarette[$rothmansKey] = 'Rothmans';
            } else {
                reset($drinkCigarette);
            }
        }
    }
    $newHouseCigarette = array_combine($sortedHouses, array_values($drinkCigarette));
    return array_search('Rothmans', $newHouseCigarette);
}
// Функция, применимая для определения двух конфигураций одного дома, когда их результат однозначен
function two_configuration_house($firstConf, $secondConf, $needleFirstConf, $needleSecondConf){
    global $allSortedHouses;
    $sortedHouses = array_column($allSortedHouses, 'house');
    $sortedFirstConf = array_column($allSortedHouses, $firstConf);
    $sortedSecondConf = array_column($allSortedHouses, $secondConf);

    $houseFirstConf = array_combine($sortedHouses, $sortedFirstConf);
    $houseSecondConf = array_combine($sortedHouses, $sortedSecondConf);

    $firstConf = array_search($needleFirstConf, $houseFirstConf);
    $secondConf = array_search($needleSecondConf, $houseSecondConf);

    $emptyFirstConfHouse = [];
    $emptySecondConfHouse = [];

    if (!$firstConf && !$secondConf){
        foreach ($houseFirstConf as $house => $conf){
            if ($conf == null){
                $emptyFirstConfHouse[] = $house;
            }
        }
        foreach ($houseSecondConf as $house => $conf){
            if ($conf == null){
                $emptySecondConfHouse[] = $house;
            }
        }
    } else {
        echo 'Все на месте';
    }
    $emptyHouses = array_intersect($emptyFirstConfHouse, $emptySecondConfHouse);
    if (count($emptyHouses) == 1){
        return $emptyHouses[key($emptyHouses)];
    } else {
        echo 'Нельзя определить характеристики';
    }
}

//Функция, применимая для определения послеедней незаполненной конфигурации
function last_configuration_house($conf){
    global $allSortedHouses;
    $sortedHouses = array_column($allSortedHouses, 'house');
    $sortedConf = array_column($allSortedHouses, $conf);
    $houseConf = array_combine($sortedHouses, $sortedConf);
    $emptyConfHouse = [];
    foreach ($houseConf as $house => $value){
        if ($value == null){
            $emptyConfHouse[] = $house;
        }
    }
    if (count($emptyConfHouse) == 1){
        return $emptyConfHouse[key($emptyConfHouse)];
    } else {
        echo 'Кофигурация не последняя';
    }
}

//Тот, кто курит Rothmans, живет рядом с тем, кто выращивает кошек.
function cat_house(){
    global $allSortedHouses;
    $sortedHouses = array_column($allSortedHouses, 'house');
    $sortedPat = array_column($allSortedHouses, 'pat');
    $housePat = array_combine($sortedHouses, $sortedPat);
    $rothmansHouseNumber = get_house_number_from_sorted_array('Rothmans');
    foreach ($housePat as $house => $pat){
        if ($pat == ''){
            $housePat[$house] = 'empty';
        }
    }
    $catHouses = [];
    foreach ($housePat as $house => $pat) {
        if ($house == $rothmansHouseNumber) {
            $prev = $house - 1;
            $next = $house + 1;
            if ($housePat[$prev] == 'empty') {
                $catHouses[] = $prev;
                if ($housePat[$next] == 'empty') {
                    $catHouses[] = $next;
                    if ($housePat[$prev] == 'empty' && $housePat[$next] == 'empty') {
                        echo 'Нельзя определить. кто вырасчивает кошек';
                    }
                }
            }
        }
    }
    if (count($catHouses) == 1){
        foreach ($catHouses as $catHouse){
            return $catHouse;
        }
    }
}

//Оставшееся домашнее животное
function last_pat(){
    global $allHouses;
    $lastPats = array_values($allHouses['pat']);
    foreach ($lastPats as $pat){
        echo 'Немец вырасчивает ' . $pat;
    }
}
// *********************************************************************************************************************
// Решения. Применение функций
//

// Норвежец живет в первом доме.
$norwegian = add_value_to_sorted_array('firstHouse', 'resident', 'Norwegian');
delete_value_from_initial_array($norwegian);

// Норвежец живет рядом с синим домом.
$norwegianHouseNumber = get_house_number_from_sorted_array('Norwegian');
$blueHouseNumber = blue_house_number($norwegianHouseNumber);
$blueHouse = get_house_from_sorted_array($blueHouseNumber);
$blue = add_value_to_sorted_array($blueHouse, 'color', 'Blue');
delete_value_from_initial_array($blue);

// Тот, кто выращивает лошадей, живет в синем доме.
$horseHouse = get_house_from_sorted_array('Blue');
$horse = add_value_to_sorted_array($horseHouse, 'pat', 'Horse');
delete_value_from_initial_array($horse);

//Тот, кто живет в центре, пьет молоко.
$milkHouse = middle_house($allHouses, 'house');
$thirdHouse = get_house_from_sorted_array($milkHouse);
$milk = add_value_to_sorted_array($thirdHouse, 'drink', 'Milk');
delete_value_from_initial_array($milk);

//Зеленый дом находится левее белого.
//Англичанин живет в красном доме.
$suitableGreenWhite = green_white_houses();
$norwegianHouseColor = color_norwegian_house();
$norwegianHouse = get_house_from_sorted_array($norwegianHouseNumber);
$yellow = add_value_to_sorted_array($norwegianHouse, 'color', $norwegianHouseColor);
delete_value_from_initial_array($yellow);

//Тот, кто живет в желтом доме, курит Dunhill.
$dunhillHouse = get_house_from_sorted_array('Yellow');
$dunhill = add_value_to_sorted_array($dunhillHouse, 'cigarette', 'Dunhill');
delete_value_from_initial_array($dunhill);

//Зеленый дом находится левее белого.
//В зеленом доме пьют кофе.
$greenCoffeeHouseNumber = green_coffee_house();
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

// Напиток норвежца
//Датчанин пьет чай.
//Тот, кто курит Philip Morris, пьет пиво
//Тот, кто живет в центре, пьет молоко.
//В зеленом доме пьют кофе.
$norwegianDrink = norwegian_drink();
$water = add_value_to_sorted_array($norwegianHouse, 'drink', $norwegianDrink);
delete_value_from_initial_array($water);

//Сосед того, кто курит Rothmans, пьет воду.
$rothmansHouseNumber = rothmans_house();
$rothmansHouse = get_house_from_sorted_array($rothmansHouseNumber);
$rothmans = add_value_to_sorted_array($rothmansHouse, 'cigarette', 'Rothmans');
delete_value_from_initial_array($rothmans);

//Тот, кто курит Philip Morris, пьет пиво.
$philippeMoriceBeerHouseNumber = two_configuration_house('cigarette', 'drink', 'PhilippeMorice', 'Beer');
$philippeMoriceBeerHouse = get_house_from_sorted_array($philippeMoriceBeerHouseNumber);
$beer = add_value_to_sorted_array($philippeMoriceBeerHouse, 'drink', 'Beer');
$philippeMorice = add_value_to_sorted_array($philippeMoriceBeerHouse, 'cigarette', 'PhilippeMorice');
delete_value_from_initial_array($beer);
delete_value_from_initial_array($philippeMorice);

//Датчанин пьет чай.
$daneTeaHouseNumber = two_configuration_house('resident', 'drink', 'Dane', 'Tea');
$daneTeaHouse = get_house_from_sorted_array($daneTeaHouseNumber);
$tea = add_value_to_sorted_array($daneTeaHouse, 'drink', 'Tea');
$dane = add_value_to_sorted_array($daneTeaHouse, 'resident', 'Dane');
delete_value_from_initial_array($tea);
delete_value_from_initial_array($dane);

//Немец курит Marlboro.
$germanMallboroHouseNumber = two_configuration_house('resident', 'cigarette', 'German', 'Mallboro');
$germanMallboroHouse = get_house_from_sorted_array($germanMallboroHouseNumber);
$mallboro = add_value_to_sorted_array($germanMallboroHouse, 'cigarette', 'Mallboro');
$german = add_value_to_sorted_array($germanMallboroHouse, 'resident', 'German');
delete_value_from_initial_array($mallboro);
delete_value_from_initial_array($german);

// Швед последний с списке резидентов остается
$swedeHouseNumber = last_configuration_house('resident');
$swedeHouse = get_house_from_sorted_array($swedeHouseNumber);
$swede = add_value_to_sorted_array($swedeHouse, 'resident', 'Swede');
delete_value_from_initial_array($swede);

// ПалМал последний с списке сигарет остается
$pallMallHouseNumber = last_configuration_house('cigarette');
$pallMallHouse = get_house_from_sorted_array($pallMallHouseNumber);
$pallMall = add_value_to_sorted_array($pallMallHouse, 'cigarette', 'PallMall');
delete_value_from_initial_array($pallMall);

//Швед выращивает собак.
$dogHouseNumber = $swedeHouseNumber;
$dogHouse = get_house_from_sorted_array($dogHouseNumber);
$dog = add_value_to_sorted_array($dogHouse, 'pat', 'Dog');
delete_value_from_initial_array($dog);

//Тот, кто курит Pall Mall, выращивает птиц.
$birdHouseNumber = $pallMallHouseNumber;
$birdHouse = get_house_from_sorted_array($birdHouseNumber);
$bird = add_value_to_sorted_array($birdHouse, 'pat', 'Bird');
delete_value_from_initial_array($bird);

//Тот, кто курит Rothmans, живет рядом с тем, кто выращивает кошек.
$catHouseNumber = cat_house();
$catHouse = get_house_from_sorted_array($catHouseNumber);
$cat = add_value_to_sorted_array($catHouse, 'pat', 'Cat');
delete_value_from_initial_array($cat);


//Вывод первоначального массива и отсортированного в соответствии с условиями
//var_export($allHouses);
//var_export($allSortedHouses);
last_pat();