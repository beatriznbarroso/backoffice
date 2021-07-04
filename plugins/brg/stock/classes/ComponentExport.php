<?php namespace Brg\Stock\Classes;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Brg\Stock\Models\Component as ComponentModel;

class ComponentExport implements FromCollection, WithHeadings
{
  public function collection()
  {
    ob_end_clean();
    return ComponentModel::all();
  }

  public function headings(): array
  {
    return [
      'Id',
      'Name',
      'Reference',
      'Cost',
      'Weight',
      'Quantity',
      'Quantity Alert',
      'Supplier Name',
      'Created At',
      'Updated At',
      'Deleted At'
    ];
  }
}