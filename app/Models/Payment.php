namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'payments';

    // Mass assignable attributes
    protected $fillable = [
        'tran_id',
        'amount',
        'currency',
        'status',
        'user_id'
    ];

    // Casts
    protected $casts = [
        'amount' => 'float'
    ];

    /**
     * Get the user that owns the payment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the payment is successful.
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->status === 'Success';
    }

    /**
     * Check if the payment has failed.
     *
     * @return bool
     */
    public function hasFailed()
    {
        return $this->status === 'Failed';
    }

    /**
     * Check if the payment is pending.
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->status === 'Pending';
    }
}
