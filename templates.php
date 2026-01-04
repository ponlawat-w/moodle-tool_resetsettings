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
 * Reset setting template list page
 *
 * @package    tool_resetsettings
 * @copyright  2020 Ponlawat Weerapanpisit <ponlawat_w@outlook.co.th>, Adam Jenkins <adam@wisecat.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/classes/newsettings_form.php');

admin_externalpage_setup('resetsettings');

/** @var \moodle_page $PAGE */
$PAGE;
$PAGE->set_url(new \core\url('/admin/tool/resetsettings/edit.php', ['id' => $id]));
$PAGE->set_title(get_string('pluginname', 'tool_resetsettings'));
$PAGE->set_heading(get_string('pluginname', 'tool_resetsettings'));

/** @var \core\output\core_renderer $OUTPUT */
$OUTPUT;

echo $OUTPUT->header();
$table = tool_resetsettings_getsettingstable();
echo \core\output\html_writer::table($table);
echo \core\output\html_writer::start_tag('hr');
$newsettingsform = new tool_resetsettings_newsettings_form();
$newsettingsform->display();
echo $OUTPUT->footer();
