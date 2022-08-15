<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $table = "sub_categories";

    protected $fillable = [
        'name','subId', 'category_id', 'picture', 'permalink', 'total_itens'
    ];

    public function insertChildren(array $dados, $id)
    {
        foreach($dados as $item)
        {
            self::firstOrCreate(
                ['name' => $item->name,],
                [
                    'category_id' => $id,
                    'subId' => $item->id
                ]
            );
        }
    }

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategories()
    {
        return $this->hasMany(ChildCategory::class);
    }
}
