<?php

if (!function_exists('GenerateOrderNumber')) {
    function GenerateOrderNumber($id)
    {
        return 'MDH' . str_pad($id, 10, '0', STR_PAD_LEFT);
    }
}
