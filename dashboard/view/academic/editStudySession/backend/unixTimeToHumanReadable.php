<?php
/*It must be a server function instead of a javascript function to adjust
//to different timezones. We're always working on the server timezone to prevent
//mismatches. 
To work on the server timezone that operation must be done from the server*/
echo "" . date("d-m-Y H:i:s", $_GET["time"]);
?>