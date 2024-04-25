<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewaan_DetailModel extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'penyewaan_detail';
    protected $primaryKey = 'penyewaan_detail_id';
    protected $fillable = [
            'penyewaan_detail_penyewaan_id',
            'penyewaan_detail_alat_id',
            'penyewaan_detail_jumlah',
            'penyewaan_detail_subharga',
    ];
    public function get_penyewaan_detail()
    {
        return self::all();
    }

    public function penyewaan()
    {
        return $this->belongsTo(penyewaanModel::class, 'penyewaan_detail_penyewaan_id', 'penyewaan_id');
    }

    public function alat()
    {
        return $this->belongsTo(alatModel::class, 'penyewaan_detail_alat_id', 'alat_id');
    }


    public function create_penyewaan_detail($data)
    {
        return self::create($data);
    }

    public function update_penyewaan_detail($data, $id)
    {
        $penyewaan_detail = self::find($id);
        $penyewaan_detail->fill($data);
        $penyewaan_detail->update();
        return $penyewaan_detail;
    }

    public function delete_penyewaan_detail($id)
    {
        $penyewaan_detail = self::find($id);
        self::destroy($id);
        return $penyewaan_detail;
    }
}