<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ReportsExport;
use App\Http\Controllers\Controller;
use App\Repositories\ReportRepository;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    private $reportRepository;

    public $resource = 'report';

    public function __construct(ReportRepository $reportRepository)
    {
        $this->middleware(['permission:list '.Str::plural($this->resource)]);
        $this->reportRepository = $reportRepository;
        view()->share('item', $this->resource);
    }

    /**
     *  Display a listing of the date wise sales.
     */
    public function dateWiseSalesIndex(Request $request): View
    {
        $reports = $this->reportRepository
            ->getDataWiseSales($request)
            ->paginate(10);

        return view('admin.report.index', ['methodName' => 'dateWiseSales', 'reports' => $reports]);
    }

    /**
     *  Display a listing of the sales details.
     */
    public function salesDetailsIndex(Request $request): View
    {
        $reports = $this->reportRepository
            ->getSalesDetails($request)
            ->paginate(10);

        return view('admin.report.index', ['methodName' => 'salesDetails', 'reports' => $reports]);
    }

    /**
     *  Display a listing of the item wise sales.
     */
    public function itemWiseSalesIndex(Request $request): View
    {
        $reports = $this->reportRepository
            ->getItemWiseSales($request)->paginate(10);

        return view('admin.report.index', ['methodName' => 'itemWiseSales', 'reports' => $reports]);
    }

    /**
     *  generate PDF Report.
     */
    public function generatePDF(Request $request): Redirector
    {
        $result = $this->getExportData($request);

        if (! $result) {
            return redirect(route('dashboard'));
        }

        $pdf = PDF::loadView('admin.report.pdfComponent', ['headers' => $result['headers'], 'reports' => $result['reports']]);

        return $pdf->download('Report-'.Carbon::now().'.pdf');
    }

    /**
     *  generate csv Report.
     *
     * @return Redirector|BinaryFileResponse
     */
    public function exportCSV(Request $request)
    {
        $result = $this->getExportData($request);

        if (! $result) {
            return redirect(route('dashboard'));
        }

        return Excel::download(new ReportsExport($result['headers'], $result['reports']), 'Report-'.Carbon::now().'.csv');
    }

    private function getExportData(Request $request): ?array
    {
        $methodName = $request->query('methodName');

        switch ($methodName) {
            case 'dateWiseSales' :
                $headers = [
                    'date',
                    'total_order',
                    'total_amount',
                ];
                $reports = $this->reportRepository
                    ->getDataWiseSales($request)
                    ->get();
                break;
            case 'salesDetails' :
                $headers = [
                    'order_no',
                    'customer',
                    'area',
                    'branch',
                    'order_time',
                    'delivery_time',
                    'status',
                    'total',
                ];
                $reports = $this->reportRepository->getSalesDetails($request)->get();
                $data = [];
                foreach ($reports as $report) {
                    array_push($data, (object) [
                        'order_no' => $report->code,
                        'customer' => $report->user ? $report->user->getnameAttribute() : null,
                        'area' => $report->area ? $report->area->name : null,
                        'branch' => $report->branch ? $report->branch->name : null,
                        'order_time' => $report->created_at,
                        'delivery_time' => $report->delivery_date,
                        'status' => getStatusOrder($report->status),
                        'total' => $report->total_price,
                    ]);
                }
                $reports = collect($data);
                break;
            case 'itemWiseSales' :
                $headers = [
                    'item',
                    'total_order',
                    'total_amount',
                ];
                $reports = $this->reportRepository->getItemWiseSales($request)->get();
                break;
            default:
                return null;
        }

        return compact('headers', 'reports');
    }
}
