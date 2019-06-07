<?php
/**
 * Author   : nicolas.glassey@cpnv.ch
 * Project  : 151_2019_code
 * Created  : 04.04.2019 - 18:48
 *
 * Last update :    [01.12.2018 author]
 *                  [add $logName in function setFullPath]
 * Git source  :    [link]
 */

/**
 * @param $currentCartArray
 * @param $snowCodeToAdd
 * @param $qtyOfSnowsToAdd
 * @param $howManyLeasingDays
 * @return array
 */

function updateCart($snowId ,$currentCartArray, $snowCodeToAdd, $qtyOfSnowsToAdd, $howManyLeasingDays){
    $result = null;
    $test = null;
    $timestamp = time();

    if($qtyOfSnowsToAdd > 0) {
        foreach ($currentCartArray as $key => $value) {
            $test++;
            if ($value['code'] == $snowCodeToAdd) {
                if ($test < 2 and $value['nbD'] == $howManyLeasingDays) {
                    $result = true;
                    $test = $key;
                } else {
                    $test = $key;
                    $result = null;
                }
            }
        }

        if ($currentCartArray != null and $result == true) {
            foreach ($currentCartArray as $key => $value) {
                if ($value['code'] == $snowCodeToAdd and $test == $key) {
                    $currentCartArrayInitialQty = $currentCartArray[$key]['qty'] += $qtyOfSnowsToAdd;
                    $currentCartArrayFinalQty = strval($currentCartArrayInitialQty);
                    $currentCartArray[$key]['qty'] = $currentCartArrayFinalQty;
                }
            }
        }
        $cartUpdated = $currentCartArray;
        $test = 0;

        foreach ($cartUpdated as $key => $value) {
            if ($value['code'] == $snowCodeToAdd) {
                $test++;
                if ($test > 1 and $result == true) {
                    unset($cartUpdated[$test]);
                } else {
                    $_SESSION['updateCartResult'] = $result;
                }
            }
        }

        $newSnowLeasing = array('idSnows' => $snowId, 'code' => $snowCodeToAdd, 'dateD' => Date("y-m-d", $timestamp), 'nbD' => $howManyLeasingDays, 'qty' => $qtyOfSnowsToAdd);

        array_push($cartUpdated, $newSnowLeasing);

        return $cartUpdated;
    }
    else
    {
        $_SESSION['CartErrors'] = "Quantité trop élevée ou inférieure à 1, Vérifiez la disponibilité du stock";
    }
}

//in_array https://www.php.net/manual/en/function.in-array.php
//array_push() https://www.php.net/manual/en/function.array-push.php
//array_search
//unset
