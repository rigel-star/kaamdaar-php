function getUserAddressByLatLon(ll)
{
    var request = new XMLHttpRequest();
    var address = "";
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var data = JSON.parse(request.responseText);
            let add = data.address;
            address = `${add.suburb}, ${add.road}, ${add.municipality}, ${add.city}, ${add.country}`;
        }
    };

    var url = `https://us1.locationiq.com/v1/reverse.php?key=pk.f0f26e342feac68b21745fb60341fda4&lat=${ll.latitude}&lon=${ll.longitude}&format=json`;
    request.open("GET", url, false);
    request.send();
    return address;
}

function timeSince(date) {
    var seconds = Math.floor((new Date() - date) / 1000);
    var interval = seconds / 31536000;

    if (interval > 1) 
        return Math.floor(interval) + " years";

    interval = seconds / 2592000;
    if (interval > 1)
        return Math.floor(interval) + " months";

    interval = seconds / 86400;
    if (interval > 1)
        return Math.floor(interval) + " days";

    interval = seconds / 3600;
    if (interval > 1)
        return Math.floor(interval) + " hours";

    interval = seconds / 60;
    if (interval > 1)
        return Math.floor(interval) + " minutes";

    return Math.floor(seconds) + " seconds";
}