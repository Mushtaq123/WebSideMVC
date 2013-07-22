<?PHP

/* * ********************************************************************* */
$sql_nbREQ = 0;

// Escape string
function SQL_escape_string($arr) {
    if (function_exists("mysql_escape_string"))
        @mysql_escape_string($arr);
    elseif (function_exists("mysql_real_escape_string"))
        @mysql_real_escape_string($arr);
    return ($arr);
}

// Connexion
function sql_connect($base=array()) {
    global $mysql_p, $dbhost, $dbuname, $dbpass, $dbname;


    if (count($base)) {
        $dbhost = $base["dbhost"];
        $dbuname = $base["dbuname"];
        $dbpass = $base["dbpass"];
        $dbname = $base["dbname"];
    }


    if (($mysql_p) or (!isset($mysql_p))) {
        $dblink = @mysql_pconnect($dbhost, $dbuname, $dbpass);
        @mysql_query("SET NAMES 'utf8'", $dblink);
    } else {
        $dblink = @mysql_connect($dbhost, $dbuname, $dbpass);
        @mysql_query("SET NAMES 'utf8'", $dblink);
    }

    if (!$dblink) {
        return (false);
    } else {
        if (!@mysql_select_db($dbname, $dblink))
            return (false);
        else
            return ($dblink);
    }
}

// Erreur survenue
function sql_error() {
    return @mysql_error();
}

// Exécution de requête
function sql_query($sql, $db=false) {
    global $sql_nbREQ;
    global $DEBUG;
    global $dblink;

    // choix de la connexion
    if ($db === false) {
        $db = $dblink;
    }




    $sql_nbREQ++;

    if (1) {
        $cur = mysql_query(SQL_escape_string($sql), $db);
        if (!$cur) {
            $save_error = mysql_error();
            die('
						<table border="0" cellpadding="3" cellspacing="0">
						<tr bgcolor="#E0E0E0">
						<td><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><b>Impossible d\'effectuer
						la requete suivante :</b><br>
						<br>
						<font face="Verdana, Arial, Helvetica, sans-serif">' . $sql . '</font><br>
						<br>' . $save_error . '</font></td>
						</tr>
						</table>');
        }
        return $cur;
    } else {
        if (!$query_id = @mysql_query(SQL_escape_string($sql), $db))
            return false;
        else
            return $query_id;
    }
}

// Tableau Associatif du résultat
function sql_fetch_assoc($q_id="") {
    if (empty($q_id)) {
        global $query_id;
        $q_id = $query_id;
    }
    return @mysql_fetch_assoc($q_id);
}

// Tableau Numérique du résultat
function sql_fetch_row($q_id="") {
    if (empty($q_id)) {
        global $query_id;
        $q_id = $query_id;
    }
    return @mysql_fetch_row($q_id);
}

// Resultat sous forme d'objet
function sql_fetch_object($q_id="") {
    if (empty($q_id)) {
        global $query_id;
        $q_id = $query_id;
    }
    return @mysql_fetch_object($q_id);
}

// Nombre de lignes d'un résultat
function sql_num_rows($q_id="") {
    if (empty($q_id)) {
        global $query_id;
        $q_id = $query_id;
    }
    return @mysql_num_rows($q_id);
}

// Nombre de champs d'une requête
function sql_num_fields($q_id="") {
    if (empty($q_id)) {
        global $query_id;
        $q_id = $query_id;
    }
    return @mysql_num_fields($q_id);
}

// Nombre de lignes affectées par les requêtes de type INSERT, UPDATE et DELETE
function sql_affected_rows() {
    return @mysql_affected_rows();
}

// Le dernier identifiant généré par un champ de type AUTO_INCREMENT
function sql_last_id() {
    return @mysql_insert_id();
}

// Lister les tables
function sql_list_tables($dbnom="") {
    if (empty($dbnom)) {
        global $dbname;
        $dbnom = $dbname;
    }
    return @sql_query("SHOW TABLES FROM $dbnom");
}

// Libère toute la mémoire et les ressources utilisées par la requête $query_id
function sql_free_result($q_id="") {
    return @mysql_free_result($q_id);
}

// Ferme la connexion avec la Base de données
function sql_close($dblink) {
    return @mysql_close($dblink);
}

?>