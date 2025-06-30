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
 * Access control for mod_privatestudentfolder (capabilities definitions)
 *
 * @package       mod_privatestudentfolder
 * @author        University of Geneva, E-Learning Team
 * @author        Academic Moodle Cooperation {@link http://www.academic-moodle-cooperation.org}
 * @copyright     2025 University of Geneva {@link http://www.unige.ch}
 * @license       http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

$capabilities = [
        'mod/privatestudentfolder:view' => [
                'captype' => 'read',
                'contextlevel' => CONTEXT_MODULE,
                'archetypes' => [
                        'guest' => CAP_ALLOW,
                        'student' => CAP_ALLOW,
                        'teacher' => CAP_ALLOW,
                        'editingteacher' => CAP_ALLOW,
                        'manager' => CAP_ALLOW,
                ],
        ],

        'mod/privatestudentfolder:addinstance' => [
                'riskbitmask' => RISK_XSS,
                'captype' => 'write',
                'contextlevel' => CONTEXT_COURSE,
                'archetypes' => [
                        'editingteacher' => CAP_ALLOW,
                        'manager' => CAP_ALLOW,
                ],
                'clonepermissionsfrom' => 'moodle/course:manageactivities',
        ],

        'mod/privatestudentfolder:upload' => [
                'captype' => 'write',
                'contextlevel' => CONTEXT_MODULE,
                'archetypes' => [
                        'student' => CAP_ALLOW,
                        'teacher' => CAP_ALLOW,
                        'editingteacher' => CAP_ALLOW,
                        'manager' => CAP_ALLOW,
                ],
        ],

        'mod/privatestudentfolder:approve' => [
                'captype' => 'write',
                'contextlevel' => CONTEXT_MODULE,
                'archetypes' => [
                        'teacher' => CAP_ALLOW,
                        'editingteacher' => CAP_ALLOW,
                        'manager' => CAP_ALLOW,
                ],
        ],

        'mod/privatestudentfolder:grantextension' => [
                'captype' => 'write',
                'contextlevel' => CONTEXT_MODULE,
                'archetypes' => [
                        'teacher' => CAP_ALLOW,
                        'editingteacher' => CAP_ALLOW,
                        'manager' => CAP_ALLOW,
                ],
        ],

        'mod/privatestudentfolder:manageoverrides' => [
                'captype' => 'write',
                'contextlevel' => CONTEXT_MODULE,
                'archetypes' => [
                        'teacher' => CAP_ALLOW,
                        'editingteacher' => CAP_ALLOW,
                        'manager' => CAP_ALLOW,
                ],
        ],

        'mod/privatestudentfolder:receiveteachernotification' => [
            'captype' => 'read',
            'contextlevel' => CONTEXT_MODULE,
            'archetypes' => [
                'teacher' => CAP_ALLOW,
                'editingteacher' => CAP_ALLOW,
            ],
        ],
];
