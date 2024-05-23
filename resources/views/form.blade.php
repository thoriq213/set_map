@extends('template.layout')
@section('content')
<form method="post" action="/transaction_detail">
@csrf
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Pilih Jasa</label>
    <div class="form-group">
        <input type="checkbox" class="form-check-input" id="" name="jasa[]" value="200000">
        <label class="form-check-label" for="exampleCheck1">Foto Nikah</label>
    </div>
    <div class="form-group">
        <input type="checkbox" class="form-check-input" id="" name="jasa[]" value="300000">
        <label class="form-check-label" for="exampleCheck1">Foto Preweed</label>
    </div>
    <div class="form-group">
        <input type="checkbox" class="form-check-input" id="" name="jasa[]" value="500000">
        <label class="form-check-label" for="exampleCheck1">Foto Event</label>
    </div>
    <input type="text" class="form-control" id="longitude" name="longitude" value="" hidden>
    <input type="text" class="form-control" id="latitude" name="latitude" value="" hidden>
  </div>
  <div id="submit" class="btn btn-primary">Submit</div>
</form>
@endsection
@section('custom_js')
    <script>
        $(document).ready(function(){
            getlocation();
            $('#submit').click(function(){
                const long = $('#longitude').val();
                const lat = $('#latitude').val();
                console.log(long, lat);

                if(long == '' && lat == '' && !long && !lat){
                    alert('silahkan refresh dan allow location');
                    getlocation();
                } else {
                    $('form').submit();
                }
            })
        }); 
        function getlocation() {
            navigator.geolocation.getCurrentPosition(showLoc);
        }
        function showLoc(pos) {
            $('#longitude').val(pos.coords.longitude);
            $('#latitude').val(pos.coords.latitude);
        }
    </script>
@endsection