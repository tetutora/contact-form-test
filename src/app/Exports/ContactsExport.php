<?php

// App/Exports/ContactsExport.php
namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ContactsExport implements FromCollection, WithHeadings
{
    protected $contacts;

    public function __construct($contacts)
    {
        $this->contacts = $contacts;
    }

    public function collection()
    {
        return $this->contacts;
    }

    public function headings(): array
    {
        return ['お名前', '性別', 'メールアドレス', 'お問い合せの種類', '内容'];
    }
}
