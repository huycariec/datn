<?php

if (!function_exists('GenerateOrderNumber')) {
    function GenerateOrderNumber($id)
    {
        return 'MDH' . date('Y') . str_pad($id, 5, '0', STR_PAD_LEFT);
    }
}
