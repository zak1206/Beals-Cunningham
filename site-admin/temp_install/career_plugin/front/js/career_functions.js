function openJob(id){

    $.ajax({
        url: 'site-admin/installed_beans/career_plugin/async-data.php?action=readjob&id='+id,
        cache: false,
        success: function(data){
            $("#myModal .modal-body").html(data);
            $("#myModal .modal-title").html('Job Listing');
            $("#myModal").modal();
            $("#myModal .modal-dialog").css('width','70%');
        }
    })


}




