// function CompressData() {
// 	$("#upload-form").submit(function(e){
//     	var file_data = $('#uploadFile').prop('files')[0];
// 	    var form_data = new FormData();
// 	    form_data.append('uploadFile', file_data);
//         $.ajax({
//             type: 'POST',
//             url: 'compress.php',
//             data: form_data,
//             processData: false,
// 			contentType: false,
//             success: function(data) {
//                 //$('#response-msgs').html(data);
//                 $("#uploadFile").val('');
//                 var uploadedFileBlock = '<div class="uploaded-file-block"> <a download="'+file_data.name+'" href="'+data+'">'+file_data.name+'</a> </div>';
//                 $("#uploaded-files").append(uploadedFileBlock);
//             }
//         });
//         e.preventDefault();
// 	});
// }

$(document).ready(function() {

    var $form = $('.drop-box');
    var $input = $form.find( 'input[type="file"]' )

    // check whether drag and drop is supported by browser
    var isAdvancedUpload = function() {
        var div = document.createElement('div');
        return ('draggable' in div) || ('ondragstart' in div && 'ondrop in div') && 'FormData' in window && 'FileReader' in window;
    }();

    // setup drag and drop for modern browsers
    if (isAdvancedUpload) {
        $form.addClass('has-advanced-upload');

        var droppedFiles = false;

        $form.on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
        })
        .on('dragover dragenter', function() {
            $form.addClass('is-dragover');
        })
        .on('dragleave dragend drop', function() {
            $form.removeClass('is-dragover');
        })
        .on('drop', function(e) {
            droppedFiles = e.originalEvent.dataTransfer.files;
            $form.trigger('submit'); // automatic submission for modern
        });
    }

    // automatic submission for legacy
    $input.on('change', function(e) {
        $form.trigger('submit');
    })

    // ajax upload
    $form.on('submit', function(e) {
        if ($form.hasClass('is-uploading')) return false;

        $form.addClass('is-uploading').removeClass('is-error');

        if (isAdvancedUpload) {
            // ajax for modern
            e.preventDefault();

            var ajaxData = new FormData($form.get(0));

            if (droppedFiles) {
                $.each(droppedFiles, function(i, file) {
                    ajaxData.append($input.attr('name'), file);
                });
            }

            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                data: ajaxData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                complete: function(data) {
                    $form.removeClass('is-uploading');
                    console.log(data);
                },
                success: function(data) {
                    // $form.addClass(data.success == true ? 'is-success' : 'is-error');
                    // if (!data.success) $errorMsg.text(data.error);
                    // console.log(data.success);
                    // var uploadedFileBlock = '<div class="uploaded-file-block"> <a download="'+data.file_name+'" href="'+data.file_url+'">'+data.file_name+'</a> </div>';
                    // $("#uploaded-files").append(uploadedFileBlock);
                    $.each(data, function(i, theFile) {
                        var uploadedFileBlock = '<div class="uploaded-file-block"> <a download="'+theFile.file_name+'" href="'+theFile.file_url+'">'+theFile.file_name+'</a> </div>';
                        $("#uploaded-files").append(uploadedFileBlock);
                    });
                },
                error: function() {
                    console.log('error!');
                }
            });

        } else {
            // ajax for legacy
        }
    });

});