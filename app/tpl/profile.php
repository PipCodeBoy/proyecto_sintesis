<?php
    if($_SESSION['user']->rol == 1)
    {
      include 'admin-profile.php';
    }
    else
    {
      // die("ddd");
      include 'user-profile.php';
    }
