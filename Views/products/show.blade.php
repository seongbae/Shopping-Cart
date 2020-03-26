@extends(themePath('layouts.app'), ['banner'=>'none'])

@section('content')
<section class="page-section" id="about">
    <div class="container">
      <div class="row mb-5">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase"></h2>
        </div>
      </div>
     <div class="row wow fadeIn">

        <!--Grid column-->
        <div class="col-md-6 mb-4">

          <img src="{{ $product->image }}" class="img-fluid" alt="">

        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-md-6 mb-4">
          
          <!--Content-->
          <div class="p-4">
            {{$product->name}}
            <p class="lead">
              <span>${{$product->price}}</span>
            </p>

            <p class="lead font-weight-bold">Description</p>

            <p>{{$product->description}}</p>

            <form class="d-flex justify-content-left" action="/cart/add" method="POST">
              @csrf
              <input type="hidden" name="product_id" value="{{$product->id}}">
              <input type="number" name="quantity" value="1" aria-label="Search" class="form-control mr-3" style="width: 100px">
              <button class="btn btn-primary btn-md my-0 p waves-effect waves-light" type="submit">Add to cart
                <i class="fas fa-shopping-cart ml-1"></i>
              </button>

            </form>

          </div>
          <!--Content-->

        </div>
        <!--Grid column-->

      </div>
  </section>
  @stop