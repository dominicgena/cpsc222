<?php
    function get_letter($grade) {
        $letter = "";
        if($grade < INF) { $letter = "A+"; }
        if($grade <= 95) { $letter = "A"; }
        if($grade < 90) { $letter = "A-"; }
        if($grade < 87) { $letter = "B+"; }
        if($grade < 83) { $letter = "B"; }
        if($grade < 81) { $letter = "B-"; }
        if($grade < 78) { $letter = "C+"; }
        if($grade < 75) { $letter = "C"; }
        if($grade < 72) { $letter = "C-"; }
        if($grade < 70) { $letter = "D+"; }
        if($grade < 67) { $letter = "D"; }
        if($grade < 63) { $letter = "D-"; }
        if($grade < 61) { $letter = "F"; }

        return $letter;
    }
?>