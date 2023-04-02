
<?php
error_reporting();
class database {
    static function connection(){
        $mysqli = mysqli_connect('localhost', 'root', '', 'task_list');
        return $mysqli;
    }
    
    static function array_single($sql) {
        $single = mysqli_query(database::connection(), $sql);
        $array = mysqli_fetch_assoc($single);
        return $array;
    }
    
    static function array_all($sql) {
        $query = mysqli_query(database::connection(), $sql);
        $array = mysqli_fetch_all($query, MYSQLI_ASSOC);
        return $array;
    }
    
    static function query($sql) {
        $query = mysqli_query(database::connection(), $sql);
        return $query;
    }
}

?>