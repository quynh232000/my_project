<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

trait HasFilters
{
    public function scopeFilterAndSort(Builder $query, array $filters = [], ?string $sort_by = null, ?string $sort_direction = "asc")
    {
        return app(Pipeline::class)
            ->send($query)
            ->through($this->prepareFAS($filters, $sort_by, $sort_direction))
            ->thenReturn();
    }
    protected function prepareFAS(array $filters, ?string $sort_by, ?string $sort_direction)
    {
        return [
            fn($query, $next) => $this->applyFilters($query, $filters, $next),
            fn($query, $next) => $this->applyRangeFilters($query, $filters, $next),
            fn($query, $next) => $this->applySorting($query, $sort_by, $sort_direction, $next),
        ];
    }
    protected function applyFilters(Builder $query, array $filters, callable $next)
    {
        if (!empty($filters)) {
            foreach ($filters as $filter) {
                if ($filter['value']) {

                    $value = is_array($filter['value']) ? $filter['value'] :  array($filter['value']);

                    $range_pattern = '/^(from-\d+|from-\d+-to-\d+|to-\d+)$/';

                    $ranges = preg_grep($range_pattern, $value);

                    if (!$ranges) {
                        if (empty($filter['relation']) || is_null($filter['relation']) || $filter['relation'] === $query->getModel()->getTable()) {
                            $query->where($filter['column'], 'like', '%' . $filter['value'] . '%');
                        } else {
                            $query->whereHas($filter['relation'], function ($sub_query) use ($filter) {
                                $sub_query->where($filter['column'], 'like', '%' . $filter['value'] . '%');
                            });
                        }
                    } else {
                        continue;
                    }
                } else {
                    continue;
                }
            }
        }
        return $next($query);
    }
    protected function applyRangeFilters(Builder $query, array $filters, callable $next)
    {
        if (!empty($filters)) {
            foreach ($filters as $filter) {

                if ($filter['value']) {

                    $value = is_array($filter['value']) ? $filter['value'] :  array($filter['value']);

                    $range_pattern = '/^(from-\d+|from-\d+-to-\d+|to-\d+)$/';

                    $ranges = preg_grep($range_pattern, $value);
                    if ($ranges) {
                        foreach ($ranges as $range_value) {
                            if (preg_match('/^to-(\d+)$/', $range_value, $matches)) {
                                $query->where($filter['column'], '<=', (int)$matches[1]);
                            } elseif (preg_match('/^from-(\d+)-to-(\d+)$/', $range_value, $matches)) {
                                $query->whereBetween($filter['column'], [(int)$matches[1], (int)$matches[2]]);
                            } elseif (preg_match('/^from-(\d+)$/', $range_value, $matches)) {
                                $query->where($filter['column'], '>=', (int)$matches[1]);
                            }
                        }
                    }
                }
            }
        }
        return $next($query);
    }
    protected function applySorting(Builder $query, ?string $sort_by, ?string $sort_direction, callable $next)
    {
        if ($sort_by && $sort_direction) {
            $query->orderBy($sort_by, $sort_direction);
        }
        return $next($query);
    }
}
