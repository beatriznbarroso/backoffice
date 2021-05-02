<?php namespace Brg\Stock\Classes;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Brg\Stock\Models\History as HistoryModel;

class HistoryExport implements FromCollection, WithHeadings
{
  public function collection()
  {
    ob_end_clean();
    return HistoryModel::all();
  }

  public function headings(): array
  {
    return [
      'Id',
      'Component Id',
      'Component Reference',
      'Component Name',
      'Type',
      'Quantity',
      'Created At',
      'Updated At'
    ];
  }
}