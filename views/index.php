<?php
if(isset($_SESSION['admin'])) {
} elseif(isset($_SESSION['safety'])){

}elseif(isset($_SESSION['responsible'])){

}
elseif(isset($_SESSION['reporter'])){

}
 else {
        header('location: ../log/login/');
    }



?>