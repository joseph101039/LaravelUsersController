<?php


namespace App\Management;


use Illuminate\Support\Facades\DB;

abstract class BaseRepository
{
    public $defaultMysqlSet;

    public function __construct()
    {
        $this->defaultMysqlSet = 'commission_management';
    }

    public function create($data)
    {
        return $this->query()->create($data);
    }

    public function getAll($where_data, $where_in_data = [])
    {
        return $this->query()->where(function ($query) use ($where_data, $where_in_data) {
            foreach ($where_data as $key => $value) {
                $query->where($key, $value);
            }
            foreach ($where_in_data as $key => $value) {
                $query->whereIn($key, $value);
            }
        })->get();
    }

    /**
     * 找出單一值
     * @param integer $id - 傳入ID
     */
    public function find($id)
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * GET 資料庫資料
     * @param array $validator_data - 傳入所要撈取的條件陣列
     */
    public function get($validator_data)
    {
        return $this->query()->where(function ($query) use ($validator_data) {
            foreach ($validator_data as $key => $value) {
                $query->where($key, $value);
            }
        })->get();
    }

    /**
     *GET Fisrt 資料庫資料
     * @param array $validator_data - 傳入所要撈取的條件陣列
     */
    public function first($validator_data)
    {
        return $this->query()->where(function ($query) use ($validator_data) {
            foreach ($validator_data as $key => $value) {
                $query->where($key, $value);
            }
        })->first();
    }

    public function update($data, $id)
    {
        return $this->query()->where('id', $id)->update($data);
    }

    private function query()
    {
        return call_user_func(static::MODEL . '::query');
    }

    public function delete($field, $id)
    {
        return $this->query()
            ->where($field, $id)
            ->delete();
    }

}
