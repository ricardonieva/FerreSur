<?php

abstract class Database {

    public static function connectDB()
    {
        try
        {
            $connection = new PDO("mysql:host=localhost; dbname=ferresur2","root");
        } 
        catch (PDOException $e) 
        {
            echo "no se ha podido conectar <br>";
            die ("Error: ".$e->getMessage());
        }
        return $connection;
    }
}
?>