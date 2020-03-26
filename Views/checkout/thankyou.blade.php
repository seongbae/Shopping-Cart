@extends(themePath('layouts.app'), ['banner'=>'none'])

@section('content')
<section class="bg-light page-section" id="portfolio">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          @if(flash()->message)
            <div class="alert {{ flash()->class }}">
                {{ flash()->message }}
            </div>
        @endif
        </div>
      </div>
    </div>
  </section>
@stop