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
 * Form for delete confirmation
 *
 * @package    tool_resetsettings
 * @copyright  2020 Ponlawat Weerapanpisit <ponlawat_w@outlook.co.th>, Adam Jenkins <adam@wisecat.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/formslib.php');

/**
 * Delete confirmation form
 */
class tool_resetsettings_deletesettingsconfirm_form extends moodleform {
    /**
     * @var \stdClass $setting a template record
     */
    private $setting;

    /**
     * Constructor
     *
     * @param \stdClass $setting a settings template record
     */
    public function __construct($setting) {
        $this->setting = $setting;
        parent::__construct();
    }

    /**
     * Form definition
     *
     * @return void
     */
    public function definition() {
        $mform = &$this->_form;

        $mform->addElement(
            'html',
            \core\output\html_writer::tag('p', get_string('deleteconfirmationtext', 'tool_resetsettings', $this->setting->name))
        );

        $mform->addElement('hidden', 'id', $this->setting->id);
        $mform->setType('id', PARAM_INT);

        $this->add_action_buttons(true, get_string('yes'));
    }
}
