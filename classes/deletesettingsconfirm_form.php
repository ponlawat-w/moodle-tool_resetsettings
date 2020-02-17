<?php

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
