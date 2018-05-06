<?
namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceCreateRequest;
use App\Invoice;
use App\Store;
use App\Plan;
use App\Http\Helpers;
use Auth;
use App\Http\TFPDF\TFPDF;

class InvoiceController extends Controller
{

	public function index()
	{
		$invoices = Auth()->user()->invoices;
		return view('manager.invoice.index', compact('invoices'));
	}




	public function show($id)
	{
		$invoice = Invoice::findOrFail($id);		
		if( Auth::user()->can('manageInvoice', $invoice) ) :
			return view('manager.invoice.show', compact('invoice'));
		endif;

		return abort('403');
	}



	public function store(InvoiceCreateRequest $request)
	{
		$store = Store::findOrFail($request->store_id);
        $plan = Plan::findOrFail($request->plan_id);	
        $hasInvoice = Helpers::hasInvoice($store);	

		if( Auth::user()->can('manageStore', $store) ) :
			if( !$hasInvoice ) :
		        $bill_to = [
		            'user_id' => Auth::user()->id,
		            'first_name' => Auth::user()->first_name,
		            'last_name' => Auth::user()->last_name,
		            'street' => $request->street,
		            'city' => $request->city,
		            'province' => $request->province,
		            'zip' => $request->zip,
		            'phone' => $request->phone
		        ];
		        $invoice_data = [
		            'store' => $store,
		            'plan' => $plan,
		        ];
		        $invoice = new Invoice();
		        $invoice->user_id = Auth::user()->id;
		        $invoice->store_id = $store->id;
		        $invoice->bill_to = json_encode($bill_to);
		        $invoice->pay_to = 'Cloudstore Philippines';
		        $invoice->items = json_encode($invoice_data);
		        $invoice->amount = $plan->price;
		        $invoice->due_at = date('Y-m-d h:i:s');
		        $invoice->save();

		        if( $request->update_address ) :
		            Auth::user()->street = $request->street;
		            Auth::user()->city = $request->city;
		            Auth::user()->province = $request->province;
		            Auth::user()->zip = $request->zip;
		            Auth::user()->phone = $request->phone;
		            Auth::user()->save();
		        endif;
	        endif;
			return redirect(route('manager.invoice.show', $invoice->id));
		endif;

		return abort('403');
	}



