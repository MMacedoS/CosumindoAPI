<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Actions\MercadoDetailCatAction;

class DetailsCategoryController extends Controller
{
    public function __invoke($params, $id)
    {
        $params['id'] = $id;

        $mercadoDetailCatAction = new MercadoDetailCatAction;

        $categories = $mercadoDetailCatAction->execute($params);

        return $categories;
    }
}
