<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfigApi;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Actions\MercadoTokenAction;

class configApiController extends Controller
{
   public function index(Request $request)
   {

    $data = ConfigApi::all();
     return view('config.index', compact('data'));
   }

   public function create()
   {
        return view('config.create');
   }

   public function store(Request $request)
   {
        $this->validate($request, $this->rules($request));

        DB::transaction(function () use ($request){
           ConfigApi::create($request->all());
        });

        return redirect()->route('config.index');
   }

   public function show($id)
   {

   }

   public function edit(Request $request, $id)
   {
        $item = ConfigApi::findOrFail($id);
        return view('config.edit', compact('item'));
   }

   public function update(Request $request, $id)
   {
        $item = ConfigApi::findOrFail($id);

        Validator::make(
            $request->all(),
            $this->rules($request,$item->getKey())
        )->validate();

        DB::transaction( function() use ($request, $item)
            {
                $inputs =  $request->all();
                $item->fill($inputs)->save();

            }
        );
        return redirect()->route('config.index');
   }

   public function destroy($id)
   {

    $item = ConfigApi::findOrFail($id);

    DB::beginTransaction();

        try {

            $item->delete();

            DB::commit();

            return redirect()->route('config.index')->withStatus('registro deletado!');

        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('config.index')->withError('Registro não deletado');
        }
   }

   private function rules(Request $request, $primaryKey = null, bool $changeMessages = false)
   {
        $rules = [
            'appId' => 'required|string',
            'secretKey' => 'required|string',
            'url' => 'required|string',
            'siteId' => 'required|string'
        ];
        $messages = [];

        return !$changeMessages ? $rules : $messages;
    }

    public function authorization(Request $request)
    {
        $instructions = ConfigApi::findOrFail($request->id);
        $appid = $instructions->appId;
        $redirect_uri = $instructions->url;
        $state = $this->generateReference();
        $instructions->state = $state;
        $instructions->save();

        // dd('https://auth.mercadolivre.com.br/authorization?response_type=code&client_id='.$appid.'&redirect_uri='.$redirect_uri.'&state='.$this->generateReference());
        return redirect('https://auth.mercadolivre.com.br/authorization?response_type=code&client_id='.$appid.'&redirect_uri='.$redirect_uri.'&state='.$state);
    }

    private function generateReference($qtyCaraceters = 4)
    {
        //Números aleatórios
        $numbers = (((date('Ymd') / 12) * 24) + mt_rand(800, 9999));
        $numbers .= 1234567890;

        //Junta tudo
        $characters = $numbers;

        //Embaralha e pega apenas a quantidade de caracteres informada no parâmetro
        $reference = substr(str_shuffle($characters), 0, $qtyCaraceters);

        //Retorna a referenca
        return $reference;
    }

    public function tokenKey(Request $request)
    {

        DB::transaction( function () use ($request) {
            $item =  ConfigApi::where('state', $request->state)->first();
            $item->authorization = $request->code;

            $params['client_id'] = $item->appId;
            $params['client_secret'] = $item->secretKey;
            $params['authorization'] = $request->code;
            $params['url'] = $item->url;

            $mercadoTokenAction = new MercadoTokenAction;

            $token =  $mercadoTokenAction->execute($params);
            $item->token_json = $token;

            $item->save();

        });
        return redirect()->route('config.index')->withStatus('registro autorizado!');
    }
}
