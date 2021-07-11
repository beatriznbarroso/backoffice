<?php namespace Brg\Stock\Classes;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;


class XlsHelper
{
  public static function exportCustom($name, $data, $inverse = true){

    $file_name = $name.'.xlsx'; //.'_'.uniqid(1)

    // If inverse = true we have the columns (1 array per column) and we need to iterate the rows (1 array per row)
    if($inverse){
      $columns = $data;
      $data = [];
      $headers = array_keys($columns); // The column key is the header
      array_push($data, $headers);
      $rows_n = sizeof($columns[array_keys($columns)[0]]); // How many rows there are
      
      for($i=0; $i<$rows_n; $i++){
        $row = [];
        foreach($columns as $column){
          try{
            array_push($row, $column[$i]);
          }
          catch (\Exception $e) {
            \Log::debug('[exportCustom, row number '.$i.'] Error extracting information from data: '.json_encode($e));
          }
      }
        array_push($data, $row);
      }
    }
    ob_end_clean();
    return Excel::download(new CollectionExport($data), $file_name);
    // return Excel::download(new CollectionExport($data), $file_name);
  }
}

class CollectionExport implements FromCollection, WithStrictNullComparison
//, WithDrawings, WithStartRow, WithHeadings, WithHeadingRow
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