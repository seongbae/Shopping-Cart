 <div class="card-body">
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputEmail3"  name="name" value="{{ $product != null ? $product->name : null }}">
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
      <input type="number" class="form-control" name="price" id="inputPassword3" value="{{ $product ? $product->price : null}}">
    </div>
  </div>
</div>
<!-- /.card-body -->
<div class="card-footer">
  <button type="submit" class="btn btn-info">Save</button>
  <a href="{{ URL::previous() }}" class="btn btn-dark mr-2">Cancel</a>
</div>