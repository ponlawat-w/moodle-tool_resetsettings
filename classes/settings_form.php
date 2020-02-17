<?php

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
