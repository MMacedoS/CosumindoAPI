<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfigApi;
use App\Actions\MercadoCategoryAction;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Models\SubCategory;
use App\Actions\MercadoDetailCatAction;
use App\Http\Controllers\DetailsCategoryController;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $data = Category::all();

        return view('categories.index', compact('data'));
    }
    public function store(Request $request)
    {
        $instructions = ConfigApi::whereNotNull('authorization')->get()->first();

        $params['client_id'] = $instructions->appId;
        $params['client_secret'] = $instructions->secretKey;
        $params['authorization'] = $instructions->authorization;
        $params['url'] = $instructions->url;
        $params['access_token'] = $instructions->token_json;

        $mercadoCategoryAction = new MercadoCategoryAction;

        $categories =  $mercadoCategoryAction->execute($params);

        DB::transaction(function () use ($categories, $params)
        {
            foreach($categories as $item)
            {
               $category = Category::updateOrCreate(
                    ['name' => $item->name],
                    ['catId' => $item->id],
                );

                $children = new DetailsCategoryController;
                $res = $children($params, $category->catId);
                $category->picture = $res->picture;
                $category->permalink = $res->permalink;
                $category->total_itens = $res->total_items_in_this_category;
                $category->save();

                SubCategory::insertChildren($res->children_categories, $category->id);

            }
        });
        return redirect()->route('categorias.index');
    }

    public function childrens(Request $request)
    {
        $data = Category::with('subCategories')->where('catId',$request->id)->get()->first();
        // dd($data);
        return view('categories.details', compact('data'));

    }
}
