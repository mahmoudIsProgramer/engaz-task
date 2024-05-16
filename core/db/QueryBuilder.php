<?php 
namespace app\core\db;

class QueryBuilder
{
    protected string $table;
    protected array $conditions = [];
    protected string $orderBy = '';
    protected ?int $limit = null;
    protected ?int $offset = null;
    protected string $modelClass;

    public function __construct(string $modelClass)
    {
        $this->modelClass = $modelClass;
    }

    public function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    public function where(array $conditions): self
    {
        $this->conditions = $conditions;
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $this->orderBy = "ORDER BY $column $direction";
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset(int $page=1, int $pageSize=10): self
    {
        $this->offset = ($page - 1) * $pageSize;
        return $this;
    }

    public function get(): array
    {
        if (!isset($this->table)) {
            throw new \Exception('Table name must be specified');
        }

        $sql = "SELECT * FROM {$this->table}";
        
        if (!empty($this->conditions)) {
            $whereClauses = array_map(fn($col) => "$col = :$col", array_keys($this->conditions));
            $sql .= " WHERE " . implode(' AND ', $whereClauses);
        }
        
        if ($this->orderBy) {
            $sql .= " " . $this->orderBy;
        }
        
        if (isset($this->limit)) {
            $sql .= " LIMIT :limit";
        }
        
        if (isset($this->offset)) {
            $sql .= " OFFSET :offset";
        }

        $statement = DbModel::prepare($sql);

        foreach ($this->conditions as $col => $val) {
            $statement->bindValue(":$col", $val);
        }
        
        if (isset($this->limit)) {
            $statement->bindValue(':limit', $this->limit, \PDO::PARAM_INT);
        }
        
        if (isset($this->offset)) {
            $statement->bindValue(':offset', $this->offset, \PDO::PARAM_INT);
        }

        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS, $this->modelClass);
    }
}
