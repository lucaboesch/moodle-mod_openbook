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

namespace mod_privatestudentfolder\completion;

use core_completion\activity_custom_completion;

/**
 * Activity custom completion subclass for the assign activity.
 *
 * Class for defining mod_assign's custom completion rules and fetching the completion statuses
 * of the custom completion rules for a given assign instance and a user.
 *
 * @package       mod_privatestudentfolder
 * @author        University of Geneva, E-Learning Team
 * @author        Academic Moodle Cooperation {@link http://www.academic-moodle-cooperation.org}
 * @copyright     2025 University of Geneva {@link http://www.unige.ch}
 * @license       http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class custom_completion extends activity_custom_completion {

    /**
     * Fetches the completion state for a given completion rule.
     *
     * @param string $rule The completion rule.
     * @return int The completion state.
     */
    public function get_state(string $rule): int {
        global $CFG, $DB;

        $this->validate_rule($rule);

        $userid = $this->userid;
        $cm = $this->cm;

        require_once($CFG->dirroot . '/mod/privatestudentfolder/locallib.php');

        $privatestudentfolder = new \privatestudentfolder($cm, $cm->course, \context_module::instance($cm->id));
        $status = false;
        if ($privatestudentfolder->get_mode() == PRIVATESTUDENTFOLDER_MODE_FILEUPLOAD) {
            $filescount = $DB->count_records('privatestudentfolder_file', [
                'privatestudentfolder' => $privatestudentfolder->get_instance()->id,
                'userid' => $userid,
            ]);
            $status = $filescount > 0;
        } else {
            $status = true;
        }
        return $status ? COMPLETION_COMPLETE : COMPLETION_INCOMPLETE;
    }

    /**
     * Fetch the list of custom completion rules that this module defines.
     *
     * @return array
     */
    public static function get_defined_custom_rules(): array {
        return ['completionupload'];
    }

    /**
     * Returns an associative array of the descriptions of custom completion rules.
     *
     * @return array
     */
    public function get_custom_rule_descriptions(): array {
        return [
            'completionupload' => get_string('completiondetail:upload', 'privatestudentfolder'),
        ];
    }

    /**
     * Returns an array of all completion rules, in the order they should be displayed to users.
     *
     * @return array
     */
    public function get_sort_order(): array {
        return [
            'completionview',
            'completionupload',
        ];
    }
}
