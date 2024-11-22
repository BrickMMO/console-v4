<?php

function date_now($format = 'MYSQL')
{

    if($format == 'MYSQL') return date('Y-m-d H:i:s', time());

}