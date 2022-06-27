$(document).ready(function(){
    if($('.editor').length)
        {
            $('.editor').summernote({
                height:150,
                tabsize: 2,
                lineHeight:1.5,
                dialogsInBody: true,
                dialogsFade: false,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript','fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph','style']],
                    ['height', ['height']],
                    ['insert',['picture','link','video','table','hr']],
                    ['misc',['codeview','undo','redo']]
                ],
                callbacks : {
                    onImageUpload: function(image) {

                        uploadImage(image[0],$(this));

                    }
                }

            }).on('summernote.change', function (we, contents, $editable) {
                $(this).val(contents);
            });
        }
    function uploadImage(image,$summernote)
        {
            var dat = new FormData();
            dat.append("image",image);
            var IMAGE_PATH = 'https://alert.boxraft.net/uploads';
            $.ajax ({
                data: dat,
                type: "POST",
                url:  'https://alert.boxraft.net/image_upload',
                headers: {"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr('content')},
                cache: false,
                contentType: false,
                processData: false,
                success: function(url) {
                    var image = IMAGE_PATH+$.trim(url);
                    $summernote.summernote("insertImage", image,function ($image) {
                        $image.attr('class', 'image-fluid');
                    });
                },
                error: function(e) {
                    toastr.error(e, 'upload', {
                        timeOut: 1000,
                        closeButton: true,
                        progressBar: true,
                        newestOnTop: true

                    });
                }
            });
        }
    $(document).on('submit','.create-form',function(e){
        e.preventDefault();
        var frm = $(this);
        $.ajax({
            type:'POST',
            url:frm.attr('action'),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:$(this).serialize(),
            success:function(Mess){
                if(Mess.status === true)
                    {

                        toastr.success( Mess.msg,Mess.header, {timeOut: 1000, closeButton:true, progressBar:true, newestOnTop:true, onHidden: function () {

                                window.location= Mess.url;
                            }});


                    }
                else
                    {
                        toastr.error( Mess.msg,Mess.header, {timeOut: 1000, closeButton:true, progressBar:true, newestOnTop:true, onHidden: function () {

                                window.location= Mess.url;
                            }});
                    }
            },
            error:function (xhr, status, errorThrown) {

                toastr.error(errorThrown, xhr.responseText, {timeOut: 1000, closeButton:true, progressBar:true, newestOnTop:true,onHidden: function () {
                        window.location.reload();
                    }});



            }
        });

    });

});
document.addEventListener("DOMContentLoaded", function(event) {
    // Select2
    $('.select2').each(function() {
        $(this)
            .wrap('<div class="position-relative"></div>')
            .select2({
                placeholder: 'Select value',
                dropdownParent: $(this).parent()
            });
    })
    // Daterangepicker
    $('input[name="daterange"]').daterangepicker({
        opens: 'left'
    });
    $('input[name="datetimes"]').daterangepicker({
        timePicker: true,
        opens: 'left',
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
            format: 'M/DD hh:mm A'
        }
    });
    $('input[name="datesingle"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true
    });
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);
    cb(start, end);
});
