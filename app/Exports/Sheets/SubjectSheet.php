<?php


namespace App\Exports\Sheets;


use App\Subject;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SubjectSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    protected $title;
    protected $category;
    protected $rooms;
    protected $userId;

    public function __construct(string $title, int $category, ?int $rooms, ?int $userId)
    {
        $this->title = $title;
        $this->category = $category;
        $this->rooms = $rooms;
        $this->userId = $userId;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function headings(): array
    {
        return [
            'Р-Н',
            'УЛИЦА',
            'ЦЕНА',
            'ОПИСАНИЕ',
            'ДОПЛАТА',
            'ИМЯ И НОМЕР',
            'ДАТА'
        ];
    }

    public function map($row): array
    {
        return [
            $this->getArea($row),
            $this->getStreet($row),
            $row->price,
            $row->desc,
            $row->surcharge,
            $this->getClientInfo($row),
            $row->created_at->format('Y-m-d'),
        ];
    }

    public function collection()
    {
        $result = Subject::where('category', $this->category)
            ->where('rooms', $this->rooms)
            ;

        if ($this->userId) {
            $result->where("created_id", $this->userId);
        }

        return $result->get();
    }

    public function getArea($object): string
    {
        $area = $object->raion->name ?? "";
        return str_replace(['микрорайон', 'Квартал'], ['мкр.', 'Кв-л'], $area);
    }

    public function getStreet($object): string
    {
        if ($this->category == 2) {
            return ($object->address ?? "") . "  " . ($object->build_floors ?? "") . " этаж, " . ($object->home_square ?? "") . " м²";
        } else {
            return ($object->address ?? "") . "  " . ($object->floor ?? "") . "/" . ($object->build_floors ?? "") . " этаж, " . ($object->square ?? "") . " м²";
        }
    }

    public function getClientInfo($object): string
    {
        $client = json_decode($object->client);
        return strip_tags(($client->name ?? "") . "   " . ($client->phone ?? ""));
    }
}
