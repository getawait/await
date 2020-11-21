<?php

namespace App\Exports;

use App\Models\Subscriber;
use App\Models\Waitlist;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubscribersExport implements FromCollection, WithHeadings
{
    use Exportable;

    private Waitlist $waitlist;

    public function __construct(Waitlist $waitlist)
    {
        $this->waitlist = $waitlist;
    }

    public function headings(): array
    {
        return [
            'Id',
            'Email Address',
            'Referrer Id',
            'Joined On',
            'Was Referred',
        ];
    }

    public function collection()
    {
        return Subscriber::select('id', 'email', 'referrer_id', 'created_at', 'was_referred')
            ->where('waitlist_id', $this->waitlist->id)
            ->get();
    }
}