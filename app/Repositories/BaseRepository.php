<?php

namespace App\Repositories;

use App\Data\Acl;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Thelabdevtz\LaraBase\Core\Utilities\Helpers;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements RepositoryInterface
{
    protected Model $model;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $params
     * @param array $with
     * @param null $callable |null $callable
     */
    public function get($params = [], $with = [], $callable = null)
    {
        $q = $this->model->with($with);

        $q->orderBy($params['order_by'] ?? 'id', $params['order_sort'] ?? 'desc');

        // filter collection by store_id
        if (Helpers::hasValue($params['store_id']))
            $q->where('store_id', $params['store_id']);

        // filter active collection by is_active
        if (Helpers::hasValue($params['is_active']))
            $q->where('is_active', $params['is_active']);


        // remove superuser role from the collection
        if (Helpers::hasValue($params['is_superuser']))
            $q->where('name', '!=', Acl::ROLE_SUPERUSER);

        // filter collection by range of dates or current date
        if (Helpers::hasValue($params['date_from']) && Helpers::hasValue($params['to_date'])) {
            $q->whereBetween(DB::raw('DATE(created_at)'), [$params['date_from'], $params['to_date']]);
        } else {
            // filter collection by current date
            if(Helpers::hasValue($params['current_date']))
                $q->whereDate(DB::raw('DATE(created_at)'), $params['current_date']);
        }

        /**
         * filter product_purchase table by product name having item_count greater than 0
         * @param $q
         * @param $params
         */
        if (Helpers::hasValue($params['product_name']))
            $q->whereHas('product', function($q) use($params){
                $q->where('name', 'LIKE', '%' . $params['product_name'] . "%");
            })
                ->where('item_count', '>', 0.00);

        // if search input was provided
        if (Helpers::hasValue($params['keyword']))
            $q->where('name', 'LIKE', '%' . $params['keyword'] . "%");

        // filter collection by company
        if (Helpers::hasValue($params['company_id']))
            $q->where('company_id', $params['company_id']);

        // filter sales by sales date range
        if (Helpers::hasValue($params['filter_sales'])){
            if (Helpers::hasValue($params['date_from']) && Helpers::hasValue($params['date_to'])) {
                $q->whereBetween(DB::raw('DATE(sales_date)'), [$params['date_from'], $params['date_to']]);
            } else {
                $q->whereDate(DB::raw('DATE(sales_date)'), Carbon::now()->toDateString());
            }
        }


        // call the function if provided
        if (!is_null($callable))
            $q = call_user_func_array($callable, [&$q]);

        // if per page is -1, we don't need to paginate at all, but we still return the paginated
        // data structure to our response. Let's just put the biggest number we can imagine.
        if (Helpers::hasValue($params['per_page']) && ($params['per_page'] == -1))
            $params['per_page'] = 999999999999;

        // if you don't want any pagination
        if (Helpers::hasValue($params['paginate']) && ($params['paginate'] == 'no'))
            return $q->get();

        return $q->paginate($params['per_page'] ?? 10);
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return bool
     *
     */
    public function update(int $id, array $attributes): bool
    {
        $model = $this->find($id);

        if (!$model) return false;

        $isUpdated = $model->update($attributes);
        if ($isUpdated) {
            return $isUpdated;
        } else {
            return false;
        }
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws Exception
     */
    public function delete(int $id): ?bool
    {
        return $this->model::query()->find($id)->delete();
    }

    /**
     * @param int $id
     * @param array $with
     * @param array $params
     * @return Model|Collection|Builder|array|null
     */
    public function find(int $id, $with = [], array $params = []): Model|Collection|Builder|array|null
    {
        $q = $this->model->with($with);

        return $this->model->with($with)->findOrFail($id);
    }

    /**
     * @param int $id
     * @return mixed|Model|boolean
     */
    public function findWithTrash(int $id): mixed
    {
        return $this->model::query()->withTrashed()->find($id);
    }

    /**
     * @param string $field
     * @param mixed $value
     * @return mixed|Model|\Thelabdevtz\LaraBase\Core\BaseRepository
     */
    public function findBy($field, $value): mixed
    {
        return $this->model->where($field, $value)->first();
    }

    public function findByWithStoreId($field, $value)
    {
        return $this->model->where($field, $value)
            ->where('store_id', storeId())->first();
    }

    /**
     * @param array $data
     * @return Model|boolean
     */
    public function create(array $data = []): Model|bool
    {
        return $this->model->create($data);
    }

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function findOrCreate($field, $value, $params = [])
    {
        if (Helpers::hasValue($params['store_id']))
            return $this->model::firstOrCreate([$field => $value, 'store_id' => $params['store_id']]);

        return $this->model::firstOrCreate([$field => $value]);
    }


    public function parseDate($date): Carbon
    {
        return Carbon::parse($date);
    }
}
