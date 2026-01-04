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


require_once($CFG->dirroot . '/admin/tool/bulkreset/classes/resetsettings_form.php');

class tool_resetsettings_settings_form extends tool_bulkreset_resetsettings_form {
    private $id;

    public function __construct ($id, $setting = null) {
        $this->id = $id;

        parent::__construct(null, true);

        $formdata = null;
        if ($setting) {
            $formdata = json_decode($setting->data);
            $formdata->settingsname = $setting->name;
            $formdata->id = $setting->id;
            $this->set_data($formdata);
        }
    }

    public function definition() {
        $mform =& $this->_form;
        $mform->addElement('text', 'settingsname', get_string('settingsname', 'tool_resetsettings'));
        $mform->setType('settingsname', PARAM_TEXT);
        $mform->setDefault('settingsname', userdate(time(), get_string('strftimedatefullshort', 'langconfig')));
        $mform->addRule('settingsname', null, 'required');

        parent::definition();

        $mform->addElement('hidden', 'id', $this->id);
        $mform->setType('id', PARAM_INT);

        $this->add_action_buttons(true);
    }
}
