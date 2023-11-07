<?php

namespace App\Imports;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportShops implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return Model|null
     */
    public function model(array $row)
    {
        return new Shop([
            'name' => $row[0],
            'organization_id' => $row[1],
            'description' => $row[2],
            'description_detail' => $row[3],
            'url' => $row[4],
            'image_s' => $row[5],
            'image_l' => $row[6],
            'movie_url' => $row[7],
            'movie_flg' => $row[8],
            'one_description' => $row[9],
            'one_category' => $row[10],
            'sort_no' => $row[11],
        ]);
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}
