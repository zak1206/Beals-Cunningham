function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

var title = getUrlVars()["careertitle"];
var locations = getUrlVars()["careerlocation"];

$("#position").val(title);
$("#location").val(locations);

console.log(title);
console.log(locations);