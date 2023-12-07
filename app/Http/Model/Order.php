<?php


namespace App\Http\Model;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    public $fillable = [
        'name',
        'name_type',
        'amount',
        'phone',
        'received_amount',
        'pay_img',
        'end_received_amount',
        'receipt_account',
        'twice_received_amount',
        'twice_img',
        'finance_check',
        'remark',
        'staff_name',
        "after_name",
        'edit_name',
        'status',
        'after_banlace',
        'wr_where',
        'want_name',
    ];

    protected $casts = [
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function classify()
    {
        return $this->hasOne(Classify::class, "id", "classify_local_id");
    }

}
