<?php
   namespace SubjectsPlus\Control;
     require_once("Pluslet.php");
/**
 *   @file sp_Pluslet_90
 *   @brief The number corresponds to the ID in the database.
 *
 *   @author bauderj
 *   @date July 2011
 *   @todo 
 */
class Pluslet_90 extends Pluslet {

    public function __construct($pluslet_id, $flag="", $subject_id) {

        parent::__construct($pluslet_id, $flag, $subject_id);

        $this->_editable = FALSE;
        $this->_subject_id = $subject_id;
        $this->_pluslet_id = 90;
        $this->_pluslet_id_field = "pluslet-" . $this->_pluslet_id;
        $this->_title = _("Ask a Librarian");
    }

    public function output($action="", $view="public") {

        // public vs. admin
        parent::establishView($view);

if ( strpos($_SERVER['SCRIPT_FILENAME'], 'control/') !== false ) {
	$path1 = "../../assets/users/_";
} else {
	$path1 = "../assets/users/_";
}

/////////////////////
// Staff info
// Grabs librarian responsible for subject
/////////////////////

$staff_query = "select distinct fname, email, lname from staff, staff_subject WHERE staff.staff_id = staff_subject.staff_id and staff_subject.subject_id = '$this->_subject_id' ORDER BY fname LIMIT 1";

$querier = new sp_Querier();

//print $staff_query; 

$staff_result = $querier->getResult($staff_query);

foreach($staff_result as $myrow) { 
  
	$truncated_email = explode("@", $myrow[1]);	

	$libh3lpid = strtolower($myrow[0]) . strtolower($myrow[2]);
}

$this->_body .= _("<div class=\"needs-js\">
JavaScript disabled or chat unavailable. Please enable JavaScript, or <a href=\"http://www.grinnell.edu/library/emailquery\">submit questions via the Web form</a>.
</div>
<div class=\"libraryh3lp\" style=\"display: none;\" jid=\"$libh3lpid@chat.libraryh3lp.com\">
<a href=\"#\" onclick=\"window.open('http://libraryh3lp.com/chat/$libh3lpid@chat.libraryh3lp.com?skin=13522&amp;theme=simpletext&amp;title=Ask+$myrow[0]&amp;identity=$myrow[0]', 'chat', 'resizable=1,width=320,height=400'); return false;\">Ask $myrow[0] a question via IM.</a><br />Chat will open in a new window.
</div>
<div class=\"libraryh3lp\" style=\"display: none;\" jid=\"query@chat.libraryh3lp.com\">
$myrow[0] is not available right now, but you can 
<a href=\"#\" onclick=\"window.open('http://libraryh3lp.com/chat/query@chat.libraryh3lp.com?skin=13522&amp;theme=simpletext&amp;title=" . htmlentities("Ask a Librarian") . "&amp;identity=librarian', 'chat', 'resizable=1,width=320,height=400'); return false;\">chat with another librarian or reference assistant.</a><br />Chat will open in a new window.
</div>
<div class=\"libraryh3lp\" style=\"display: none;\">
No librarians are available to chat now, but you can still ask questions via e-mail! You can <a href=\"mailto:$myrow[1]\">e-mail $myrow[0]</a>, or you can <a href=\"http://www.grinnell.edu/library/emailquery\">ask a question via the Web form.</a>
</div>");

}

    parent::assemblePluslet();

    return $this->_pluslet;

}
	
	
}
?>
