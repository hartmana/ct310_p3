<?php 
header("Access-Control-Allow-Origin: *"); 
header('Content-Type: text/json');
?>
<script>
var JSONObject = {
	purpose : "To bring people together for 1337ness"
	};
document.getElementById("purpose").innerHTML=JSONObject.purpose;
</script>
