<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Report;

class ReportController extends Controller
{
    public function reportContent(Request $request, $id_content)
    {
        $reportModel = new Report;
        return $reportModel->reportContent($request, $id_content);
    }
}
