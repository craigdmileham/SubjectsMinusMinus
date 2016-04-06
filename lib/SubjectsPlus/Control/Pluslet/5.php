<?php
   namespace SubjectsPlus\Control;
     require_once("Pluslet.php");
/**
 *   @file sp_Pluslet_5
 *   @brief The number corresponds to the ID in the database.  Numbered pluslets are UNEDITABLE clones
 * 		this one displays the Catalog Search Box
 *     YOU WILL NEED TO LOCALIZE THIS!
 *
 *   @author agdarby
 *   @date Feb 2011
 *   @todo
 */

class Pluslet_5 extends Pluslet {

    public function __construct($pluslet_id, $flag="", $subject_id) {

        parent::__construct($pluslet_id, $flag, $subject_id);

        $this->_editable = FALSE;
        $this->_subject_id = $subject_id;
        $this->_pluslet_id = 5;
        $this->_pluslet_id_field = "pluslet-" . $this->_pluslet_id;
        $this->_title = _("Book Search");
    }

    public function output($action="", $view="public") {

        // public vs. admin
        parent::establishView($view);
        // example form action:  http://icarus.ithaca.edu/cgi-bin/Pwebrecon.cgi?
        $this->_body = '
            <form action="http://walter.drew.edu/solr/keyword.php" method="get" name="querybox" id="querybox">
              <strong>Search Library Catalog:</strong><br>
            <input type="text" name="box1" size="25" value="" onchange="document.summon.q.value=document.walter.box1.value;document.worldcat.q.value=document.walter.box1.value;document.gScholar.q.value=document.walter.box1.value;">
            <input type="submit" value="Search">
            <input type="hidden" name="box1is" value="anywhere">
            <input type="hidden" name="pubYear" value="pubYear">
            <input type="hidden" name="whatitis" value="whatitis">
            <input type="hidden" name="whereitsat" value="whereitsat">
            </form>
            ';



        parent::assemblePluslet();

        return $this->_pluslet;
    }

}

?>
