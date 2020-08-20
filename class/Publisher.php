<?php


class Publisher
{
    static public function getAllPublishers($conn)
    {
        $sql = 'SELECT * FROM publisher ORDER BY name';
        $result = $conn->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}