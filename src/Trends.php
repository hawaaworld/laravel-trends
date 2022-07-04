<?php

namespace Hawaaworld\Trends;

use Hawaaworld\Trends\Contracts\Energy as EnergyContract;
use Hawaaworld\Trends\Models\Energy;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class Trends
{
    public function add(EnergyContract $model, float $amount = 1.0): void
    {
        $model->addEnergy($amount);
    }

    public function getEnergy($model): float
    {
        return (float) $model->energy->amount;
    }

    public function top(int $limit = 10, string $model = null): Collection
    {
        return Energy::query()
            ->with('energiser')
            ->when($model, fn (Builder $query) => $query->where('energiser_type', $model))
            ->latest('amount')
            ->take($limit)
            ->get()
            ->pluck('energiser');
    }
}
