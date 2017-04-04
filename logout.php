<?php
//api for destroying session on logout
   session_start();
 
 

   session_destroy();
   	
     header("Location: index.php");
 

?>

</body>
</html>

