<?php
function isAdmin()
{
    if (isset($_SESSION['category']) && $_SESSION['category'] == 'admin') {
        return true;
    } else {
        return false;
    }
}