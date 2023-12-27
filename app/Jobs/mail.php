<?php

namespace App\Jobs;

use App\Mail\NewPostNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class mail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    public static function to(string $string)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    { dd("sdfsd");
        $userEmail = "harikrishnan.radhakrishnan@qburst.com";
        \Illuminate\Support\Facades\Mail::to($userEmail)->send(new NewPostNotification());
    }
}
