<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Page for editing an existing settings template.
 *
 * @package    tool_resetsettings
 * @copyright  2020 Ponlawat Weerapanpisit <ponlawat_w@outlook.co.th>, Adam Jenkins <adam@wisecat.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/classes/settings_form.php');

admin_externalpage_setup('resetsettings');

$id = required_param('id', PARAM_INT);

/** @var \moodle_page $PAGE */
$PAGE;
$PAGE->set_url(new \core\url('/admin/tool/resetsettings/edit.php', ['id' => $id]));
$PAGE->set_title(get_string('template', 'tool_resetsettings'));
$PAGE->set_heading(get_string('template', 'tool_resetsettings'));

$template = optional_param('template', 'blank', PARAM_TEXT);

/** @var \moodle_db $DB */
$DB;

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
        throw new \core\exception\moodle_exception('Settings not found');
    }
}

$settingsform = new tool_resetsettings_settings_form($id, $setting);

if (!$settingsform->is_submitted()) {
    if ($template == 'default') {
        $settingsform->load_defaults();
    }
} else if ($settingsform->is_cancelled()) {
    redirect(new \core\url('/admin/tool/resetsettings/templates.php'));
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
    redirect(new \core\url('/admin/tool/resetsettings/templates.php'));
    exit;
}

/** @var \core\output\core_renderer $OUTPUT */
$OUTPUT;
echo $OUTPUT->header();
$settingsform->display();
echo $OUTPUT->footer();
