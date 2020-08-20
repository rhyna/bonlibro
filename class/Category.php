<?php

class Category
{
    static public function getAllCategories($conn) {
        $sql = 'SELECT * FROM category ORDER BY name';
        $result = $conn->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

}