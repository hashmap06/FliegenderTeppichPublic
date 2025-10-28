<?php

$json_file = '../../JSON/WeeklyClicks.json';

$json_data = file_get_contents($json_file);

header('Content-Type: application/json');

echo $json_data;
