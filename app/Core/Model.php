<?php
declare(strict_types=1);

namespace App\Core;

use PDO;

abstract class Model
{
    protected string $table;
    protected string $primaryKey = 'id';
    protected array $fillable = [];

    protected function db(): PDO
    {
        return Database::connection();
    }

    public function all(string $orderBy = 'created_at DESC'): array
    {
        $statement = $this->db()->query("SELECT * FROM {$this->table} ORDER BY {$orderBy}");
        return $statement->fetchAll();
    }

    public function latest(int $limit = 5): array
    {
        $statement = $this->db()->prepare("SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT :limit");
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function find(int $id): ?array
    {
        $statement = $this->db()->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1");
        $statement->execute(['id' => $id]);
        $record = $statement->fetch();

        return $record ?: null;
    }

    public function count(string $where = '1 = 1', array $params = []): int
    {
        $statement = $this->db()->prepare("SELECT COUNT(*) FROM {$this->table} WHERE {$where}");
        $statement->execute($params);

        return (int) $statement->fetchColumn();
    }

    public function sum(string $column, string $where = '1 = 1', array $params = []): float
    {
        $statement = $this->db()->prepare("SELECT COALESCE(SUM({$column}), 0) FROM {$this->table} WHERE {$where}");
        $statement->execute($params);

        return (float) $statement->fetchColumn();
    }

    public function create(array $attributes): int
    {
        $data = array_intersect_key($attributes, array_flip($this->fillable));
        $columns = array_keys($data);
        $placeholders = array_map(static fn(string $column): string => ':' . $column, $columns);

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );

        $statement = $this->db()->prepare($sql);
        $statement->execute($data);

        return (int) $this->db()->lastInsertId();
    }

    public function update(int $id, array $attributes): bool
    {
        $data = array_intersect_key($attributes, array_flip($this->fillable));

        if ($data === []) {
            return false;
        }

        $assignments = array_map(static fn(string $column): string => "{$column} = :{$column}", array_keys($data));
        $data['id'] = $id;

        $sql = sprintf(
            'UPDATE %s SET %s WHERE %s = :id',
            $this->table,
            implode(', ', $assignments),
            $this->primaryKey
        );

        return $this->db()->prepare($sql)->execute($data);
    }
}
