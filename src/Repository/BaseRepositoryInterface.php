<?php

namespace Napp\Core\Dbal\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Napp\Core\Dbal\Criteria\CriteriaCollectionInterface;

interface BaseRepositoryInterface
{
    /**
     * @param int   $id
     * @param array $relations
     *
     * @return Model|null
     */
    public function find(int $id, array $relations = []);

    /**
     * @param array $ids
     * @param array $relations
     * @param array $columns
     *
     * @return Collection
     */
    public function findMany(array $ids, array $relations = [], $columns = ['*']);

    /**
     * @param string $attribute
     * @param mixed  $value
     *
     * @return Model|null
     */
    public function findByAttribute(string $attribute, $value);

    /**
     * @param array $attributes
     *
     * @return Model|null
     */
    public function findByAttributes(array $attributes);

    /**
     * @param CriteriaCollectionInterface $criteriaCollection
     *
     * @return Model|null
     */
    public function findMatchingCriteria(CriteriaCollectionInterface $criteriaCollection);

    /**
     * @param array $relations
     *
     * @return Collection
     */
    public function getAll(array $relations = []): Collection;

    /**
     * @param string       $attribute
     * @param array|string $value
     * @param array        $relations
     *
     * @return Collection
     */
    public function getAllByAttribute(string $attribute, $value, array $relations = []): Collection;

    /**
     * @param array $attributes
     * @param array $relations
     *
     * @return Collection
     */
    public function getAllByAttributes(array $attributes, array $relations = []): Collection;

    /**
     * @param CriteriaCollectionInterface $criteriaCollection
     *
     * @return Collection
     */
    public function getAllMatchingCriteria(CriteriaCollectionInterface $criteriaCollection): Collection;

    /**
     * @param callable $callback
     * @param int      $attempts
     *
     * @throws \Throwable
     *
     * @return mixed
     */
    public function transaction(callable $callback, $attempts = 1);
}
