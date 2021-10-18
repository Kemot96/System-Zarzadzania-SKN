<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Club;
use App\Models\Order;
use App\Models\Report;
use App\Models\TypeOfReport;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Html;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SpendingPlanController extends Controller
{
    public function store(Request $request, Club $club, Report $report)
    {
        $this->validateOrder();

        Order::create([
            'reports_id' => $report->id,
            'name' => $request['name'],
            'description' => $request['description'],
            'type' => $request['type'],
            'quantity' => $request['quantity'],
            'gross' => $request['gross'],
            'term' => $request['term'],
        ]);

        return back();
    }

    public function edit(Club $club, Report $report)
    {
        $send_reports_ids = Attachment::pluck('reports_id')->all();

        if (in_array($report->id, $send_reports_ids))
        {
            $attachments_send = TRUE;
        }
        else{
            $attachments_send = FALSE;
        }

        return view('editSpendingPlan', compact('club', 'report', 'attachments_send'));
    }

    public function update(Request $request, Club $club, Report $report, Order $order)
    {
        $this->validateOrder();

        $order->update(array(
            'reports_id' => $report->id,
            'name' => $request['name'],
            'description' => $request['description'],
            'type' => $request['type'],
            'quantity' => $request['quantity'],
            'gross' => $request['gross'],
            'term' => $request['term'],
        ));

        return back();
    }

    public function menu(Club $club)
    {
        $spending_plans = Report::where('clubs_id', $club->id)->where('academic_years_id', '!=', getCurrentAcademicYear()->id)->where('types_id', TypeOfReport::getSpendingPlanID())->orderBy('academic_years_id', 'desc')->get();

        $spending_plan = Report::where('clubs_id', $club->id)->where('academic_years_id', getCurrentAcademicYear()->id)->where('types_id', TypeOfReport::getSpendingPlanID())->first();

        return view('clubSpendingPlans', compact('club', 'spending_plans', 'spending_plan'));
    }

    public function show(Club $club, Report $report)
    {
        $send_reports_ids = Attachment::pluck('reports_id')->all();

        if (in_array($report->id, $send_reports_ids))
        {
            $attachments_send = TRUE;
        }
        else{
            $attachments_send = FALSE;
        }

        return view('spendingPlansArchive', compact('club', 'report', 'attachments_send'));
    }

    public function destroy(Club $club, Report $report, Order $order)
    {
        $order->delete();

        return back();
    }


    public function generatePDF(Club $club, Report $report)
    {
        $content = view('templates.spendingPlan', compact('club', 'report')) -> render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($content);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $dompdf->stream();
    }

    public function generateExcel(Club $club, Report $report)
    {
        $content = view('templates.spendingPlan', compact('club', 'report')) -> render();

        $reader = new Html();
        $spreadsheet = $reader->loadFromString($content);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $spreadsheet->getActiveSheet()->getStyle('A1:G1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('ffffff');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="file.xls"');
        $writer->save("php://output");
    }

    protected function validateOrder()
    {
        return request()->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'type' => 'nullable|string',
            'quantity' => 'nullable|string',
            'gross' => 'nullable|numeric',
            'term' => 'nullable|string',
        ]);
    }
}
