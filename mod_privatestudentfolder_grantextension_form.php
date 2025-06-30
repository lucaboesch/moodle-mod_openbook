<?php
// This file is part of mod_privatestudentfolder for Moodle - http://moodle.org/
//
// It is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// It is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Form class for granting extensions for student's submissions
 *
 * @package       mod_privatestudentfolder
 * @author        University of Geneva, E-Learning Team
 * @author        Academic Moodle Cooperation {@link http://www.academic-moodle-cooperation.org}
 * @copyright     2025 University of Geneva {@link http://www.unige.ch}
 * @license       http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/course/moodleform_mod.php');
require_once($CFG->dirroot . '/mod/privatestudentfolder/locallib.php');

/**
 * Form for granting extensions
 *
 * @package       mod_privatestudentfolder
 * @author        University of Geneva, E-Learning Team
 * @author        Academic Moodle Cooperation {@link http://www.academic-moodle-cooperation.org}
 * @copyright     2025 University of Geneva {@link http://www.unige.ch}
 * @license       http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_privatestudentfolder_grantextension_form extends moodleform {
    /** @var object privatestudentfolder instance */
    private $instance;

    /**
     * Form definition method
     */
    public function definition() {
        $privatestudentfolder = &$this->_customdata['privatestudentfolder'];
        $this->instance = $privatestudentfolder->get_instance();
        $userids = &$this->_customdata['userids'];

        $mform = $this->_form;

        if ($privatestudentfolder->get_instance()->allowsubmissionsfromdate) {
            $mform->addElement('static', 'fromdate',
                    get_string('allowsubmissionsfromdate', 'privatestudentfolder'),
                    userdate($privatestudentfolder->get_instance()->allowsubmissionsfromdate));
        }

        if ($privatestudentfolder->get_instance()->duedate) {
            $mform->addElement('static', 'duedate',
                    get_string('duedate', 'privatestudentfolder'), userdate($privatestudentfolder->get_instance()->duedate));
            $finaldate = $privatestudentfolder->get_instance()->duedate;
        } else {
            $finaldate = 0;
        }

        $mform->addElement('date_time_selector', 'extensionduedate',
                get_string('extensionduedate', 'privatestudentfolder'), ['optional' => true]);
        if ($finaldate) {
            $mform->setDefault('extensionduedate', $finaldate);
        }

        if (count($userids) == 1) {
            $extensionduedate = $privatestudentfolder->user_extensionduedate($userids[0]);
            if ($extensionduedate) {
                $mform->setDefault('extensionduedate', $extensionduedate);
            }
        }

        $mform->addElement('hidden', 'id', $privatestudentfolder->get_coursemodule()->id);
        $mform->setType('id', PARAM_INT);

        foreach ($userids as $idx => $userid) {
            $mform->addElement('hidden', 'userids[' . $idx . ']', $userid);
            $mform->setType('userids[' . $idx . ']', PARAM_INT);
        }

        $this->add_action_buttons(true, get_string('save_changes', 'privatestudentfolder'));
    }

    /**
     * Perform validation on the extension form
     *
     * @param array $data
     * @param array $files
     * @return string[] errors
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        if ($this->instance->duedate && $data['extensionduedate']) {
            if ($this->instance->duedate > $data['extensionduedate']) {
                $errors['extensionduedate'] = get_string('extensionnotafterduedate', 'privatestudentfolder');
            }
        }
        if ($this->instance->allowsubmissionsfromdate && $data['extensionduedate']) {
            if ($this->instance->allowsubmissionsfromdate > $data['extensionduedate']) {
                $errors['extensionduedate'] = get_string('extensionnotafterfromdate', 'privatestudentfolder');
            }
        }

        return $errors;
    }
}
