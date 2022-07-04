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

    public function __construct(
        public Energy $model,
        public float $amount,
        public array $sequence
    ) {
    }

    public function handle(): void
    {
        $this->model->amount -= array_shift($this->sequence) * $this->amount;
        $this->model->save();

        if ($this->model->amount <= 0 || empty($this->sequence)) {
            if (config('trends.truncate')) {
                $this->model->delete();
            }

            return;
        }

        self::dispatch($this->model, $this->amount, $this->sequence)->delay(
            now()->addMinutes(config('trends.loss_time'))
        );
    }
}
