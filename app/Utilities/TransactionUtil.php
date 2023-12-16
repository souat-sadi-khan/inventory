<?php
namespace App\Utilities;

use App\Models\Admin\AccountTransaction;
use App\Models\Products\Product;
use App\Purchase;
use App\Transaction;
use App\TransactionPayment;
use App\TransactionSellLine;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionUtil
{

  public function createSellPurcahaseTransaction($input,$user_id,$ref_no,$invoice_no=null){

  	$transaction = Transaction::create([
  	  'customer_id'=>!empty($input['customer_id'])?$input['customer_id']:null,
      'supplier_id'=>!empty($input['supplier_id'])?$input['supplier_id']:null,
  		'date'=>$input['date'],
  		'type'=>$input['type'],
        'invoice_no'=>$invoice_no,
  		'reference_no'=>$ref_no,
  		'transaction_type'=>$input['transaction_type'],
        'sale_type'=>!empty($input['sale_type'])?$input['sale_type']:null,
  		'sub_total'=>$input['sub_total'],
  		'discount'=>$input['discount'],
  		'discount_type'=>$input['discount_type'],
  		'discount_amount'=>$input['discount_amount'],
  		'tax'=>$input['tax'],
  		'shipping_charges'=>$input['shipping_charges'],
  		'net_total'=>$input['net_total'],
  		'paid'=>$input['paid'],
  		'due'=>$input['due'],
  		'stuff_note'=>$input['stuff_note'],
  		'transaction_note'=>$input['transaction_note'],
  		'created_by'=>$user_id,

  	]);

  	return $transaction;
  }

  public function createSellLines($transaction,$variations)
  {
  	foreach ($variations as $variation) {
  		$create_sale_line = TransactionSellLine::create([
  			'transaction_id'=>$transaction->id,
  			'customer_id'=>$transaction->customer_id,
  			'product_id'=>$variation['product_id'],
  			'quantity'=>$variation['quantity'],
  			'unit_price'=>$variation['unit_price'],
  			'cost_price'=>$variation['cost_price'],
  			'total'=>$variation['unit_price']*$variation['quantity'],
  			'created_by'=>$transaction->created_by,
  		]);
  	}
  	return true;
  }

    public function createPurchaseLines($transaction,$variations)
  {
    foreach ($variations as $variation) {
      $create_sale_line = Purchase::create([
        'transaction_id'=>$transaction->id,
        'supplier_id'=>$transaction->supplier_id,
        'product_id'=>$variation['product_id'],
        'qty'=>$variation['qty'],
        'price'=>$variation['purchase_price'],
        'line_total'=>$variation['line_total'],
        'created_by'=>$transaction->created_by,
      ]);

      $product=Product::find($variation['product_id']);
      $product->product_cost =$variation['purchase_price'];
      $product->product_price =$variation['product_price'];
      $product->save();
    }
    return true;
  }


     /**
     * Creates a new opening balance transaction for a contact
     *
     * @param  int $business_id
     * @param  int $contact_id
     * @param  int $amount
     *
     * @return void
     */
    public function createOpeningBalanceTransaction($customer,$supplier, $amount,$type=null,$trans_type=null)
    {


        $ym = Carbon::now()->format('Y/m');

        $row = Transaction::where('transaction_type', $trans_type)->withTrashed()->get()->count() > 0 ? Transaction::where('transaction_type', $trans_type)->withTrashed()->get()->count() + 1 : 1;

        $ref_no = $ym.'/'.$trans_type.'-'.ref($row);

        $transaction = Transaction::create([
            'customer_id'=>$customer,
            'supplier_id'=>$supplier,
            'date'=>date('Y-m-d'),
            'type'=>$type,
            'payment_status' => 'due',
            'reference_no'=>$ref_no,
            'transaction_type'=>$trans_type,
            'net_total'=>$amount,
            'due'=>$amount,
            'created_by'=>auth()->user()->id,
        ]);

         return true;
    }


    public function getTotalAmountPaid($transaction_id)
    {
        $paid = TransactionPayment::where(
            'transaction_id',
            $transaction_id
        )->sum('amount');
        return $paid;
    }


     public function decreaseProductQuantity($product_id, $new_quantity, $old_quantity = 0)
    {
        $qty_difference = $new_quantity - $old_quantity;
            Product::where('id', $product_id)
                ->decrement('stock', $qty_difference);

        return true;
    }


    public function IncreaseVariationQty($product_id, $new_quantity, $old_quantity = 0)

    {
        $product = Product::find($product_id);

        //Check if stock is enabled or not.
            //Decrement Quantity in variations location table
         $qty_difference = $new_quantity + $old_quantity;
            Product::where('id', $product_id)
                ->increment('stock', $qty_difference);

        return true;
    }

    public function setReference($transaction_type)
    {
        $ym = Carbon::now()->format('Y/m');

        $row = Transaction::where('transaction_type', $transaction_type)->withTrashed()->get()->count() > 0 ? Transaction::where('transaction_type', $transaction_type)->withTrashed()->get()->count() + 1 : 1;
        if ($transaction_type=='Sale') {
          $seq ='/S-';
        }
        elseif ($transaction_type=='sale_return') {
          $seq ='/SR-';
        }
        elseif ($transaction_type=='Purchase') {
          $seq ='/P-';
        }
         elseif ($transaction_type=='purchase_return') {
          $seq ='/PR-';
        }
        elseif ($transaction_type=='opening_balance') {
          $seq ='/Open-';
        }
         $ref_no = $ym.$seq.ref($row);
         return $ref_no;
    }


        /**
     * Update the payment status for purchase or sell transactions. Returns
     * the status
     *
     * @param int $transaction_id
     *
     * @return string
     */
    public function updatePaymentStatus($transaction_id, $final_amount = null)
    {
        $status = $this->calculatePaymentStatus($transaction_id, $final_amount);
        Transaction::where('id', $transaction_id)
            ->update(['payment_status' => $status]);

        return $status;
    }

    /**
     * Calculates the payment status and returns back.
     *
     * @param int $transaction_id
     * @param float $final_amount = null
     *
     * @return string
     */
    public function calculatePaymentStatus($transaction_id, $final_amount = null)
    {
        $total_paid = $this->getTotalPaid($transaction_id);

        if (is_null($final_amount)) {
            $final_amount = Transaction::find($transaction_id)->net_total;
        }

        $status = 'due';
        if ($final_amount <= $total_paid) {
            $status = 'paid';
        } elseif ($total_paid > 0 && $final_amount > $total_paid) {
            $status = 'partial';
        }

        return $status;
    }

    /**
     * Get total paid amount for a transaction
     *
     * @param int $transaction_id
     *
     * @return int
     */
    public function getTotalPaid($transaction_id)
    {
        $total_paid = TransactionPayment::where('transaction_id', $transaction_id)
                ->select(DB::raw('SUM(IF( is_return = 0, amount, amount*-1))as total_paid'))
                ->first()
                ->total_paid;

        return $total_paid;
    }


       /**
     * Pay contact due at once
     *
     * @param obj $parent_payment, string $type
     *
     * @return void
     */
    public function SupplierPayAtOnce($parent_payment, $type)
    {
        //Get all unpaid transaction for the contact
        $types = ['opening_balance', $type];

        if ($type == 'purchase_return') {
            $types = [$type];
        }

        $due_transactions = Transaction::where('supplier_id', $parent_payment->supplier_id)
                                ->whereIn('transaction_type', $types)
                                ->where('payment_status', '!=', 'paid')
                                ->orderBy('date', 'asc')
                                ->get();
        $total_amount = $parent_payment->amount;
        $tranaction_payments = [];
        if ($due_transactions->count()) {
            foreach ($due_transactions as $transaction) {
                if ($total_amount > 0) {
                    $total_paid = $this->getTotalPaid($transaction->id);
                    $due = $transaction->net_total - $total_paid;

                    $now = Carbon::now()->toDateTimeString();

                    $array = [
                            'transaction_id' => $transaction->id,
                            'method' => $parent_payment->method,
                            'transaction_no' => $parent_payment->transaction_no,
                            // 'type' => $parent_payment->type,
                            'payment_date' => $parent_payment->payment_date,
                            'created_by' => $parent_payment->created_by,
                            'supplier_id' => $parent_payment->supplier_id,
                            'parent_id' => $parent_payment->id,
                            'payment_ref_no'=>random_num('Payment'),
                            'created_at' => $now,
                            'updated_at' => $now
                        ];

                        if ($transaction->transaction_type=='purchase_return') {
                            $array['type'] = 'Credit';
                        }else{
                            $array['type'] = 'Debit';
                        }

                    if ($due <= $total_amount) {
                        $array['amount'] = $due;
                        $tranaction_payments[] = $array;

                        //Update transaction status to paid
                        $transaction->paid =$transaction->paid+$due;
                        $transaction->due =$transaction->due-$due;
                        $transaction->payment_status = 'paid';
                        $transaction->save();

                        $total_amount = $total_amount - $due;
                    } else {
                        $array['amount'] = $total_amount;
                        $tranaction_payments[] = $array;

                        //Update transaction status to partial
                        $transaction->paid =$transaction->paid+$due;
                        $transaction->due =$transaction->due-$due;
                        $transaction->payment_status = 'partial';
                        $transaction->save();
                        break;
                    }
                }
            }

            //Insert new transaction payments
            if (!empty($tranaction_payments)) {
                TransactionPayment::insert($tranaction_payments);
            }
        }
    }




       /**
     * Pay contact due at once
     *
     * @param obj $parent_payment, string $type
     *
     * @return void
     */
    public function CustomerPayAtOnce($parent_payment, $type)
    {
        //Get all unpaid transaction for the contact
        $types = ['cus_opening', $type];

        if ($type == 'sale_return') {
            $types = [$type];
        }

        $due_transactions = Transaction::where('customer_id', $parent_payment->customer_id)
                                ->whereIn('transaction_type', $types)
                                ->where('payment_status', '!=', 'paid')
                                ->orderBy('date', 'asc')
                                ->get();
        $total_amount = $parent_payment->amount;
        $tranaction_payments = [];
        if ($due_transactions->count()) {
            foreach ($due_transactions as $transaction) {
                if ($total_amount > 0) {
                    $total_paid = $this->getTotalPaid($transaction->id);
                    $due = $transaction->net_total - $total_paid;

                    $now = Carbon::now()->toDateTimeString();

                    $array = [
                            'transaction_id' => $transaction->id,
                            'method' => $parent_payment->method,
                            'transaction_no' => $parent_payment->transaction_no,
                            // 'type' => $parent_payment->type,
                            'payment_date' => $parent_payment->payment_date,
                            'created_by' => $parent_payment->created_by,
                            'customer_id' => $parent_payment->customer_id,
                            'parent_id' => $parent_payment->id,
                            'account_id' => $parent_payment->account_id,
                            'payment_ref_no'=>random_num('Payment'),
                            'created_at' => $now,
                            'updated_at' => $now
                        ];

                        if ($transaction->transaction_type=='sale_return') {
                            $array['type'] = 'Debit';
                        }else{
                            $array['type'] = 'Credit';
                        }

                    if ($due <= $total_amount) {
                        $array['amount'] = $due;
                        $tranaction_payments[] = $array;

                        //Update transaction status to paid
                        $transaction->paid =$transaction->paid+$due;
                        $transaction->due =$transaction->due-$due;
                        $transaction->payment_status = 'paid';
                        $transaction->save();

                        $total_amount = $total_amount - $due;
                    } else {
                        $array['amount'] = $total_amount;
                        $tranaction_payments[] = $array;

                        //Update transaction status to partial
                        $transaction->paid =$transaction->paid+$due;
                        $transaction->due =$transaction->due-$due;
                        $transaction->payment_status = 'partial';
                        $transaction->save();
                        break;
                    }
                }
            }

            //Insert new transaction payments
            if (!empty($tranaction_payments)) {
               TransactionPayment::insert($tranaction_payments);

            }
        }
    }

        /**
     * Checks if products has manage stock enabled then Updates quantity for product and its
     * variations
     *
     * @param $location_id
     * @param $product_id
     * @param $variation_id
     * @param $new_quantity
     * @param $old_quantity = 0
     * @param $number_format = null
     * @param $uf_data = true, if false it will accept numbers in database format
     *
     * @return boolean
     */
    public function updateProductQuantity( $product_id, $new_quantity, $old_quantity = 0, $number_format = null, $uf_data = true)
    {

        $qty_difference = $new_quantity - $old_quantity;
        $product = Product::find($product_id);

        //Check if stock is enabled or not.
        if ($qty_difference != 0) {


            $product->stock += $qty_difference;
            $product->save();

            //TODO: Add quantity in products table
            // Product::where('id', $product_id)
            //     ->increment('total_qty_available', $qty_difference);
        }

        return true;
    }


    /**
     * Check if return exist for a particular purchase or sell
     * @param id $transacion_id
     *
     * @return boolean
     */
    public function isReturnExist($transacion_id)
    {
        return Transaction::where('return_parent_id', $transacion_id)->exists();
    }



}
