<?php

class Book
{
    public $id;
    public $name;
    public $price;
    public $set_number;
    public $description;
    public $category_id;
    public $category_name;
    public $author_id;
    public $author_name;
    public $publisher_id;
    public $publisher_name;
    public $series_id;
    public $series_name;
    public $is_bestseller;
    public $is_new;
    public $image;
    public $discount;
    public $errors = [];
    public $imageErrors = [];

    private static $rootSQL = 'select book.*,
            c.name as category_name,
            a.name as author_name,
            p.name as publisher_name,
            s.name as series_name
            from book
            left join category c on book.category_id = c.id
            left join author a on book.author_id = a.id
            left join publisher p on book.publisher_id = p.id
            left join series s on book.series_id = s.id';

    static public function getAllBooks($conn)
    {
        $sql = self::$rootSQL;
        $result = $conn->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function getNewBooks($conn)
    {
        $sql = self::$rootSQL . ' WHERE is_new = 1';
        $result = $conn->query($sql);
        return $result->fetchAll(PDO::FETCH_CLASS, 'Book');
    }

    static public function getBestsellerBooks($conn)
    {
        $sql = self::$rootSQL . ' WHERE is_bestseller = 1';
        $result = $conn->query($sql);
        return $result->fetchAll(PDO::FETCH_CLASS, 'Book');
    }

    static public function getDiscountBooks($conn)
    {
        $sql = self::$rootSQL . ' WHERE discount is not null';
        $result = $conn->query($sql);
        return $result->fetchAll(PDO::FETCH_CLASS, 'Book');
    }

    static public function getDiscountBooksPage($conn, $limit, $offset)
    {
        $sql = 'select b.*,
            c.name as category_name,
            a.name as author_name,
            p.name as publisher_name,
            s.name as series_name
            from (select *  from book where book.discount is not null
            order by id limit :limit offset :offset)
            as b
            left join category c on b.category_id = c.id
            left join author a on b.author_id = a.id
            left join publisher p on b.publisher_id = p.id
            left join series s on b.series_id = s.id';

        $statement = $conn->prepare($sql);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'Book');
    }

    public function getBook($conn, $id): ?Book // returns Book or NULL
    {
        $sql = self::$rootSQL . ' where book.id = :id';
        $statement = $conn->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'Book');
        $statement->execute();
        $result = $statement->fetch();

