<?php


namespace App\Exports;


use App\Exports\Sheets\SubjectSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SubjectsExport implements WithMultipleSheets
{
    use Exportable;

    protected $userId;

    public function __construct(?int $userId)
    {
        $this->userId = $userId;
    }

    public function sheets(): array
    {
        return [
            new SubjectSheet('Комнаты', 3,null, $this->userId),
            new SubjectSheet('Однушки', 1,1, $this->userId),
            new SubjectSheet('Двушки', 1,2, $this->userId),
            new SubjectSheet('Трешки', 1,3, $this->userId),
            new SubjectSheet('Четырешки', 1,null, $this->userId),
            new SubjectSheet('Дома', 2,null, $this->userId),
        ];
    }
}
