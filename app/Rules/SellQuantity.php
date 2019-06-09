<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Transaction;

class SellQuantity implements Rule
{

    public $transaction_type;
    public $transaction_code;
    public $stock_available;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($transaction_type, $transaction_code)
    {
        $this->transaction_type = $transaction_type;
        $this->transaction_code = $transaction_code;
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
            $this->stock_available = Transaction::where('code', $this->transaction_code)->groupBy('code')->sum('available');
            if ($value > $this->stock_available  ) {
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
        return 'The :attribute is out of stock, available: ' . $this->stock_available ;
    }
}
