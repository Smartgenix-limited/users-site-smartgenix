function drawMap(locations) {
    let garage = locations.filter(
        (item) => item.latitude !== null && item.longitude !== null
    )[0];

    const myLatLng = {
        lat: Number(garage.latitude),
        lng: Number(garage.longitude),
    };
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 5,
        center: myLatLng,
    });

    // let locations = event.detail.garages;

    let infowindow = new google.maps.InfoWindow();

    let marker, i;

    for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(
                locations[i].latitude,
                locations[i].longitude
            ),
            map: map,
        });

        google.maps.event.addListener(
            marker,
            "click",
            (function (marker, i) {
                return function () {
                    infowindow.setContent(locations[i].name);
                    infowindow.open(map, marker);
                    // window.location.href = `garages/${locations[i].id}`;
                };
            })(marker, i)
        );
    }
}
