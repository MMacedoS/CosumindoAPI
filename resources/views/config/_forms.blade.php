
<div class="row">
    <div class="col-md-4">
        {!!Form::text('appId','APPID')->required()!!}
    </div>
    <div class="col-md-8">
        {!!Form::text('secretKey','SecretKey')->required()!!}
    </div>
    <div class="col-md-12">
        {!!Form::text('url','Url internea')->required()->value("http://localhost:8080")->type('url')!!}
    </div>
    <div class="col-md-12">
        {!!Form::text('siteId','Id do Site')->value("mlb")->required()!!}
    </div>

</div>
<div class="row">
    <div class="col-12">
        <button type="submit" class="btn btn-success float-right mt-4">Salvar</button>
    </div>
</div>

