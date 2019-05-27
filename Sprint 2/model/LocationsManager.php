<?php
    function updateLocations($cartInfo)
    {
        $result = false;
        $strSeparator = '\'';

        if($cartInfo != null) {
            foreach ($cartInfo as $key => $value) {
                $snowLocationStart = $cartInfo[$key]['dateD'];
                $startLocationTimestamp = strtotime($snowLocationStart);
                $snowNbd = $cartInfo[$key]['nbD'];
                $snowId = $cartInfo[$key]['idSnows'];
                $snowUsers = $cartInfo[$key]['idUsers'];

                $snowLocationEnd = strtotime('+'.$snowNbd.'days', $startLocationTimestamp);

                $registerQuery = 'INSERT INTO locations (idSnows,idUsers,`DateDebut`, `DateFin`) VALUES (' .$strSeparator . $snowUsers .$strSeparator.$strSeparator . $snowId .$strSeparator. $strSeparator . $snowLocationStart .$strSeparator . ','.$strSeparator . $snowLocationEnd .$strSeparator. ')';

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
?>