<?php
    function updateLocations()
    {
        $result = false;
        $strSeparator = '\'';

        if($cartInfo != null) {
            foreach ($cartInfo as $key => $value) {
                $snowLocationStart = $cartInfo[$key]['dateD'];
                $startLocationTimestamp = strtotime($snowLocationStart);
                $snowNbd = $cartInfo[$key]['nbD'];

                $snowLocationEnd = strtotime('+', '');

                $registerQuery = 'INSERT INTO locations (`DateDebut`, `DateFin`) VALUES (' .$strSeparator . $snowLocationStart .$strSeparator . ','.$strSeparator . $snowLocationEnd .$strSeparator. ')';

                require_once 'model/dbConnector.php';
            }
        }

        return $result;
    }
?>