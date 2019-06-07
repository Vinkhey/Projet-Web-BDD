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

                $registerQuery = 'INSERT INTO locations (idSnows, idUsers,`DateDebut`, `DateFin`, Quantité) VALUES ('. $strSeparator . $idSnows .$strSeparator .','. $strSeparator . $userId .$strSeparator .','. $strSeparator . $snowLocationStart .$strSeparator . ','.$strSeparator . $snowLocationEnd .$strSeparator. ','.$strSeparator . $quantity .$strSeparator.')';

                require_once 'model/dbConnector.php';
                $queryResult = executeQueryInsert($registerQuery);

                if($queryResult){
                    $result = $queryResult;
                }

                return $queryResult;
            }
        }

        return $result;
    }

    function getLocations($userId)
    {
        $result = false;
        $strSeparator = '\'';

        $getUserIdQuery = 'SELECT code, brand, model, dailyPrice, dateDebut, idLocations, Quantité FROM snows INNER JOIN locations ON locations.idSnows = snows.idSnows INNER JOIN users ON locations.idUsers = users.idUsers WHERE users.idUsers = ('. $strSeparator . $userId .$strSeparator. ')';

        require_once 'model/dbConnector.php';
        $queryResult = executeQuerySelect($getUserIdQuery);

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
        return $result;
    }
?>