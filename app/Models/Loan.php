<?php

namespace App\Models;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory;

    protected $guarded  = [];
    public $incrementing = false;  // You most probably want this too

    public function peminjam()
    {
        return $this->belongsTo(User::class, 'peminjam_id');
    }
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}
