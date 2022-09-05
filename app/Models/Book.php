<?php

namespace App\Models;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $guarded  = ['id'];
    protected $primaryKey = 'kode';
    public $incrementing = false; 
    protected $keyType = 'string';


    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
