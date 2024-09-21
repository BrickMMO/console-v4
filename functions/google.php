<?php

function google_display_token($token)
{
    return str_repeat('*', strlen($token));
}