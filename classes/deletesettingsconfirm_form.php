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

class tool_resetsettings_deletesettingsconfirm_form extends moodleform {
    private $setting;

    public function __construct($setting) {
        $this->setting = $setting;
        parent::__construct();
    }

    public function definition() {
        $mform = &$this->_form;

        $mform->addElement('html',
            html_writer::tag('p', get_string('deleteconfirmationtext', 'tool_resetsettings', $this->setting->name)));

        $mform->addElement('hidden', 'id', $this->setting->id);
        $mform->setType('id', PARAM_INT);

        $this->add_action_buttons(true, get_string('yes'));
    }
}
