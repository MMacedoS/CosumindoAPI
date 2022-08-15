<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\ConfigApi;
use App\Http\Controllers\DetailsCategoryController;
use App\Actions\MercadoDetailCatAction;


class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $data = SubCategory::with('subCategories')->where('subId',$request->id)->get()->first();
         if(count($data->subCategories) == 0)
            $this->sincroniza($request, $data);
            $data = SubCategory::with('subCategories')->where('subId',$request->id)->get()->first();

        return view('categories.details_child', compact('data'));
    }

    public function sincroniza($request, $category)
    {
        $instructions = ConfigApi::whereNotNull('authorization')->get()->first();

        $params['client_id'] = $instructions->appId;
        $params['client_secret'] = $instructions->secretKey;
        $params['authorization'] = $instructions->authorization;
        $params['url'] = $instructions->url;
        $params['access_token'] = $instructions->token_json;

        $children = new DetailsCategoryController;
        $res = $children($params, $request->id);

                $category->picture = $res->picture;
                $category->permalink = $res->permalink;
                $category->total_itens = $res->total_items_in_this_category;
                $category->save();

                ChildCategory::insertChildren($res->children_categories, $category->id);
    }
}
