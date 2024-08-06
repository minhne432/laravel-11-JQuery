<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'categories';

    // Các cột có thể được gán giá trị hàng loạt
    protected $fillable = [
        'name',
        'type',
    ];

    // Nếu bạn không muốn sử dụng timestamps, bỏ comment dòng dưới
    public $timestamps = false;
}
