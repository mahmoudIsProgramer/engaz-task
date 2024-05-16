<?php

namespace app\core\db;

use app\core\Model;
use app\core\Application;

 
abstract class DbModel extends Model
{
    abstract public static function tableName(): string;

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (" . implode(",", $attributes) . ") 
                VALUES (" . implode(",", $params) . ")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public function update()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => "$attr = :$attr", $attributes);
        $primaryKey = $this->primaryKey();
        $statement = self::prepare("UPDATE $tableName SET " . implode(", ", $params) . " WHERE $primaryKey = :primaryKey");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->bindValue(":primaryKey", $this->{$primaryKey});
        $statement->execute();
        return true;
    }


    // public static function query(): QueryBuilder
    // {
    //     return (new QueryBuilder())->table(static::tableName());
    // }
    public static function query(): QueryBuilder
    {
        return (new QueryBuilder(static::class))->table(static::tableName());
    }


    public static function findAll(int $page = 1, int $pageSize = 10): array
    {
        $tableName = static::tableName();
        $offset = ($page - 1) * $pageSize;
        // $orderClause = self::orderBy($orderBy, $direction);
        $statement = self::prepare("SELECT * FROM $tableName LIMIT :limit OFFSET :offset");
        $statement->bindValue(':limit', $pageSize, \PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, \PDO::PARAM_INT);

        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function countAll(): int
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT COUNT(*) FROM $tableName");
        $statement->execute();
        return (int) $statement->fetchColumn();
    }

    public static function prepare($sql): \PDOStatement
    {
        return Application::$app->db->prepare($sql);
    }

    public static function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function orderBy(string $column='id', string $direction='DESC'): string
    {
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC'; // Ensure the direction is either 'ASC' or 'DESC'
        return "ORDER BY $column $direction";
    }


    public function delete(): bool
    {
        $primaryKey = $this->primaryKey();
        $tableName = static::tableName();
        $statement = self::prepare("DELETE FROM $tableName WHERE $primaryKey = :primaryKey");
        $statement->bindValue(":primaryKey", $this->{$primaryKey});
        return $statement->execute();
    }
    
}