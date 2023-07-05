<?php

function memberCsvColumnIndexFromColumnName($columnName)
{
    $map = array(
        'Membership Type 2' => 36,
        'Membership Expiry Date' => 38,
        'Member since' => 39,
    );
    if (isset($map[$columnName])) {
        return $map[$columnName];
    } else {
        ~r(array_reverse(get_defined_vars()));
    }
}
