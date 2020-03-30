 <div class="card-body">
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="name"  name="name" value="{{ $product != null ? $product->name : null }}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Description</label>
    <div class="col-sm-10">
      <textarea name="description" class="form-control">{{ $product ? $product->description : null}}</textarea>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Price</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" name="price" id="price" min="0" step=".01" value="{{ $product ? $product->price : null}}">
    </div>
  </div>
  <div class="form-group row">
      <label for="photo_url" class="col-sm-2 col-form-label">Image</label>
      <div class="col-sm-10">
        @if ($product && $product->photo_url)
        <img src="{{ $product->photo_url }}" class="img-fluid mb-2" style="width:100px;">
        @endif
        <input type="file" class="form-control-file" id="photo_url" name="photo_url">
      </div>
  </div>
</div>
<!-- /.card-body -->
<div class="card-footer">
  <button type="submit" class="btn btn-info">Save</button>
  <a href="{{ URL::previous() }}" class="btn btn-dark mr-2">Cancel</a>
</div>