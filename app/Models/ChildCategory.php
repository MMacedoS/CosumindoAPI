<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildCategory extends Model
{
    use HasFactory;

    protected $table = "child_categories";

    protected $fillable =
    [
        'name','subId', 'sub_category_id', 'picture', 'permalink', 'total_itens'
    ];

    public function insertChildren(array $dados, $id)
    {
        foreach($dados as $item)
        {
            $category = self::firstOrCreate(
                ['name' => $item->name,],
                [
                    'sub_category_id' => $id,
                    'subId' => $item->id
                ]
            );
        }
    }

    public function categories()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function subCategories()
    {
        return $this->hasMany(GrandChildrenCategory::class);
    }
}
