<?php

namespace App\Exports;

use App\Models\Subscriber;
use App\Models\Waitlist;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class SubscribersExport implements FromCollection
{
    use Exportable;

    private Waitlist $waitlist;

    public function __construct(Waitlist $waitlist)
    {
        $this->waitlist = $waitlist;
    }

    public function collection()
    {
        return Subscriber::where('waitlist_id', $this->waitlist->id)->get();
    }
}