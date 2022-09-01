<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function get($params = [], $with = [], $callable = null);

    public function update(int $id, array $attributes);

    public function delete(int $id);

    public function find(int $id, $with = []);

    public function findWithTrash(int $id);

    public function findBy($field, $value);

    public function create(array $data = []);

    public function findOrCreate($field, $value, array $params = []);

    public function findByWithStoreId($field, $value);

    public function parseDate($date);
}
