<?php

namespace App\Exports;

use App\Models\Reservation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCharts;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReservationsReportExport implements FromCollection, WithHeadings, WithCharts, WithMapping
{
    protected $dataByMonth;

    public function __construct()
    {
        // Agrupar por mes y contar cantidad de huéspedes (o reservas)
        $this->dataByMonth = Reservation::selectRaw('MONTH(check_in_date) as mes, COUNT(*) as total')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();
    }

    public function collection()
    {
        return $this->dataByMonth;
    }

    public function map($row): array
    {
        return [
            date('F', mktime(0, 0, 0, $row->mes, 10)), // Nombre del mes
            $row->total,
        ];
    }

    public function headings(): array
    {
        return ['Mes', 'Total de huéspedes'];
    }

    public function charts()
    {
        $label = [new DataSeriesValues('String', 'Sheet1!$B$1', null, 1)];
        $categories = [new DataSeriesValues('String', 'Sheet1!$A$2:$A$13', null, 12)];
        $values = [new DataSeriesValues('Number', 'Sheet1!$B$2:$B$13', null, 12)];

        $series = new DataSeries(
            DataSeries::TYPE_BARCHART,
            DataSeries::GROUPING_CLUSTERED,
            range(0, count($values) - 1),
            $label,
            $categories,
            $values
        );

        $plotArea = new PlotArea(null, [$series]);
        $legend = new Legend(Legend::POSITION_RIGHT, null, false);
        $title = new Title('Total de huéspedes por mes');

        return new Chart('chart1', $title, $legend, $plotArea);
    }
}
