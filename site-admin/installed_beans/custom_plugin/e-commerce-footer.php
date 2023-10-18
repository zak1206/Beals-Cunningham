</div>
</div>

<script>
  $(function() {
    initMobileMce();
    $(".img-browser").on('click', function() {
      var itemsbefor = $(this).data('setter');
      $("#myModalAS .modal-title").html('Select an Image For Link');
      $("#myModalAS .modal-body").html('<iframe id="themedia" style="width: 100%; height: 450px; border: none" src="../../media_manager.php?typeset=simple&returntarget=' + itemsbefor + '"></iframe>');
      $(".modal-dialog").css('width', '869px');
      $("#myModalAS").modal();
    })



  })

  function setImgDat(inputTarget, img, alttext) {
    var imgClean = img.replace("../../../../img/", "");
    $('#' + inputTarget).val(imgClean);
    imgSucc();
  }

  function imgSucc() {
    $("#myModalAS").modal('hide');
  }

  function initMobileMce() {
    tinymce.init({
      selector: ".summernotes",
      skin: "caffiene",
      plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
        "table contextmenu directionality emoticons paste textcolor codemirror"
      ],

      contextmenu: "link image | myitem",
      setup: function(editor) {
        editor.addMenuItem('myitem', {
          text: 'Open Content',
          onclick: function() {
            var beanName = editor.selection.getContent();


            $.ajax({
              url: 'inc/asyncCalls.php?action=minimod&beanid=' + beanName,
              success: function(data) {
                $("#myModal .modal-body").html(data);
                $("#myModal").modal();
                $(".modal-dialog").css('width', '70%');

              }
            })
          }
        });
      },
      file_browser_callback: function(field_name, url, type, win) {
        setplacer(field_name, url);

      },
      image_description: true,
      verify_html: false,
      toolbar1: "styleselect  bold italic underline alignleft aligncenter alignright alignjustify  bullist numlist outdent indent link unlink responsivefilemanager image media fontsizeselect forecolor backcolor code",
      menubar: false,
      image_advtab: true,
      height: '400',
      forced_root_block: false,
      image_dimensions: false,
      image_class_list: [{
          title: 'Responsive',
          value: 'img-responsive'
        },
        {
          title: 'Image 100% Width',
          value: 'img-full-width'
        }
      ],
      style_formats: [{
          width: 'Bold text',
          inline: 'strong'
        },
        {
          title: 'Red text',
          inline: 'span',
          styles: {
            color: '#ff0000'
          }
        },
        {
          title: 'Red header',
          block: 'h1',
          styles: {
            color: '#ff0000'
          }
        },
        {
          title: 'Badge',
          inline: 'span',
          styles: {
            display: 'inline-block',
            border: '1px solid #2276d2',
            'border-radius': '5px',
            padding: '2px 5px',
            margin: '0 2px',
            color: '#2276d2'
          }
        },
        {
          title: 'Table row 1',
          selector: 'tr',
          classes: 'tablerow1'
        }
      ],
      codemirror: {
        indentOnInit: true,
        path: 'codemirror-4.8',
        config: {
          lineNumbers: true,
          mode: "htmlmixed",
          autoCloseTags: true,

        }
      },
    });
  }

  function setplacer(ids, url) {
    var t = url;
    t = t.substr(0, t.lastIndexOf('/'));
    if (t != '') {
      var dir = '&directory=' + t
    } else {
      var dir = '';
    }


    $("#myModal .modal-body").html('<iframe src="../../media_manager.php?returntarget=' + ids + '" style="height:600px;width:100%; border: none"></iframe>')
    $("#myModal .modal-title").html('Media Browser');
    $("#myModal").modal();
    $("#myModal").css('z-index', '75541');
    $(".modal-dialog").css('width', '70%');
    $(".modal-backdrop").css('z-index', '70000');
    $('#themedias').contents().find('#mcefield').val('myValue');
  }

  function updateMcefld(mediapath, vals) {
    $("#" + vals).val(mediapath);
    $('#myModal').modal('hide');
    console.log(mediapath + ' - ' + vals);
  }

  function setImgDat(inputTarget, img, alttext) {
    var imgClean = img.replace("../../../../", "../../../");
    $('#' + inputTarget).val(imgClean);
    imgSucc();
  }

  function imgSucc() {
    alert('Image added. You can close media manager.');
  }

  $(function() {
    $(".thetoggle").on('click', function() {
      var theid = $(this).data('elmclos');
      var theStatus = $('#' + theid).val();
      if (theStatus == 'true') {
        $(this).removeClass('fa-toggle-on').addClass('fa-toggle-off');
        $('#' + theid).val('false');
      } else {
        $(this).removeClass('fa-toggle-off').addClass('fa-toggle-on');
        $('#' + theid).val('true');
      }
    })
  })
</script>
<script src="../../plugins/sweet-alert/sweetalert2.min.js"></script>
<script src="../../assets/pages/jquery.sweet-alert.init.js"></script>