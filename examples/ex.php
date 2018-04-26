<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

<title>Plupload - jQuery UI Widget</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/south-street/jquery-ui.min.css">
<link rel="stylesheet" href="../js/jquery.ui.plupload/css/jquery.ui.plupload.css" type="text/css" />

<!-- debug 
<script type="text/javascript" src="../../js/moxie.js"></script>
<script type="text/javascript" src="../../js/plupload.dev.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.plupload/jquery.ui.plupload.js"></script>
-->

</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>jQuery UI Widget</h1>
			<p>You can see this example with different themes on the <a href="http://plupload.com/example_jquery_ui.php">www.plupload.com</a> website.</p>
			<label>Company</label>
			<input type="text" id="company" name="company">
			<form id="form" method="post" action="../dump.php">
				<div id="uploader">
					<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
				</div>
				<br />
				<button type="submit" />Submit</button>
			</form>
		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.9.2/jquery-ui.min.js"></script>
<!-- production -->
<script type="text/javascript" src="../js/plupload.full.min.js"></script>
<script type="text/javascript" src="../js/jquery.ui.plupload/jquery.ui.plupload.js"></script>
<script type="text/javascript">
	// Initialize the widget when the DOM is ready
	$(function() {
		var uploadInitialized = false;
		function validateForm() {
			if( $('#company').val() == "" ){
				alert("กรอกข้อมูล");
				return false;
			}
			else{
				return true;
			}
		}

		$("#uploader").plupload({
			// General settings
			runtimes : 'html5,flash,silverlight,html4',
			url : 'upload.php',

			// User can upload no more then 20 files in one go (sets multiple_queues to false)
			max_file_count: 20,
			
			chunk_size: '10mb',
			
			filters : {
				// Maximum file size
				max_file_size : '1000mb',
				// Specify what files to browse for
				mime_types: [
					{title : "Image files", extensions : "jpg,gif,png"},
					{title : "Zip files", extensions : "zip"}
				]
			},

			// Rename files by clicking on their titles
			rename: true,
			
			// Sort files
			sortable: true,

			// Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
			dragdrop: true,

			// Views to activate
			views: {
				list: true,
				thumbs: true, // Show thumbs
				active: 'thumbs'
			},

			// Flash settings
			flash_swf_url : '../../js/Moxie.swf',

			// Silverlight settings
			silverlight_xap_url : '../../js/Moxie.xap',

			init : {
				StateChanged: function(up) {
					console.log(up.state ,plupload.STARTED)
					if (up.state == plupload.STARTED && !validateForm()) {
						up.stop();
					}

					// up.stop();
				},
				FilesAdded: function(up, files) {
						// console.log(up, files)               
				},
				UploadComplete: function(up, files) {
					// console.log(up, files)  
					//  $.each(files, function(i, file) {
					//     // alert(file);
					//     console.log(i, file)  
					// }); 
					// up.refresh();  
					// location.reload();
					up.splice();   
					$('input').val('');                 
				}
			}
		});

		// Handle the case when form was submitted before uploading has finished
		$('#form').submit(function(e) {
			// Files in queue upload them first
			if ($('#uploader').plupload('getFiles').length > 0) {

				// When all files are uploaded submit form
				$('#uploader').on('complete', function() {
					$('#form')[0].submit();
				});

				$('#uploader').plupload('start');
			} else {
				alert("You must have at least one file in the queue.");
			}
			return false; // Keep the form from submitting
		});
	});
</script>

</body>
</html>
