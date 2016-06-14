<?php

define( 'SITE_NAME', 'The Piper' );
define( 'SITE_TITLE', 'Image Compression' );
define( 'ABS_DIR', dirname(__FILE__) . '/' );
define( 'ABS_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/piper' );

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo SITE_NAME; ?></title>
	<link href='https://fonts.googleapis.com/css?family=Raleway|Open+Sans:400,300,400italic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/main.css">
	<script type="text/javascript" src="script/jquery-3.0.0.min.js"></script>

	<script type="text/javascript">

		function CompressData() {
			$("#compress").submit(function(e){
	        	var file_data = $('#uploadFile').prop('files')[0];   
			    var form_data = new FormData();                  
			    form_data.append('file', file_data); 
	            $.ajax({
	                type: 'POST',
	                url: 'compress.php',
	                data: form_data,
	                processData: false,
  					contentType: false,
	                success: function(data) {
	                    $('#response-msgs').html(data);
	                }
	            });
	            e.preventDefault();
	   		});
		}
	        
	</script>
</head>
<body>
	<div class="site-wrap">
		<header class="site-header">
			<div class="header-top">
				<div class="container">
					A Ghozt Labs Project
				</div>
			</div>
			<div class="container">
				<h2><?php echo SITE_TITLE; ?></h2>
			</div>
		</header>
		<div class="site-body">

			<div class="container">			
				<form action="compress.php" method="post" enctype="multipart/form-data" id="compress" onsubmit="" >
					<label for="uploadFile">Select a PNG file to upload:</label>
					<input type="file" name="uploadFile" id="uploadFile">
					<input type="submit" value="Upload" name="submit" onclick="CompressData()">
				</form>
			</div>
			<div class="response-msgs" id="response-msgs"></div>
		</div>
	</div>
</body>
</html>