        return $result ? $result : null;
    }

    static public function getBooksByCategory($conn, $id)
    {
        $sql = self::$rootSQL . ' where book.category_id = :id';
        $statement = $conn->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'Book');
        $statement->execute();
        return $statement->fetchAll();
    }

    static public function getCategoryPage($conn, $category_id, $limit, $offset)
    {
        $sql = 'select b.*,
            c.name as category_name,
            a.name as author_name,
            p.name as publisher_name,
            s.name as series_name
            from (select *  from book where book.category_id = :category_id
            order by id limit :limit offset :offset)
            as b
            left join category c on b.category_id = c.id
            left join author a on b.author_id = a.id
            left join publisher p on b.publisher_id = p.id
            left join series s on b.series_id = s.id';

        $statement = $conn->prepare($sql);
        $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'Book');
    }

    public function updateBook($conn)
    {
        if (self::validateBook($conn)) {
            $sql = "UPDATE book 
                SET name = :name, 
                price = :price, 
                set_number = :setnumber, 
                description = :description, 
                category_id = :categoryId, 
                author_id = :authorId, 
                publisher_id = :publisherId, 
                series_id = :seriesId, 
                is_bestseller = :isBestseller, 
                is_new = :isNew,
                discount = :discount 
                WHERE id = :id";

            $statement = $conn->prepare($sql);
            $statement->bindValue(':id', $this->id, PDO::PARAM_INT);
            $statement->bindValue(':name', $this->name, PDO::PARAM_STR);
            $statement->bindValue(':price', $this->price, PDO::PARAM_INT);
            $statement->bindValue(':setnumber', $this->set_number, PDO::PARAM_INT);
            $statement->bindValue(':description', $this->description, PDO::PARAM_STR);
            $statement->bindValue(':categoryId', $this->category_id, PDO::PARAM_STR);
            $statement->bindValue(':authorId', $this->author_id, PDO::PARAM_STR);
            if ($this->publisher_id == '') {
                $statement->bindValue(':publisherId', $this->publisher_id, PDO::PARAM_NULL);
            } else {
                $statement->bindValue(':publisherId', $this->publisher_id, PDO::PARAM_STR);
            }
            if ($this->series_id == '') {
                $statement->bindValue(':seriesId', $this->series_id, PDO::PARAM_NULL);
            } else {
                $statement->bindValue(':seriesId', $this->series_id, PDO::PARAM_STR);
            }
            $statement->bindValue(':isBestseller', $this->is_bestseller, PDO::PARAM_INT);
            $statement->bindValue(':isNew', $this->is_new, PDO::PARAM_INT);
            if ($this->discount == '') {
                $statement->bindValue(':discount', $this->discount, PDO::PARAM_NULL);
            } else {
                $statement->bindValue(':discount', $this->discount, PDO::PARAM_INT);
            }

            return $statement->execute();
        }

        return false;
    }

    public function setBookImage($conn, $imageName)
    {
        $sql = "UPDATE book SET image = :image WHERE id = :id";

        $statement = $conn->prepare($sql);

        $statement->bindValue(':id', $this->id, PDO::PARAM_INT);

        $statement->bindValue(':image', $imageName, $imageName === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        return $statement->execute();
    }

    public function validateBook($conn)
    {
        if ($this->name == '') {
            $this->errors[] = 'Введите название';
        }

        if ($this->price == '') {
            $this->errors[] = 'Введите цену';
        }

        if ($this->description == '') {
            $this->errors[] = 'Введите описание';
        }

        if ($this->set_number == '') {
            $this->errors[] = 'Введите артикул';
        }

        if ($this->set_number && !$this->id) {
            if (self::checkSetNumberDuplicates($conn)) {
                $this->errors[] = 'Книга с таким артикулом уже существует';
            }
        }

        return $this->errors ? false : true;
    }

    public function deleteBook($conn)
    {
        $sql = "delete from book where id = :id";

        $statement = $conn->prepare($sql);

        $statement->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function createBook($conn): bool
    {
        if (self::validateBook($conn)) {
            $sql = "INSERT INTO book
                    (name,
                     price,
                     set_number,
                     description,
                     category_id,
                     author_id,
                     publisher_id,
                     series_id,
                     is_bestseller,
                     is_new,
                     discount)
            VALUES (:name,
                    :price,
                    :setnumber,
                    :description,
                    :categoryId,
                    :authorId,
                    :publisherId,
                    :seriesId,
                    :isBestseller,
                    :isNew,
                    :discount)";

            $statement = $conn->prepare($sql);
            $statement->bindValue(':name', $this->name, PDO::PARAM_STR);
            $statement->bindValue(':price', $this->price, PDO::PARAM_INT);
            $statement->bindValue(':setnumber', $this->set_number, PDO::PARAM_INT);
            $statement->bindValue(':description', $this->description, PDO::PARAM_STR);
            $statement->bindValue(':categoryId', $this->category_id, PDO::PARAM_STR);
            $statement->bindValue(':authorId', $this->author_id, PDO::PARAM_STR);
            if ($this->publisher_id == '') {
                $statement->bindValue(':publisherId', $this->publisher_id, PDO::PARAM_NULL);
            } else {
                $statement->bindValue(':publisherId', $this->publisher_id, PDO::PARAM_STR);
            }
            if ($this->series_id == '') {
                $statement->bindValue(':seriesId', $this->series_id, PDO::PARAM_NULL);
            } else {
                $statement->bindValue(':seriesId', $this->series_id, PDO::PARAM_STR);
            }
            $statement->bindValue(':isBestseller', $this->is_bestseller, PDO::PARAM_INT);
            $statement->bindValue(':isNew', $this->is_new, PDO::PARAM_INT);
            if ($this->discount == '') {
                $statement->bindValue(':discount', $this->discount, PDO::PARAM_NULL);
            } else {
                $statement->bindValue(':discount', $this->discount, PDO::PARAM_INT);
            }

            if ($statement->execute()) {
                $this->id = $conn->lastInsertId();
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function fillBookObject($data)
    {
        $this->name = $data['name'];
        $this->price = $data['price'];
        $this->set_number = $data['setnumber'];
        $this->description = $data['description'];
        $this->category_id = $data['categoryId'];
        $this->author_id = $data['authorId'];
        $this->publisher_id = $data['publisherId'];
        $this->series_id = $data['seriesId'];
        $this->is_bestseller = $data['isBestseller'];
        $this->is_new = $data['isNew'];
        $this->discount = $data['discount'];
    }

    public function checkSetNumberDuplicates($conn)
    {
//        if (isset($this->id)) {
//            $sql = "select * from book where set_number = $this->set_number and id <> $this->id";
//        } else {
//            $sql = "select * from book where set_number = $this->set_number";
//        }

        $sql = "select * from book where set_number = $this->set_number";

        $result = $conn->query($sql);

        return $result->fetch();
    }

    public function getDiscountedPrice(): ?int
    {
        if ($this->discount) {
            return $this->price - ($this->price * $this->discount / 100);
        }

        return null;
    }

    public static function getTotalOfBooksByCategory($conn, $category_id)
    {
        $sql = 'select count(*) from book where category_id = :category_id';

        $statement = $conn->prepare($sql);

        $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);

        $statement->setFetchMode(PDO::FETCH_CLASS, 'Book');

        $statement->execute();

        return $statement->fetchColumn();
    }

    public static function getTotalOfDiscountBooks($conn)
    {
        $sql = 'select count(*) from book where discount is not null';

        $result = $conn->query($sql);

        return $result->fetchColumn();
    }
}