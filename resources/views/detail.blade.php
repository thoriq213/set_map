@extends('template.layout')
@section('content')
<div class="row mb-5 justify-content-center">
    <div class="col-md-3">
    </div>
    <div class="col-md-6">
        <div class="row mb-3">
            <div class="col-md-4">
                Total Jasa
            </div>
            <div class="col-md-6">
                : {{$total_jasa}}
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
<div id="googleMap" style="width:100%;height:400px;"></div>
@endsection
@section('custom_js')
<script>
    let map;
    let markers = [
        { lat: <?= $latitude ?>, lng: <?= $longitude ?> },
        { lat: -7.559122, lng: 110.7776122 }
    ]
    $(document).ready(function(){
        // myMap();
    })
    function myMap() {
        var mapProp= {
        center:new google.maps.LatLng(<?= $latitude ?>,<?= $longitude ?>),
        zoom:7,
        };
        map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
        for (let i = 0; i< markers.length; i++) {
            addMarker(markers[i])
        }
        // setPolyline();
        const getKilo = haversine_distance();
        const totalKilo = Math.round(getKilo) * 10000;
        const totalAll = totalKilo + parseInt(<?= $total_jasa ?>)
        $('#total_jarak').html(`: ${totalKilo}`);
        $('#total').html(`: ${totalAll}`);

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

<script src="https://maps.googleapis.com/maps/api/js?key=API_KEY&callback=myMap"></script>

</body>
@endsection