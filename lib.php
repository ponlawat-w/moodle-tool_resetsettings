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


function tool_resetsettings_createactions($setting) {
    global $CFG;
    $links = [
        html_writer::link(
            "{$CFG->wwwroot}/{$CFG->admin}/tool/resetsettings/edit.php?id={$setting->id}",
            get_string('edit'),
            ['class' => 'text-primary']
        ),
        html_writer::link(
            "{$CFG->wwwroot}/{$CFG->admin}/tool/resetsettings/edit.php?id=0&template={$setting->id}",
            get_string('copy', 'tool_resetsettings'),
            ['class' => 'text-success']
        ),
        html_writer::link(
            "{$CFG->wwwroot}/{$CFG->admin}/tool/resetsettings/delete.php?id={$setting->id}",
            get_string('delete'),
            ['class' => 'text-danger']
        ),
    ];
    return implode(' ', $links);
}

function tool_resetsettings_getsettingstable($sortby = 'name ASC') {
    global $DB;
    $settings = $DB->get_records_sql(
        'SELECT id, name, created_dt FROM {tool_resetsettings_settings} ORDER BY ' . $sortby
    );
    $table = new html_table();
    $table->head = [
        get_string('settingsname', 'tool_resetsettings'),
        get_string('createddt', 'tool_resetsettings'),
        get_string('actions', 'tool_resetsettings'),
    ];
    $table->data = [];
    foreach ($settings as $setting) {
        $table->data[] = [
            $setting->name,
            userdate($setting->created_dt),
            tool_resetsettings_createactions($setting),
        ];
    }
    if (!count($settings)) {
        $col = new html_table_cell(get_string('nosettings', 'tool_resetsettings'));
        $col->colspan = 3;
        $table->data[] = [$col];
    }
    return $table;
}
