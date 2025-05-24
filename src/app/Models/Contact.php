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
            $rowInput = $keyword;
            $noSpaceInput = str_replace([' ', '　'], '', $rowInput);
            $query->where(function ($subQuery) use ($rowInput, $noSpaceInput) {
                $subQuery->where('last_name', 'like', '%' . $rowInput . '%')
                    ->orWhere('first_name', 'like', '%' . $rowInput . '%')
                    ->orWhere('email', 'like', '%' . $rowInput . '%')
                    ->orWhereRaw("REPLACE(REPLACE(CONCAT(last_name, first_name), ' ', ''), '　', '') LIKE ?", ['%' . $noSpaceInput . '%'])
                    ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ['%' . $rowInput . '%'])
                    ->orWhereRaw("CONCAT(last_name, '　', first_name) LIKE ?", ['%' . $rowInput . '%']);
            });
        }
        return $query;
    }
    public function scopeGenderSearch($query, $gender)
    {
        if (!empty($gender) && $gender !== 'all') {
            return $query->where('gender', $gender);
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
