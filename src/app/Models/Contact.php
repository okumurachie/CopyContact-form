<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'last_name',
        'first_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function scopeCategorySearch($query, $category_id)
    {
        if (!empty($category_id)) {
            return $query->where('category_id', $category_id);
        }
        return $query;
    }
    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            return $query->where(function ($q) use ($keyword) {
                $q->where('last_name', 'like', "%{$keyword}%")
                    ->orWhere('first_name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }
        return $query;
    }
    public function scopeGenderSearch($query, $gender)
    {
        if (!empty($gender) && $gender !== 'all') {
            $genderMap = ['1' => '男性', '2' => '女性', '3' => 'その他'];
            $selectedGender = $genderMap[$gender] ?? null;
            if ($selectedGender) {
                return $query->where('gender', $selectedGender);
            }
        }
        return $query;
    }
    public function scopeDateSearch($query, $date)
    {
        if (!empty($date)) {
            return $query->whereDate('created_at', $date);
        }
        return $query;
    }
}
