<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan_DataModel extends Model
{
    use HasFactory;

    protected $table = 'pelanggan_data';
    protected $primaryKey = 'pelanggan_data_id';
    protected $fillable = [
        'pelanggan_data_pelanggan_id',
        'pelanggan_data_jenis',
        'pelanggan_data_file'
    ];


    public function get_pelanggan_data()
    {
        return self::all();
    }

    public function pelanggan()
    {
        return @this->belongsTo(PelangganModel::class,'pelanggan_data_pelanggan_id','pelanggan_id');
    }


    public function create_pelanggan_data($data)
    {
        return self::create($data);
    }


    public function update_pelanggan_data($data, $id)
    {
        $pelanggan_data = self::find($id);
        $pelanggan_data->fill($data);
        $pelanggan_data->update();
        return $pelanggan_data;
    }

    public function delete_pelanggan_data($id)
    {
        $pelanggan_data = self::find($id);
        self::destroy($id);
        return $pelanggan_data;
    }
}
