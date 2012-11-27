if (typeof(Number.prototype.toRad) === "undefined") {
    Number.prototype.toRad = function() {
        return this * Math.PI / 180;
    }
}

if (typeof(Number.prototype.toDeg) === "undefined") {
    Number.prototype.toDeg = function() {
        return this * 180 / Math.PI;
    }
}

function haversine(lat1, lon1, lat2, lon2) {
    var R = 6371; // km
    var dLat = (lat2-lat1).toRad();
    var dLon = (lon2-lon1).toRad();
    var lat1 = lat1.toRad();
    var lat2 = lat2.toRad();
    
    var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
    var d = R * c;
    return d;
}

function bearing(lat1, lon1, lat2, lon2) {
    var lat1 = lat1.toRad();
    var lat2 = lat2.toRad();
    var dLon = (lon2-lon1).toRad();
    
    var y = Math.sin(dLon) * Math.cos(lat2);
    var x = Math.cos(lat1)*Math.sin(lat2) - Math.sin(lat1)*Math.cos(lat2)*Math.cos(dLon);
    var brng = Math.atan2(y, x).toDeg();
    
    return brng < 0 ? brng+360 : brng;
}

function formatDuration(timeValue) {
    var text = "";
    var hours = Math.floor(timeValue / 3600000);
    if (hours>0)
        text += hours + "h ";
    var minutes = Math.floor((timeValue-hours*3600000) / 60000);
    if (hours>0 || minutes>0)
        text += minutes + "min ";
    var seconds = Math.floor((timeValue-hours*3600000-minutes*60000) / 1000);
    text += seconds + "sec";
    return text;
}

function formatClock(dateObject) {
    var hours = dateObject.getHours();
    var minutes = dateObject.getMinutes();
    var seconds = dateObject.getSeconds();
    return (hours<10 ? "0":"") + hours.toString() + ":"
        + (minutes<10 ? "0":"") + minutes.toString() + ":"
        + (seconds<10 ? "0":"") + seconds.toString();
}

