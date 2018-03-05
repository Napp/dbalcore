<?php

namespace Napp\Core\Dbal\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Napp\Core\Dbal\Criteria\CriteriaCollectionInterface;

abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $query;

    /**
     * @param int $id
     * @param array $relations
     * @return Model|Collection|null
     */
    public function find(int $id, array $relations = [])
    {
        return $this->query->newQuery()->with($relations)->find($id);
    }

    /**
     * @param array  $ids
     * @param array $relations
     * @param array  $columns
     * @return Collection
     */
    public function findMany(array $ids, array $relations = [], $columns = ['*'])
    {
        return $this->query->newQuery()->with($relations)->findMany($ids, $columns);
    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @return Model|null
     */
    public function findByAttribute(string $attribute, $value)
    {
        return $this->query->newQuery()->where($attribute, $value)->first();
    }

    /**
     * @param array $attributes
     * @return Model|null
     */
    public function findByAttributes(array $attributes)
    {
        return $this->query->newQuery()->where($attributes)->first();
    }

    /**
     * @param CriteriaCollectionInterface $criteriaCollection
     * @return Model|null
     */
    public function findMatchingCriteria(CriteriaCollectionInterface $criteriaCollection)
    {
        $query = $this->getCriteriaQuery($criteriaCollection);

        return $query->first();
    }

    /**
     * @param array $relations
     * @return Collection
     */
    public function getAll(array $relations = []): Collection
    {
        return $this->query->newQuery()->with($relations)->get();
    }

    /**
     * @param string $attribute
     * @param array|string $value
     * @param array $relations
     * @return Collection
     */
    public function getAllByAttribute(string $attribute, $value, array $relations = []): Collection
    {
        $query = $this->query->newQuery()->with($relations);

        if (true === is_array($value)) {
            return $query->whereIn($attribute, $value)->get();
        }

        return $query->where($attribute, $value)->get();
    }

    /**
     * @param array $attributes
     * @param array $relations
     * @return Collection
     */
    public function getAllByAttributes(array $attributes, array $relations = []): Collection
    {
        return $this->query->newQuery()->with($relations)->where($attributes)->get();
    }

    /**
     * @param CriteriaCollectionInterface $criteriaCollection
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getCriteriaQuery(CriteriaCollectionInterface $criteriaCollection): Builder
    {
        $query = $this->query->newQuery();
        $query->getQuery()->select($this->query->getTable() . '.*');

        foreach ($criteriaCollection->getAll() as $criterion) {
            $criterion->apply($query);
        }

        return $query;
    }

    /**
     * @param CriteriaCollectionInterface $criteriaCollection
     * @return Collection
     */
    public function getAllMatchingCriteria(CriteriaCollectionInterface $criteriaCollection): Collection
    {
        $query = $this->getCriteriaQuery($criteriaCollection);

        return $query->get();
    }
}
