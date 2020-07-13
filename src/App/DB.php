<?php
namespace App;

class DB { 
    static $conn;
    static function getConn(){
        if(!self::$conn){
            $option = [\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];
            self::$conn = new \PDO("mysql:host=localhost;dbname=seoul_1;charset=utf8mb4", "root", "", $option);
        }
        return self::$conn;
    }

    static function query($sql, $data = []){
        $q = self::getConn()->prepare($sql);
        $q->execute($data);
    }

    Static function fetch($sql, $data = []){
        $q = self::getConn()->prepare($sql);
        $q->execute($data);
        return $q->fetch();
    }

    static function fetchAll($sql, $data = []){
        $q = self::getConn()->prepare($sql);
        $q->execute($data);
        return $q->fetchAll();
    }

    static function find($table, $id){
        return self::fetch("SELECT * FROM `$table` WHERE id = ?", [$id]);
    }

    static function who($email){
        return self::fetch("SELECT * FROM users WHERE email = ?", [$email]);
    }

    static function lastInsertId(){
        return self::getConn()->lastInsertId();
    }
}