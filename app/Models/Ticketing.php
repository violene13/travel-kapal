<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticketing extends Model
{
    use HasFactory;

    protected $table = 'ticketings';
    protected $primaryKey = 'id_ticketing';
    public $timestamps = true;

    protected $fillable = [
        'id_kapal',
        'id_jalur',
        'jenis_tiket',
        'kelas',
        'harga',
    ];

    /** Relasi ke kapal */
    public function kapal()
    {
        return $this->belongsTo(DataKapal::class, 'id_kapal', 'id_kapal');
    }

    /** Relasi ke jalur pelayaran */
    public function jalur()
    {
        return $this->belongsTo(JalurPelayaran::class, 'id_jalur', 'id_jalur');
    }
    
}
