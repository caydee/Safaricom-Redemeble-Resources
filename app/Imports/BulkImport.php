<?php

namespace App\Imports;

use App\Models\BulkDispersement;
use Maatwebsite\Excel\Concerns\ToModel;

class BulkImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new BulkDispersement([

                'msisdn'     => $row[0],


        ]);
    }
}
