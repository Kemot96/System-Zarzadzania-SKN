<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Club;
use App\Models\Order;
use App\Models\Report;
use Dompdf\Dompdf;
use Illuminate\Http\Request;

class SpendingPlanController extends Controller
{
    public function store(Request $request, Club $club, Report $report)
    {
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

    public function destroy(Club $club, Report $report, Order $order)
    {
        $order->delete();

        return back();
    }


    public function generate(Club $club, Report $report)
    {
        // use the dompdf class
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


}
