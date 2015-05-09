<?php
header('Content-Type: text/json');
header("Access-Control-Allow-Origin: *");
?>
<script>
    var JSONObject = {
        "purpose": "To bring people together for 1337ness"
    };
    document.getElementById("purpose").innerHTML = JSONObject.purpose;
</script>

<div id="purpose"></div>
