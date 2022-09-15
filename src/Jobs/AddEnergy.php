<?php

namespace Hawaaworld\Trends\Jobs;

use Hawaaworld\Trends\Contracts\Energy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class AddEnergy implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public Energy $model, public float $amount)
    {
    }

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        $energy = $this->model->energy()->firstOrNew();
        $energy->amount += $this->amount;

        try {
            $energy->save();
        } catch (QueryException) {
            return;
        }

        $sequence = config('trends.loss_sequence', [1]);

        LossEnergy::dispatch($energy, $this->amount, $sequence)->delay(
            now()->addMinutes(config('trends.loss_time'))
        );
    }
}
