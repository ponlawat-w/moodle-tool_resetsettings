<?php

require_once($CFG->libdir . '/formslib.php');

class tool_resetsettings_newsettings_form extends moodleform {
    public function __construct() {
        parent::__construct(new moodle_url('/admin/tool/resetsettings/edit.php'));
    }

    private function gettemplates() {
        global $DB;

        $templates = [
            'blank' => get_string('blanktemplate', 'tool_resetsettings'),
            'default' => get_string('moodledefaulttemplate', 'tool_resetsettings')
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
