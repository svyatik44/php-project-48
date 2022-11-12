<?php

namespace Format\Json;

function format(array $data): string
{
    return json_encode($data);
}
