<?php namespace Brg\Stock\Classes;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Brg\Stock\Models\Product as ProductModel;

class ProductExport implements FromCollection, WithHeadings
{
  public function collection()
  {
    ob_end_clean();
    return ProductModel::all();
  }

  public function headings(): array
  {
    return [
      'Id',
      'Name',
      'Code',
      'Collection',
      'Price (in Cents)',
      'Silver Quantity',
      'Labour Cost (in cents)',
      'Production Status',
      'Stop Selling',
      'Created At',
      'Updated At'
    ];
  }
}