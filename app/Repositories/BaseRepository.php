<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

abstract class BaseRepository
{
    /** @var Model|Builder */
    protected $model;

    public function __construct()
    {
        $class = $this->getClass();
        $this->model = new $class;
    }

    abstract protected function getClass(): string;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return $this->model
            ->get();
    }

    /**
     * @param $paginate integer
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginated(int $paginate)
    {
        return $this
            ->model
            ->paginate($paginate);
    }

    /**
     * @param array $input
     * @return Model|Builder
     */
    public function create(array $input)
    {
        $model = $this->model;
        $model->fill($input);
        $model->save();

        return $model;
    }

    /**
     * @param $id integer
     * @return Model|Builder|object|null
     */
    public function find($id)
    {
        return $this->model->where('id', $id)->first();
    }

    /**
     * @param $id integer
     * @return bool|int|null
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        return $this->find($id)->delete();
    }

    /**
     * @param $id integer
     * @param array $input
     * @return Model|Builder|object|null
     */
    public function update(int $id, array $input)
    {
        $model = $this->find($id);
        $model->fill($input);
        $model->save();

        return $model;
    }
}