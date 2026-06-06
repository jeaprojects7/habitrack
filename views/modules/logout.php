<?php
session_unset();
session_destroy();

echo '<script>
        localStorage.removeItem("habitrackTheme");
	    window.location = "dashboard";
     </script>';
