<?php

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    $ADMIN->add('courses', new admin_externalpage('resetsettings', get_string('resetsettings', 'tool_resetsettings'),
        "{$CFG->wwwroot}/{$CFG->admin}/tool/resetsettings/index.php"));
}
