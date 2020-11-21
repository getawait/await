<?php

namespace Tests\Feature;

use App\Exports\SubscribersExport;
use App\Models\Subscriber;
use App\Models\Waitlist;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class ExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_download_subscribers_export()
    {
        Excel::fake();
        $waitlist = Waitlist::factory()
            ->has(Subscriber::factory()->count(3))
            ->create();
        $owner = $waitlist->team->owner;
        $subscribers = $waitlist->subscribers;

        $this->actingAs($owner)
            ->get('/lists/' . $waitlist->id . '/export');

        Excel::assertDownloaded($waitlist->name . '-' . Carbon::now()->toString() . '.csv',
            function (SubscribersExport $export) use ($subscribers) {
                return $export->collection()->count() === $subscribers->count();
            });
    }
}