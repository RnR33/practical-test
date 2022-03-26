<?php

namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

abstract class BaseRepository
{
    /**
     * Model for the repository.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Construct the repository.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Gets the query builder for the repository.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getBuilder()
    {
        return $this->model->newQuery();
    }

    /**
     * Lists the given fields.
     *
     * @param string $label
     * @param string $key
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function list($label = 'name', $key = 'id')
    {
        return $this->model->pluck($label, $key);
    }

    /**
     * Get the filtered content.
     *
     * @param integer $perPage
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function filter($perPage = 30)
    {
        return $this->model->paginate($perPage);
    }

    /**
     * Gets the total count.
     *
     * @return int
     */
    public function count()
    {
        return $this->model->count();
    }

    /**
     * Gets the total sum.
     *
     * @return int
     */
    public function sum($field)
    {
        return $this->model->sum($field);
    }

    /**
     * Find item by id.
     *
     * @param int $id
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find($id, $with = [])
    {
        return $this->model->with($with)->find($id);
    }

    /**
     * Find item by field.
     *
     * @param mixed $field
     * @param mixed $value
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findBy($field, $value, $with = [])
    {
        return $this->model->with($with)->where($field, $value)->first();
    }

    /**
     * Find items by field.
     *
     * @param mixed $field
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAllBy($field, $value)
    {
        return $this->model->where($field, $value);
    }

    /**
     * Find all items.
     *
     * @param mixed $perPage
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get($perPage = null)
    {
        if ( $perPage )
            return $this->model->paginate($perPage);

        return $this->model->get();
    }

    /**
     * Create the item.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function create($data)
    {
        return $this->model->create($data);
    }

    /**
     * Update the model.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function update($model, $data)
    {
        $model->update($data);

        return $model;
    }

    /**
     * Update the model by id.
     *
     * @param int $id
     * @return boolean
     */
    public function updateById($id, $data)
    {
        $model = $this->find($id);

        return $this->update($model, $data);
    }

    /**
     * Delete the model by id.
     *
     * @param int $id
     * @return boolean
     */
    public function deleteById($id)
    {
        return $this->find($id)->delete();
    }

    /**
     * Update or create the model.
     *
     * @param array $input
     * @param string $key
     * @param boolean $toArray
     * @return mixed
     */
    public function updateOrCreate($input, $key = 'id', $toArray = false)
    {
        // Find the model by key.
        $model = $this->findBy($key, Arr::get($input, $key));

        // If we cannot get from db we'll create new one.
        if (!$model) {
            $model = $this->model->newInstance($input);
        }

        // Fill object with user input using Mass Assignment
        $model->fill($input);

        // Saves the model.
        $model->save();

        return $toArray ? $model->toArray() : $model;
    }

    /**
     * Update or create the model.
     *
     * @param $input
     * @param array $keysInputs
     * @param boolean $toArray
     * @return mixed
     */
    public function updateOrCreateByFields($input ,$keysInputs =[], $toArray = false)
    {
        // Find the model by key.
        $model = $this->findByFields($keysInputs);

        // If we cannot get from db we'll create new one.
        if (!$model) {
            $model = $this->model->newInstance($input);
        }

        // Fill object with user input using Mass Assignment
        $model->fill($input);

        // Saves the model.
        $model->save();

        return $toArray ? $model->toArray() : $model;
    }

    /**
     * Find or create by the key.
     *
     * @param array $data
     * @param string $key
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findOrNewByKey($data, $key = 'code')
    {
        // If already exists in the database lets return that.
        if ( $model = $this->model->where($key, $data[$key])->first() ) {
            return $model->fill($data);
        }

        // Else create a new model.
        return $this->model->newInstance($data);
    }

    /**
     * Find or create by the key.
     *
     * @param array $data
     * @param string $key
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findOrCreateByKey($data, $key = 'code')
    {
        // If already exists in the database lets return that.
        if ( $model = $this->model->where($key, $data[$key])->first() ) {
            return $model;
        }

        // Else create a new model.
        return $this->create($data);
    }

    public function findByFields($fieldsValues = [], $with = [])
    {
        $model =  $this->model->with($with);

        foreach ($fieldsValues as $key => $value) {
            $model =  $model->where($key,$value);
        }
        return $model->first();
    }

}
