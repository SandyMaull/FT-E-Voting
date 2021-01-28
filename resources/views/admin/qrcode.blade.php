<!DOCTYPE html>
<html>
<head>
	<title>Whatsapp API by Kuronekosan</title>
</head>
<body>

	<div id="app">
		<h1>Whatsapp API</h1>
		<p>Powered by Kuronekosan</p>
		<img src="" alt="QR Code" id="qrcode">
		<h3>Logs:</h3>
		<ul class="logs"></ul>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" crossorigin="anonymous"></script>
	<script>
		$(document).ready(function() {
			var socket = io('http://evoting.ft.uts.ac.id:1380');

			socket.on('message', function(msg) {
				$('.logs').append($('<li>').text(msg));
			});

			socket.on('qr', function(src) {
				$('#qrcode').attr('src', src);
				$('#qrcode').show();
			});

			socket.on('ready', function(data) {
				$('#qrcode').hide();
			});

			socket.on('authenticated', function(data) {
				$('#qrcode').hide();
			});
		});
	</script>
</body>
</html>