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


require_once($CFG->libdir . '/formslib.php');

class tool_resetsettings_newsettings_form extends moodleform {
    public function __construct() {
        parent::__construct(new moodle_url('/admin/tool/resetsettings/edit.php'));
    }

    private function gettemplates() {
        global $DB;

        $templates = [
            'blank' => get_string('blanktemplate', 'tool_resetsettings'),
            'default' => get_string('moodledefaulttemplate', 'tool_resetsettings'),
        ];

        $settings = $DB->get_records_sql('SELECT id, name FROM {tool_resetsettings_settings} ORDER BY name ASC');

        foreach ($settings as $setting) {
            $templates[$setting->id] = get_string('basedontemplate', 'tool_resetsettings', $setting->name);
        }
        return $templates;
    }

    public function definition() {
        $mform = &$this->_form;
        $mform->addElement('html', html_writer::tag('h2', get_string('newsettings', 'tool_resetsettings')));

        $mform->addElement('select', 'template', get_string('template', 'tool_resetsettings'), $this->gettemplates());
        $mform->setType('template', PARAM_TEXT);
        $mform->setDefault('template', 'blank');

        $mform->addElement('hidden', 'id', 0);
        $mform->setType('id', PARAM_INT);

        $this->add_action_buttons(false, get_string('continue'));
    }
}
