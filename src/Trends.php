<?php

namespace Hawaaworld\Trends;

use Hawaaworld\Trends\Contracts\Energy as EnergyContract;
use Hawaaworld\Trends\Models\Energy;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

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

    public function top(int $limit = 10, string $model = null, callable $builder = null): Collection
    {
        return Energy::query()
            ->with($builder ? ['energiser' => fn ($query) => $builder($query)] : 'energiser')
            ->whereHas('energiser', $builder)
            ->when($model, fn (Builder $query) => $query->where('energiser_type', $model))
            ->latest('amount')
            ->limit($limit)
            ->get()
            ->pluck('energiser')
            ->filter();
    }
}
