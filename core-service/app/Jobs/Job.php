<?php

namespace App\Jobs;

use Egal\Model\Model;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class Job implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected mixed $model;

    public int $tries = 2;

    public function __construct($model = null)
    {
        $this->model = $model;
    }

    public function getDeserialize()
    {
        return unserialize($this->job->payload()['data']['command']);
    }

    public function getJobModel(): Model
    {
        return $this->model;
    }

}