	public function download($id)
	{
		$invoice = Invoice::findOrFail($id);

		if( Auth::user()->can('manageInvoice', $invoice) ) :
			$amount_due = number_format($invoice->items->plan->price - $invoice->transactions->sum('amount'), 2);
			$pdf = new TFPDF();
			$pdf->SetTopMargin('25');
			$pdf->AddPage();
			$pdf->AddFont('Roboto','','Roboto-Regular.ttf',true);
			$pdf->AddFont('Roboto','B','Roboto-Bold.ttf',true);

			$pdf->Image(url('').'/logo.png',11,11,35,0,'PNG', url(''));

			$pdf->SetFont('Roboto','B',12);
			$pdf->Cell(0, 5, 'Invoice #'.$invoice->id);

			$pdf->SetFont('Roboto','',8);
			$pdf->Cell(0, 5, 'Amount due', 0, 1, 'R');

			$pdf->SetFont('Roboto','',8);
			$pdf->Cell(0, 4, 'Invoice date: '.$invoice->created_at);
			$pdf->SetFont('Roboto','B',12);
			$pdf->Cell(0, 4, '₱'.$amount_due, 0, 1, 'R');


			$pdf->SetFont('Roboto','',8);
			$pdf->Cell(0, 4, 'Due date: '.$invoice->due_at, 0, 1);

			$pdf->Ln();
			$pdf->SetFont('Roboto','B',10);
			$pdf->Cell(0, 5, 'Bill To', 0, 1);
			$pdf->SetFont('Roboto','',8);
			$pdf->Cell(0, 4, $invoice->bill_to->first_name.' '.$invoice->bill_to->last_name, 0, 1);
			$pdf->Cell(0, 4, $invoice->bill_to->street.', '.$invoice->bill_to->city, 0, 1);
			$pdf->Cell(0, 4, $invoice->bill_to->province.' '.$invoice->bill_to->zip, 0, 1);
			$pdf->Cell(0, 4, $invoice->bill_to->phone, 0, 1);


			$pdf->Ln();
			$pdf->SetFont('Roboto','B',10);
			$pdf->Cell(0, 5, 'Pay To', 0, 1);
			$pdf->SetFont('Roboto','',8);
			$pdf->Cell(0, 4, 'Cloudstore Ecommerce Solutions', 0, 1);
			$pdf->Cell(0, 4, 'Lipa City, Batangas 4217', 0, 1);

			$pdf->Ln();
			$pdf->SetFont('Roboto','B',9);
			$pdf->Cell(0, 10, '   Description', 1);
			$pdf->Cell(0, 10, 'Amount   ', 1, 1, 'R');
			$pdf->SetFont('Roboto','',8);
			$pdf->Cell(0, 10, '   '.$invoice->items->store->name.' - '.$invoice->items->plan->plan, 1);
			$pdf->Cell(0, 10, '₱'.number_format($invoice->items->plan->price, 2).'   ', 1, 1, 'R');

			$pdf->Cell(100, 10, '', 'B L', 0, 'R');
			$pdf->Cell(0, 10, 'Subtotal', 'B', 0);
			$pdf->Cell(0, 10, '₱'.number_format($invoice->items->plan->price, 2).'   ', 1, 1, 'R') ;

			$pdf->SetFont('Roboto','B',9);
			$pdf->Cell(100, 10, '', 'B L', 0, 'R');
			$pdf->Cell(0, 10, 'Total', 'B', 0);
			$pdf->Cell(0, 10, '₱'.number_format($invoice->items->plan->price, 2).'   ', 1, 1, 'R') ;


			$pdf->Ln();
			$pdf->SetFont('Roboto','',10);
			$pdf->Cell(0, 3, 'Transactions', 0, 1);

			$pdf->Ln();
			$pdf->SetFont('Roboto','B',9);
			$pdf->Cell(40, 10, '   Date', 'L T B');
			$pdf->Cell(50, 10, 'Gateway', 'T B');
			$pdf->Cell(60, 10, 'Transaction ID', 'T B');
			$pdf->Cell(0, 10, 'Amount   ', 'R T B', 1, 'R');

			$pdf->SetFont('Roboto', '',8);
			if(count($invoice->transactions) > 0) :
				foreach($invoice->transactions as $transaction) :
					$pdf->Cell(40, 10, '   '.$transaction->created_at, 'L T B');
					$pdf->Cell(50, 10, $transaction->mode, 'T B');
					$pdf->Cell(60, 10, $transaction->mode_transaction, 'T B');
					$pdf->Cell(0, 10, '₱'.number_format($transaction->amount, 2).'   ', 'R T B', 1, 'R');
				endforeach;
				$pdf->Cell(130, 10, '', 'B L', 0, 'R');
				$pdf->Cell(0, 10, 'Total', 'B', 0);
				$pdf->SetFont('Roboto', 'B',8);
				$pdf->Cell(0, 10, '₱'.number_format($invoice->transactions->sum('amount'), 2).'   ', 1, 1, 'R') ;
			else :
				$pdf->Cell(0, 10, 'No transactions', 1, 1, 'C');
			endif;

			$pdf->SetFont('Roboto','B',9);
			$pdf->Cell(130, 10, '', 'B L', 0, 'R');
			$pdf->Cell(0, 10, 'Balance', 'B', 0);
			$pdf->Cell(0, 10, '₱'.number_format($invoice->items->plan->price - $invoice->transactions->sum('amount'), 2).'   ', 1, 1, 'R') ;

			if( $invoice->notes ) :
				
				$pdf->SetFont('Roboto','B',8);
				$pdf->Cell(0, 10, 'Notes: ');
				$pdf->Ln();
				$pdf->SetFont('Roboto','',8);
				$pdf->Cell(0, -2, $invoice->notes);
			endif;
			
			$pdf->Output('Invoice #'.$invoice->id.'.pdf', 'D');
			//$pdf->Output('D');
		endif;
	}
}