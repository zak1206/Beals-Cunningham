function getMylatlong(){
    var locationzip = $("#locationzip").val();
    // console.log(locationzip);
    if(locationzip != null){
        $.ajax({
            url: 'inc/getClose.php?act=getzipbase&zip='+locationzip,
            // dataType: "json",
            success: function(data){
               console.log(data);
               $("#location-finder").html(data);
            }
        })
    }else{
        alert('Enter Zip Code');
    }
}
