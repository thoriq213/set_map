@extends('template.layout')
@section('content')
<style>
    #map { 
        height: 500px; 
        }
</style>
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
    <h6 class="mt-5 mb-4">Detail Alamat</h6>
    <div class="form-group">
        <select class="form-select" name="province" id="province" aria-label="Default select example">
            <option value="" selected>Pilih Provinsi</option>
            @foreach ($provinces as $value)
                <option value="{{$value->id}}">{{$value->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group my-2">
        <select class="form-select" name="city" id="city" aria-label="Default select example">
            <option value="" selected>Pilih Kota</option>
        </select>
    </div>
    <div class="form-group my-2">
        <select class="form-select" name="district" id="district" aria-label="Default select example">
            <option value="" selected>Pilih Kecamatan</option>
        </select>
    </div>
    <div class="form-group my-2">
        <select class="form-select" name="village" id="village" aria-label="Default select example">
            <option value="" selected>Pilih Kelurahan</option>
        </select>
    </div>
    <div class="form-group my-2">
        <textarea class="form-control" placeholder="Detail Alamat" id="detail" name="detail" style="height: 100px"></textarea>
    </div>
  </div>
  <div class="form-group my-2">
    <label for="">pilih lokasi</label>
        <div class="map" id="map"></div>
  </div>
  <div id="submit" class="btn btn-primary">Submit</div>
</form>
@endsection
@section('custom_js')
    <script>
        let long = '';
        let lat = '';
        $(document).ready(function(){
            // getlocation();
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

            $('#province').change(function(){
                const province_id = $('#province').val();
                if(province_id !== ''){
                    $.ajax({
                        url: '/get_city',
                        type: 'POST',
                        dataType: 'json',
                        data: {province_id: province_id, "_token": "{{ csrf_token() }}"},
                        success: function(response) {
                            let str = '';
                            str += '<option value="" selected>Pilih Kota</option>'
                            response.forEach(element => {
                                str += `<option value="${element.id}">${element.name}</option>`
                            });
                            $('#city').html(str);
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                } else {
                    let str_city = '';
                    str_city += '<option value="" selected>Pilih Kota</option>';
                    let str_district = '';
                    str_district += '<option value="" selected>Pilih Kecamatan</option>';
                    let str_village = '';
                    str_village += '<option value="" selected>Pilih Kelurahan</option>';
                    $('#city').html(str_city);
                    $('#district').html(str_district);
                    $('#village').html(str_village);
                }
            })
            $('#city').change(function(){
                const city_id = $('#city').val();
                if(city_id !== ''){
                    $.ajax({
                        url: '/get_district',
                        type: 'POST',
                        dataType: 'json',
                        data: {city_id: city_id, "_token": "{{ csrf_token() }}"},
                        success: function(response) {
                            let str = '';
                            str += '<option value="" selected>Pilih Kecamatan</option>'
                            response.forEach(element => {
                                str += `<option value="${element.id}" data-latitude="${element.longitude}" data-longitude="${element.latitude}">${element.name}</option>`
                            });
                            $('#district').html(str);
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                } else {
                    let str_district = '';
                    str_district += '<option value="" selected>Pilih Kecamatan</option>';
                    let str_village = '';
                    str_village += '<option value="" selected>Pilih Kelurahan</option>';

                    $('#district').html(str_district);
                    $('#village').html(str_village);
                }
            })
            $('#district').change(function(){
                const district_id = $('#district').val();
                if(district_id !== ''){
                    $.ajax({
                        url: '/get_village',
                        type: 'POST',
                        dataType: 'json',
                        data: {district_id: district_id, "_token": "{{ csrf_token() }}"},
                        success: function(response) {
                            let str = '';
                            str += '<option value="" selected>Pilih Kelurahan</option>'
                            response.forEach(element => {
                                str += `<option value="${element.id}">${element.name}</option>`
                            });
                            $('#village').html(str);
                            long = $('#district option:selected').attr('data-longitude');
                            lat = $('#district option:selected').attr('data-latitude');
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                } else {
                    let str_village = '';
                    str_village += '<option value="" selected>Pilih Kelurahan</option>';

                    $('#village').html(str_village);
                }
            })
            $('#village').change(function(){
                showMap();
            })
        }); 
        function getlocation() {
            navigator.geolocation.getCurrentPosition(showLoc);
        }
        function showLoc(pos) {
            $('#longitude').val(pos.coords.longitude);
            $('#latitude').val(pos.coords.latitude);
        }
        let map = '';
        function showMap() {
            map = L.map('map').setView([long, lat], 14);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            // L.marker([long, lat]).addTo(map)
            // .bindPopup('A pretty CSS popup.<br> Easily customizable.')
            // .openPopup();
            let marker = '';
            map.on('click', function(e) {
                let longitude_value = $('#longitude').val();
                let latitude_value = $('#latitude').val();
                if(marker != ''){
                    map.removeLayer(marker);
                } 
                var latitude = e.latlng.lat;
                var longitude = e.latlng.lng;
                console.log(latitude, longitude);

                $('#longitude').val(longitude);
                $('#latitude').val(latitude);
    
                // Anda juga bisa menampilkan marker di tempat yang diklik
                marker = L.marker([latitude, longitude]).addTo(map);
                    // .bindPopup("Koordinat: " + latitude + ", " + longitude);
                //     .openPopup();
            });
        }

        function destroyMap() {
            if (map !== '') {
                map.remove();
                map = null;
                console.log('Map has been destroyed.');
            }
        }
    </script>
@endsection