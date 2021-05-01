<?php namespace Brg\Stock\Classes;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Facades\Excel;

class LaravelExcelHelper
{
    public static function exportCustom($name, $data, $inverse = true){
        
        $file_name = $name.'_.xlsx'; 

        ob_end_clean();

        // If inverse = true we have the columns (1 array per column) and we need to iterate the rows (1 array per row)
        return Excel::download(new CollectionExport($data), $file_name);

    }

}

class CollectionExport implements FromCollection
{
    use Exportable;

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect([
            $this->data
        ]);
    }
}