<?php
    function updateLocations($cartInfo, $userId)
    {
        $result = false;
        $strSeparator = '\'';

        if($cartInfo != null) {
            foreach ($cartInfo as $key => $value) {
                $snowLocationStart = $cartInfo[$key]['dateD'];
                $idSnows = $cartInfo[$key]['idSnows'];
                $snowLocationEnd = $snowLocationStart;

                $registerQuery = 'INSERT INTO locations (idSnows, idUsers,`DateDebut`, `DateFin`) VALUES ('. $strSeparator . $idSnows .$strSeparator .','. $strSeparator . $userId .$strSeparator .','. $strSeparator . $snowLocationStart .$strSeparator . ','.$strSeparator . $snowLocationEnd .$strSeparator. ')';

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

        $getUserIdQuery = 'SELECT code, brand, model, dailyPrice, dateDebut, idLocations FROM snows INNER JOIN locations ON locations.idLocations = snows.idSnows INNER JOIN users ON locations.idUsers = users.idUsers WHERE users.idUsers = ('. $strSeparator . $userId .$strSeparator. ')';

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