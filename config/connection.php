<?php

return [
    'total_limit' => (int) env('CONNECTION_TOTAL_LIMIT', 3),
    'frequency_limit' => (int) env('CONNECTION_FREQUENCY_LIMIT', 7)
];