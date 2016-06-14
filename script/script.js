function CompressData() {
	$("#compress").submit(function(e){
    	var file_data = $('#uploadFile').prop('files')[0];
	    var form_data = new FormData();
	    form_data.append('uploadFile', file_data);
        $.ajax({
            type: 'POST',
            url: 'compress.php',
            data: form_data,
            processData: false,
				contentType: false,
            success: function(data) {
                // $('#response-msgs').html(data);
                var uploadedFileBlock = '<div class="uploaded-file-block"> <a href="'+data+'">'+file_data.name+'</a> </div>';
                $("#uploaded-files").append(uploadedFileBlock);
            }
        });
        e.preventDefault();
		});
}