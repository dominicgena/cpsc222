<?php
require_once('lettergrades.php');
  class Student {
    private $fname;
    private $lname;
    private $id;
    private $courses;

    function __construct($f, $l, $id, $c) { $this->set_fname($f); $this->set_lname($l); $this->set_id($id); $this->set_courses($c); }

    function set_fname($fname) { $this->fname = $fname; }
    function set_lname($lname) { $this->lname = $lname; }
    function set_id($id) { $this->id = $id; }
    function add_course($course, $grade) { $this->courses[$course] = $grade; }
    function set_courses($courses) { $this->courses = $courses; }

    function get_fname() { return $this->fname; }
    function get_lname() { return $this->lname; }
    function get_id() { return $this->id; }
    function get_courses() { return $this->courses; }

    function format_student() {
        $f = $this->get_fname();
        $l = $this->get_lname();
        $id = $this->get_id();
        $c = $this->get_courses();

        // the php is ugly so the html doesn't have to be
        echo "\n    <table border='1' style='margin-bottom: 20px; width: 300px;'>\n"; 
        echo "      <tr>\n        <th>Name</th>\n        <td>" . $l . ", " . $f . "</td>\n      </tr>\n";
        echo "      <tr>\n        <th>Student ID</th>\n        <td>" . $id . "</td>\n      </tr>\n";
        echo "      <tr>\n        <th>Grades</th>\n        <td>\n        " . $this->format_grades($c) . "        </td>\n      </tr>\n";
        echo "    </table>\n";
    }

    function format_grades($courses) {
        $output = "  <ul>\n";
        foreach($courses as $course => $grade) {
            $output = $output . "          <li>" . $course . " - " . $grade . "  " . get_letter($grade) . "</li>\n";
        }
        $output = $output . "        </ul>\n";

        return $output;
    }
  }
?>
