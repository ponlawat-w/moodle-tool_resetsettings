<?php

defined('MOODLE_INTERNAL') || die();

$plugin->version = 2020021700;
$plugin->requires = 2019051100;
$plugin->component = 'tool_resetsettings';
$plugin->dependencies = [
  'tool_bulkreset' => 2020021600
];
