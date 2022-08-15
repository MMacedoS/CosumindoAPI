<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrandChildrenCategory extends Model
{
    use HasFactory;

    protected $table = "grandchildren_categories";

    protected $fillable =
    [
        'name','subId', 'child_category_id', 'picture', 'permalink', 'total_itens'
    ];

    public function insertChildren(array $dados, $id)
    {
        foreach($dados as $item)
        {
            self::firstOrCreate(
                ['name' => $item->name,],
                [
                    'child_category_id' => $id,
                    'subId' => $item->id
                ]
            );

        }
    }

    public function child_categories()
    {
        return $this->belongsTo(ChildCategory::class);
    }
}
