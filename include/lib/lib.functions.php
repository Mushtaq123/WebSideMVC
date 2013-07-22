<?php

/* * *************************************************************************** */

function getExample() {
    global $db;
    $resultat = '';

    $q = "SELECT * FROM TABLE";
    $result = sql_query($q, $db);

    while ($row = mysql_fetch_array($result)) {
       $resultat .= '<p>' . $row["COLUMN"] . '</p>';
    }

    return $resultat;
}

?>