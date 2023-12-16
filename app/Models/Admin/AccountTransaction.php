<?php

namespace App\Models\Admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountTransaction extends Model
{
	 use SoftDeletes;
     protected $guarded = ['id'];
    // relation with Account
    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

        /**
     * Creates new account transaction
     * @return obj
     */
    public static function createAccountTransaction($data)
    {
        $transaction_data = [
            'amount' => $data['amount'],
            'account_id' => !empty($data['account_id'])?$data['account_id']:null,
            'type' => $data['type'],
            'reff_no'=>$data['reff_no'],
            'sub_type' => !empty($data['sub_type']) ? $data['sub_type'] : null,
            'operation_date' => !empty($data['operation_date']) ? $data['operation_date'] : date('Y-m-d'),
            'transaction_id' => !empty($data['transaction_id']) ? $data['transaction_id'] : null,
            'transaction_payment_id' => !empty($data['transaction_payment_id']) ? $data['transaction_payment_id'] : null,
            'note' => !empty($data['note']) ? $data['note'] : null,
        ];

        $account_transaction = AccountTransaction::create($transaction_data);

        return $account_transaction;
    }

           /**
     * Updates transaction payment from transaction payment
     * @param  obj $transaction_payment
     * @param  array $inputs
     * @param  string $transaction_type
     * @return string
     */
    public static function updateAccountTransaction($transaction_payment, $transaction_type)
    {
        if (!empty($transaction_payment->account_id)) {
            $account_transaction = AccountTransaction::where(
                'transaction_payment_id',
                $transaction_payment->id
            )->first();
            if (!empty($account_transaction)) {
                $account_transaction->amount = $transaction_payment->amount;
                $account_transaction->account_id = $transaction_payment->account_id;
                $account_transaction->save();
                return $account_transaction;
            } else {
                $accnt_trans_data = [
                    'amount' => $transaction_payment->amount,
                    'account_id' => $transaction_payment->account_id,
                    'type' => self::getAccountTransactionType($transaction_type),
                    'operation_date' => $transaction_payment->operation_date,
                    'transaction_id' => $transaction_payment->transaction_id,
                    'transaction_payment_id' => $transaction_payment->id,
                    'sub_type'=>$transaction_type,
                    'reff_no'=>$transaction_payment->transaction?$transaction_payment->transaction->reference_no:rand(1,100000)
                ];

                self::createAccountTransaction($accnt_trans_data);
            }
        }
    }

        /**
     * Gives account transaction type from payment transaction type
     * @param  string $payment_transaction_type
     * @return string
     */
    public static function getAccountTransactionType($tansaction_type)
    {
        $account_transaction_types = [
            'Sale' => 'Debit',
            'Purchase' => 'Credit',
            'opening_balance'=>'Credit',
            'cus_opening' => 'Credit',
            'sup_opening' => 'Debit',
            'Expense' => 'Debit',
            'purchase_return' => 'Debit',
            'sale_return' => 'Credit'
        ];

        return $account_transaction_types[$tansaction_type];
    }
}
