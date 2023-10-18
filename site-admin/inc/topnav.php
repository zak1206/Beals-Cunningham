<!-- Top Bar Start -->
<div class="topbar">

    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center">
            <a href="index.html" class="logo"><span><img style="max-width: 170px" src="img/caffeine_logo_back.png"></span></a>
        </div>
    </div>
    <div style="position: absolute; left: 0; padding: 0px 5px; top:0; background: #fff;"><img style="max-width: 60px;" src="img/cf_mob.png"> </div>
    <!-- Button mobile view to collapse sidebar menu -->
    <nav class="navbar-custom">

        <ul class="list-inline float-right mb-0">

            <li class="list-inline-item notification-list hide-phone">
                <a class="nav-link waves-light waves-effect" href="#" id="btn-fullscreen">
                    <i class="mdi mdi-crop-free noti-icon"></i>
                </a>
            </li>


            <li class="list-inline-item dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button"
                   aria-haspopup="false" aria-expanded="false" onclick="openMessline()">
                    <i class="mdi mdi-bell noti-icon"></i>

                    <span class="badge badge-pink noti-icon-badge messur">4</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg" aria-labelledby="Preview">
                    <!-- item-->
                    <div class="inssysmess">
                    <div class="jumbotron">No New Messages</div>
                    </div>

                    <!-- All-->
                    <div style="background: #efefef; padding: 10px; text-align: right">
                    <a style="display: inline-block; width:inherit" href="insystem-messages.php" class="btn btn-sm btn-primary">
                        View All
                    </a>

                    <button onclick="newMess()" style="display: inline-block; width:inherit" class="btn btn-sm btn-success">
                        New Message
                    </button>
                    </div>
                </div>
            </li>

            <li class="list-inline-item dropdown notification-list">
                <a style="font-size: 50px" class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                   aria-haspopup="false" aria-expanded="false">
                    <i class="mdi mdi-chevron-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="Preview">
                    <!-- item-->
                    <a href="system-settings.php" class="dropdown-item notify-item">
                        <i class="mdi mdi-settings"></i> <span>System Settings</span>
                    </a>


                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="mdi mdi-logout"></i> <span>Logout</span>
                    </a>

                </div>
            </li>

        </ul>

        <ul class="list-inline menu-left mb-0">
            <li class="float-left">
                <button class="button-menu-mobile open-left waves-light waves-effect">
                    <i class="mdi mdi-menu"></i>
                </button>
            </li>

        </ul>

    </nav>

</div>
<!-- Top Bar End -->

<div id="systnotes" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">In System Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="processInsys()">Submit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>

    $(function(){
        getNumbersUnread();
        openMessline();
    })

    function getNumbersUnread(){
        $.ajax({
            url: 'inc/asyncCalls.php?action=getmesscounts',
            success: function(data){
                $(".messur").html(data);
                setTimeout(function(){
                    getNumbersUnread();
                }, 5000);
            }
        })
    }

    function openMessline(){
        $.ajax({
            url: 'inc/asyncCalls.php?action=getsysmesss',
            success: function(data){
                $(".inssysmess").html(data);
            }
        })
    }

    function newMess(){
        $('#systnotes .modal-body').html('<form name="insysmesss" id="insysmesss" method="post" action=""><label>Subject</label><br><input class="form-control" name="insys_title" id="insys_title" value=""><br><label>Message</label><br><div id="editor"></div><input type="hidden" name="messys" id="messys" value=""><br><label>Priority</label><br><label style="display: inline-block;padding: 10px;background: #85ec85;"><input type="radio" name="priority" id="priority" value="Low" checked="checked"> Low</label><label style="display: inline-block;padding: 10px;background: #f3e68e;"><input type="radio" name="priority" id="priority" value="Medium"> Medium</label><label style="display: inline-block;padding: 10px;background: #f7aeae;"><input type="radio" name="priority" id="priority" value="High"> High</label></form>')
        var quill = new Quill('#editor', {
            theme: 'snow'
        });

        quill.on('editor-change', function(eventName, ...args) {
            if (eventName === 'text-change') {
                // args[0] will be delta
                var myEditor = document.querySelector('#editor')
                var html = myEditor.children[0].innerHTML;
                $("#messys").val(html)
            } else if (eventName === 'selection-change') {
                // args[0] will be old range
            }
        });
        $("#systnotes").modal();
    }

    function processInsys(){
        $("#insysmesss").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var url = 'inc/asyncCalls.php?action=processsysmess';

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {
                    $("#systnotes .modal-body").html('<div class="alert alert-success"><strong>AWESOME!</strong> - Your message has been sent to the people of earth.'+data+'</div>'); // show response from the php script.
                }
            });

        });

        $("#insysmesss").submit();
    }

    function openMessz(id){
        $.ajax({
            url: 'inc/asyncCalls.php?action=getmessz&messid='+id,
            success: function(data){
                $('#systnotes .modal-body').html(data);
                var quill = new Quill('#editor', {
                    theme: 'snow'
                });
                quill.on('editor-change', function(eventName, ...args) {
                    if (eventName === 'text-change') {
                        // args[0] will be delta
                        var myEditor = document.querySelector('#editor')
                        var html = myEditor.children[0].innerHTML;
                        $("#messys").val(html)
                    } else if (eventName === 'selection-change') {
                        // args[0] will be old range
                    }
                });
                $("#systnotes").modal();
            }
        })
    }
</script>