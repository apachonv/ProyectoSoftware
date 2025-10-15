<?php

namespace App\Http\Controllers;

use App\Exports\ReservationsReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function exportReservations()
    {
            
        $fileName = 'reservas_' . now()->format('Y_m_d_H_i_s') . '.xlsx';
        $filePath = 'exports/' . $fileName;
        
        Excel::store(new ReservationsReportExport, $filePath, 'public');

        $fileUrl = asset('storage/' . $filePath);

        return response()->json([
            'message' => 'Reporte generado correctamente.',
            'file_url' => $fileUrl
        ]);
    }
}

