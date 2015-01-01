function keHasil(){
    var param_lat = document.getElementById('lt').value;
    var param_lng = document.getElementById('lg').value;
    console.log('Latitude : ' + param_lat + ' .Longitude : ' + param_lng);
    JSInterface.keHasil(param_lat, param_lng);
}

