<?php

namespace Hawaaworld\Trends\Jobs;

use Hawaaworld\Trends\Models\Energy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LossEnergy implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Energy $model, public float $amount)
    {
    }

    public function handle(): void
    {
        $this->model->amount -= $this->amount;
        $this->model->save();

        if ($this->model->amount <= 0) {
            if (config('trends.truncate')) {
                $this->model->delete();
            }

            return;
        }

        self::dispatch($this->model, $this->amount)->delay(
            now()->addMinutes(config('trends.loss_time'))
        );
    }
}
