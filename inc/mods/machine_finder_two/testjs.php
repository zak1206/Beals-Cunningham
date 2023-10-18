<script>
    function contains(arr, key, val) {
        for (var i = 0; i < arr.length; i++) {
            if(arr[i][key] === val) return true;
        }
        return false;
    }
    var ars = '[{"category":"Articulated 4WD Tractors","manufacturer":"John Deere"},{"category":"Attachments for Lawn & Garden Tractors","manufacturer":"Other"},{"category":"Compact Utility Tractors","manufacturer":"John Deere"},{"category":"Lawn & Garden Tractors","manufacturer":"John Deere"},{"category":"Mowers for Lawn & Garden Tractors","manufacturer":"John Deere"},{"category":"Rototillers for Lawn & Garden Tractors","manufacturer":"John Deere"},{"category":"Row Crop Tractors","manufacturer":"John Deere"},{"category":"Snow Blowers for Lawn & Garden Tractors","manufacturer":"John Deere"},{"category":"Track Tractors","manufacturer":"John Deere"},{"category":"Utility Tractors","manufacturer":"John Deere"}]';

    ars = JSON.parse(ars);
    console.log(contains(ars, "category", "Attachments for Lawn & Garden Tractors"));
</script>