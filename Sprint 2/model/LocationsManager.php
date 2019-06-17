<?php
    function updateLocations($cartInfo, $userId)
    {
        $result = false;
        $strSeparator = '\'';

        if($cartInfo != null) {
            foreach ($cartInfo as $key => $value) {
                $snowLocationStart = $cartInfo[$key]['dateD'];
                $numberOfDays = $cartInfo[$key]['nbD'];
                $idSnows = $cartInfo[$key]['idSnows'];
                $quantity = $cartInfo[$key]['qty'];
                $snowLocationEnd = date( 'y-m-d', strtotime($snowLocationStart. " + {$numberOfDays} days"));
                $result = decreaseSnowsStock($cartInfo);
                if($result == true)
                {
                    $updateLocationsQuery = 'INSERT INTO locations (idSnows, idUsers,`DateDebut`, `DateFin`, Quantité) VALUES (' . $strSeparator . $idSnows . $strSeparator . ',' . $strSeparator . $userId . $strSeparator . ',' . $strSeparator . $snowLocationStart . $strSeparator . ',' . $strSeparator . $snowLocationEnd . $strSeparator . ',' . $strSeparator . $quantity . $strSeparator . ')';
                    require_once 'model/dbConnector.php';
                    $queryResult = executeQueryInsert($updateLocationsQuery);
                }
                else
                {
                    return $result;
                }
            }

            if($queryResult){
                return $queryResult;
            }
            else
            {
                return $result;
            }
        }

        return $result;
    }

    function getLocations($userId)
    {
        $result = false;
        $strSeparator = '\'';

        $getLocationsQuery = 'SELECT code, brand, model, dailyPrice, dateDebut, idLocations, Quantité FROM snows INNER JOIN locations ON locations.idSnows = snows.idSnows INNER JOIN users ON locations.idUsers = users.idUsers WHERE users.idUsers = ('. $strSeparator . $userId .$strSeparator. ')';

        require_once 'model/dbConnector.php';
        $queryResult = executeQuerySelect($getLocationsQuery);

        if (count($queryResult) > 1)
        {
            foreach($queryResult as $key => $value)
            {
                $result = $queryResult[$key];
            }
        }
        else
        {
            $result = $queryResult;
        }
        return $queryResult;
    }

function decreaseSnowsStock($cartInfo)
{
    $result = false;
    $strSeparator = '\'';

    if($cartInfo != null) {
        foreach ($cartInfo as $key => $value) {
            $idSnows = $cartInfo[$key]['idSnows'];
            $quantity = $cartInfo[$key]['qty'];
            $stock = getSnowsStock($idSnows);
            if($stock[0]['qtyAvailable'] != 0)
            {
                $updatedStock = $stock[0]['qtyAvailable'] - $quantity;

                if($updatedStock < 0)
                {
                    return $result;
                }
            }
            else
            {
                return $result;
            }

            $decreaseSnowsStockQuery = 'UPDATE snows SET qtyAvailable = ('. $strSeparator . $updatedStock .$strSeparator .') WHERE IdSnows = ('. $strSeparator . $idSnows .$strSeparator .')';

            require_once 'model/dbConnector.php';
            $queryResult = executeQueryInsert($decreaseSnowsStockQuery);
            if($queryResult)
            {
                $result = true;
            }
        }
    }

    return $result;
}

function getSnowsStock($idSnows)
{
    $result = false;
    $strSeparator = '\'';

    $stockQuery = 'SELECT qtyAvailable FROM snows WHERE idSnows = ('. $strSeparator . $idSnows .$strSeparator .')';

    require_once 'model/dbConnector.php';
    $queryResult = executeQuerySelect($stockQuery);
    if($queryResult)
    {
        return $queryResult;
    }

    return $result;
}
?>