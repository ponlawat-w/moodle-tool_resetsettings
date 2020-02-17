<?php

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/classes/settings_form.php');

admin_externalpage_setup('resetsettings');

$id = required_param('id', PARAM_INT);
$template = optional_param('template', 'blank', PARAM_TEXT);

$PAGE->set_context(context_system::instance());
$PAGE->set_url(new moodle_url('/admin/tool/resetsettings/edit.php', ['id' => $id]));

$setting = null;
$usecustomtemplate = is_numeric($template) && $template;
if ($id || $usecustomtemplate) {
    $settingid = $id ? $id : $template;
    $setting = $DB->get_record('tool_resetsettings_settings', ['id' => $settingid]);
    if ($usecustomtemplate) {
        $setting->id = 0;
        $setting->name = get_string('clonedsettingname', 'tool_resetsettings', $setting->name);
    }
    if (!$setting) {
        throw new moodle_exception('Settings not found');
    }
}

$settingsform = new tool_resetsettings_settings_form($id, $setting);

if (!$settingsform->is_submitted()) {
    if ($template == 'default') {
        $settingsform->load_defaults();
    }
} else if ($settingsform->is_cancelled()) {
    redirect(new moodle_url('/admin/tool/resetsettings/index.php'));
    exit;
} else if ($settingsform->is_validated()) {
    $data = $settingsform->get_data();
    $settingsname = $data->settingsname;
    unset($data->settingsname);
    unset($data->submitbutton);
    unset($data->id);
    $json = json_encode($data);
    if ($id) {
        $setting->name = $settingsname;
        $setting->data = $json;
        $DB->update_record('tool_resetsettings_settings', $setting);
    } else {
        $setting = new stdClass();
        $setting->id = 0;
        $setting->name = $settingsname;
        $setting->created_dt = time();
        $setting->data = $json;
        $DB->insert_record('tool_resetsettings_settings', $setting);
    }
    redirect(new moodle_url('/admin/tool/resetsettings/index.php'));
    exit;
}

echo $OUTPUT->header();

$settingsform->display();

echo $OUTPUT->footer();
