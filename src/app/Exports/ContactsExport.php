<?
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ContactsExport implements FromCollection, WithHeadings
{
    protected $contacts;

    public function __construct($contacts)
    {
        $this->contacts = $contacts;
    }

    public function collection()
    {
        return $this->contacts->map(function ($contact) {
            return [
                $contact->last_name,
                $contact->first_name,
                $contact->email,
                $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他'),
                $contact->category_id, // このフィールドはカテゴリの名前に変換した方が良いかもしれません
                $contact->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            '姓',
            '名',
            'メールアドレス',
            '性別',
            'カテゴリ',
            '作成日',
        ];
    }
}
