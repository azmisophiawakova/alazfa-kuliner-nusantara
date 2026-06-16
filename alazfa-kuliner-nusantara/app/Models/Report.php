<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //
    protected $primaryKey = 'id_report';
    protected $fillable = ['id_user', 'jenis_laporan', 'id_referensi', 'alasan', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
