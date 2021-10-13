<?php

namespace Tests\Unit\Console;

use App\Jobs\SendEmailFavoriteBook;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class KernelTest extends TestCase
{
    public function testSchedule()
    {
        Queue::fake();

        $nextScheduledTime = Carbon::parse('next saturday at 20:00');
        $this->travelTo($nextScheduledTime);
        Artisan::call('schedule:run');

        $this->travelTo($nextScheduledTime->addDays(7));
        Artisan::call('schedule:run');

        Queue::assertPushed(SendEmailFavoriteBook::class, 2);
    }
}
