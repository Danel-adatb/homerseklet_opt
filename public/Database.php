<?php
//Database Query class
/**
 * Connection
 * MySQLi Query
 * 
 * querySelect([SELECT paraméterek], [Tábla neve], false, [WHERE esetén azonosító]) 
 * -> Single WHERE paraméterre van kifejlesztve, az AND-et még nem tudja!
 */

class Database {
    private $mysqli;

    function __construct() {
        require_once('config/config.php');
        $this->connection();
    }

    private function connection() {
        $this->mysqli = new mysqli (TS__DB_SERVER__,TS__DB_USER__,TS__DB_PASS__);

        if ($this->mysqli->connect_errno) {
            die ("<br><br>Nem lehet kapcsolódni a MySQL szerverhez! Hibakód: " . 
            $this->mysqli->connect_errno . "<br>" . 
            $this->mysqli->connect_error . PHP_EOL);
        }

        $this->dbTableCheck($this->mysqli);
    }

    private function dbTableCheck(&$mysqli) {
        $mysqli->select_db(TS__DB_NAME__);
        
        if ($mysqli->errno) {
            die ("<br><br>Adatbázis elérési hiba! Hibakód: " . 
            $mysqli->errno . "<br>" . 
            $mysqli->error . PHP_EOL);
        }

        $this->dbUTF8Check($mysqli);
    }
    
    private function dbUTF8Check(&$mysqli) {
        $mysqli->set_charset('utf8');
        
        if ($mysqli->errno) {
            echo ("<br><br>UTF8 karakterkészlet beállítási hiba! Lehetséges, nem a megfelelő formátumban fognak megjelenni a betűk! Hibakód: " . 
            $mysqli->errno . "<br>" . 
            $mysqli->error . PHP_EOL);
        }
    }

    public function objOrArr($data_values, $forced_arr = false) {
        $return = array();

        if (!is_object($data_values)) {
            $return = $data_values;
        } else if (!empty($data_values->num_rows) && $data_values->num_rows>0) {
            if ($data_values->num_rows == 1 && $forced_arr == false) {
                $return = $data_values->fetch_assoc();
            } else {
                while ($record = $data_values->fetch_array(MYSQLI_ASSOC)) {
                    $return[] = $record;
                }
            }
        }

        return $return;
    }

    public function query($sql) {
        $return = array();
        
        if (!empty($sql)) {
            if (substr($sql,0,10) == 'TS_SELECT ') {
                $sql = str_replace('TS_SELECT ','SELECT ',$sql);
                $data_values = $this->mysqli->query($sql);

                $return = $this->objOrArr($data_values);
            } else {//XSS!
                die;
            }
        }
        
        return $return;
    }

    public function querySelect($params = array(), $table, $where = null) {
        $return = array();
        $sql = 'TS_SELECT ';

        foreach($params as $p) {
            $sql .= $p.', ';
        }

        $sql = trim($sql, ', ');
        $sql .= ' FROM '.$table.'';
        
        if(!empty($where)) {
            $sql .= ' WHERE ';
            foreach($where as $key => $value) {
                $sql .= "$key = '$value'";
            }   
        }

        if (!empty($sql)) {
            if (substr($sql,0,10) == 'TS_SELECT ') {
                $sql = str_replace('TS_SELECT ','SELECT ',$sql);
                $datas = $this->mysqli->query($sql);

                $return = $this->objOrArr($datas);
            } else {//XSS!
                die;
            }
        }

        return $return;
    }
}