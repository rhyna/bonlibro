<?php


class Author
{
    static public function getAllAuthors($conn)
    {
        $sql = 'SELECT * FROM author ORDER BY name';
        $result = $conn->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}