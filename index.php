<?php

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/classes/newsettings_form.php');

admin_externalpage_setup('resetsettings');

echo $OUTPUT->header();

$table = tool_resetsettings_getsettingstable();
echo html_writer::table($table);

echo html_writer::start_tag('hr');

$newsettingsform = new tool_resetsettings_newsettings_form();
$newsettingsform->display();

echo $OUTPUT->footer();
