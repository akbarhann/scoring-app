<?php

namespace App\Imports;

use App\Models\Chart;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ChartsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Chart([
            'red_name'      => $row[0],
            'red_club'      => $row[1],
            'blue_name'     => $row[2],
            'blue_club'     => $row[3],
            'match_number'  => $row[4],
        ]);
    }
}
