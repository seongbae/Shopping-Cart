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
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-4">
          <div class="card">
            <a href="{{ route('products.show', $product)}}"><img class="card-img-top" src="{{asset($product->image)}}"></a>
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

  @push('styles')
<style>
   .card-img-top {
     height: 180px;
     width:100%;
    object-fit: contain;
  } 
</style>
  @endpush