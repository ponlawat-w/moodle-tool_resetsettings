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
 * Reset Settings
 *
 * @package    tool_resetsettings
 * @copyright  2020 Ponlawat Weerapanpisit, Adam Jenkins <adam@wisecat.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


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
