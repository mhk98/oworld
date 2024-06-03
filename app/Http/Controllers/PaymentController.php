namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SSLCOMMERZ;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        $payment = new Payment();
        $payment->tran_id = uniqid();
        $payment->amount = $request->amount;
        $payment->currency = 'BDT';
        $payment->status = 'Pending';
        $payment->save();

        $post_data = [
            'total_amount' => $payment->amount,
            'currency' => $payment->currency,
            'tran_id' => $payment->tran_id,
            'success_url' => route('payment.success'),
            'fail_url' => route('payment.fail'),
            'cancel_url' => route('payment.cancel'),
            'cus_name' => $request->name,
            'cus_email' => $request->email,
            'cus_add1' => $request->address,
            'cus_phone' => $request->phone,
        ];

        $sslc = new SSLCOMMERZ();
        $payment_options = $sslc->initiate($post_data, false);
        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = [];
        }

        return redirect()->to($payment_options['GatewayPageURL']);
    }

    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $payment = Payment::where('tran_id', $tran_id)->first();

        if ($payment) {
            $payment->status = 'Success';
            $payment->save();
        }

        return redirect()->route('payment.complete', ['status' => 'success']);
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $payment = Payment::where('tran_id', $tran_id)->first();

        if ($payment) {
            $payment->status = 'Failed';
            $payment->save();
        }

        return redirect()->route('payment.complete', ['status' => 'fail']);
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $payment = Payment::where('tran_id', $tran_id)->first();

        if ($payment) {
            $payment->status = 'Canceled';
            $payment->save();
        }

        return redirect()->route('payment.complete', ['status' => 'cancel']);
    }

    public function complete(Request $request)
    {
        $status = $request->input('status');
        return view('payment.complete', compact('status'));
    }
}
