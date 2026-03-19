<?php
session_start();

// on vide la session et on detruit
session_unset();
session_destroy();

header("Location: /index.php");
exit();
