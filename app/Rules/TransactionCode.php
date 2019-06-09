<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
Use App\Transaction;

class TransactionCode implements Rule
{
    public $transaction_type;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($transaction_type)
    {
        $this->transaction_type = $transaction_type;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->transaction_type == config('constants.transaction.type.sell')){
            if(Transaction::where('code', $value)->count() == 0){
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Create sell transaction for :attribute not exists is incapability';
    }
}
