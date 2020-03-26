@extends(themePath('layouts.app'), ['banner'=>'none'])

@section('content')
<section class="page-section" id="about">
    <div class="container">
      <div class="row mb-5">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Catalog</h2>
        </div>
      </div>
     <div class="row">
        @foreach($products as $product)
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <a href="/catalog/{{$product->id}}"><img class="card-img-top" src="{{asset($product->image)}}" style="height: 225px; width: 100%; display: block;"></a>
                <div class="card-body">
                  <p class="card-text"><a href="/catalog/{{$product->id}}">{{$product->name}}</a></p>
                  <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">${{$product->price}}</small>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
    </div>
  </section>
  @stop