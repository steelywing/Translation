<?php

// Save locale to cookie
if (!headers_sent()) {
    setcookie('locale', $locale, time() + 60*60*24*30, '/');
}

// Load locale from cookie
if (isset($_COOKIE['locale'])) {
    $locale = $_COOKIE['locale'];
}
