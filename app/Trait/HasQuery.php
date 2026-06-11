<?php

namespace App\Trait;

use Illuminate\Support\Facades\DB;

trait HasQuery
{
    public function scopeWithRelations($query, array $with = [])
    {
        if (empty($with)) {
            return $query;
        }
        $simpleRelations = [];
        foreach ($with as $relation) {
            if (strpos($relation, '.') === false) {
                $simpleRelations[] = $relation;
            }
        }
        $query->with($with);
        if (!empty($simpleRelations)) {
            $query->withCount($simpleRelations);
        }
        return $query;
    }
    public function scopeKeyword($query, array $keyword = [])
    {
        if (!empty($keyword['q'])) {
            foreach ($keyword['fields'] as $field) {
                $query->orWhere($field, 'LIKE', '%' . $keyword['q'] . '%');
            }
        }
        return $query;
    }
    public function scopeSimple($query, array $filter = [])
    {
        if (count($filter)) {
            foreach ($filter as $key => $val) {
                if ($val !== 0 && !empty($val) && $val !== null) {
                    $query->where($key, $val);
                }
            }
        }
        return $query;
    }
    public function scopeComplex($query, array $filter = [])
    {
        if (count($filter)) {
            foreach ($filter as $key => $condition) {
                foreach ($condition as $operations => $val) {
                    switch ($operations) {
                        case 'lt':
                            $query->where($filter, '<', $val);
                            break;
                        case 'lte':
                            $query->where($filter, '<=', $val);
                            break;
                        case 'gt':
                            $query->where($filter, '>', $val);
                            break;
                        case 'gte':
                            $query->where($filter, '>=', $val);
                            break;
                        case 'eq':
                            $query->where($filter, '=', $val);
                            break;
                        case 'in':
                            $in = explode(',', $val);
                            if (count($in)) {
                                $query->whereIn($filter, $val);
                            };
                            break;
                        case 'between':
                            [$min, $max] = explode(',', $val);
                            if ((int)$max > (int)$min) {
                                $query->whereBetween($key, [$min, $max]);
                            }
                            break;
                        default:
                            # code...
                            break;
                    }
                }
            }
        }
    }
}
