<?php
function startSN($result)
{
    return ($result->currentPage() * $result->perPage()) - $result->perPage() + 1;
}