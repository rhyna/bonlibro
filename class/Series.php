<?php


class Series
{
    static public function getAllSeries($conn)
    {
        $sql = 'SELECT * FROM series ORDER BY name';
        $result = $conn->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}