@extends('template.layout')
@section('content')
<div class="row mb-5 justify-content-center">
    <div class="col-md-3">
    </div>
    <div class="col-md-6">
        <div class="row mb-3">
            <div class="col-md-4">
                Detail Alamat
            </div>
            <div class="col-md-6">
                <textarea name="" class="form-control" id="" style="height: 100px" readonly>{{strtoupper($detail)}}, {{$village->name}}, {{$district->name}}, {{$city->name}}, {{$province->name}}</textarea>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                Link maps
            </div>
            <div class="col-md-6">
                <a href="https://www.google.com/maps/dir/Current+Location/{{$latitude}},{{$longitude}}">Klik untuk Detail Lokasinya</a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                Total Jasa
            </div>
            <div class="col-md-6">
                : Rp. {{ number_format($total_jasa, 2, ',', '.')}}
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-4">
                Total Jarak
            </div>
            <div class="col-md-6">
                <span id="total_jarak"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                Total
            </div>
            <div class="col-md-6">
                <span id="total"></span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
    </div>
</div>
<div id="map" style="width:100%;height:400px;"></div>
@endsection
@section('custom_js')
<script>
    let map;
    let markers = [
        { lat: <?= $latitude ?>, lng: <?= $longitude ?> },
        { lat: -7.559122, lng: 110.7776122 }
    ]
    $(document).ready(function(){
        myMap();
    })
    function myMap() {
        map = L.map('map').setView([110.7776122, -7.559122], 14);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        
        
        var latlngs = [
            [markers[0]['lat'], markers[0]['lng']],
            [markers[1]['lat'], markers[1]['lng']]
        ];
        marker = L.marker([markers[1]['lat'], markers[1]['lng']]).addTo(map);
        marker = L.marker([markers[0]['lat'], markers[0]['lng']]).addTo(map)
        .bindPopup("{{strtoupper($detail)}}, {{$village->name}}, {{$district->name}}, {{$city->name}}, {{$province->name}}")
        .openPopup();

        var polyline = L.polyline(latlngs, {color: 'red'}).addTo(map);
        map.fitBounds(polyline.getBounds());

        const getKilo = haversine_distance();
        const totalKilo = Math.round(getKilo) * 10000;
        const totalAll = totalKilo + parseInt(<?= $total_jasa ?>)
        $('#total_jarak').html(`: ${totalKilo}`);
        $('#total').html(`: ${totalAll.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}`);

    }

    function addMarker(prop) {
        let marker = new google.maps.Marker({
            position: prop,
            map: map
        })
    }

    function setPolyline(){
        const flightPath = new google.maps.Polyline({
            path: markers,
            geodesic: true,
            strokeColor: "#FF0000",
            strokeOpacity: 1.0,
            strokeWeight: 2,
        });

    }

    function haversine_distance() {
      var R = 6371; // Radius of the Earth in kilo
      var rlat1 = markers[0]['lat'] * (Math.PI/180); // Convert degrees to radians
      var rlat2 = markers[1]['lat'] * (Math.PI/180); // Convert degrees to radians
      var difflat = rlat2-rlat1; // Radian difference (latitudes)
      var difflon = (markers[1]['lng']- markers[0]['lng']) * (Math.PI/180); // Radian difference (longitudes)

      var d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat/2)*Math.sin(difflat/2)+Math.cos(rlat1)*Math.cos(rlat2)*Math.sin(difflon/2)*Math.sin(difflon/2)));
      console.log(d);
      return d;
    }
</script>

</body>
@endsection