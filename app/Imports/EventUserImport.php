<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithLimit;
use Maatwebsite\Excel\Concerns\WithStartRow;

class EventUserImport implements ToCollection, WithLimit, WithStartRow
{
    protected int $startRow;

    public function __construct(int $startRow)
    {
        $this->startRow = $startRow;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {

    }

    public function startRow(): int
    {
        return $this->startRow;
    }

    public function limit(): int
    {
        return 500;
    }
}
