<?php

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once(__DIR__ . '/classes/deletesettingsconfirm_form.php');

admin_externalpage_setup('resetsettings');

$id = required_param('id', PARAM_INT);
$setting = $DB->get_record('tool_resetsettings_settings', ['id' => $id]);
if (!$setting) {
    throw new moodle_exception('Settings not found');
}

$deleteconfirmform = new tool_resetsettings_deletesettingsconfirm_form($setting);

if ($deleteconfirmform->is_submitted() && !$deleteconfirmform->is_cancelled()) {
    $DB->delete_records('tool_resetsettings_settings', ['id' => $id]);
}

if ($deleteconfirmform->is_submitted() || $deleteconfirmform->is_cancelled()) {
    redirect(new moodle_url('/admin/tool/resetsettings/index.php'));
    exit;
}

echo $OUTPUT->header();

echo html_writer::tag('h2', get_string('deleteconfirmation', 'tool_resetsettings'));
$deleteconfirmform->display();

echo $OUTPUT->footer();
