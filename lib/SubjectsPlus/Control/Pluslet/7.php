<?php
   namespace SubjectsPlus\Control;
     require_once("Pluslet.php");
/**
 *   @file sp_Pluslet_5
 *   @brief LibraryH3lp pluslet
 *   @author jheise
 *   @date August 2013
 *   @todo 
 */

class Pluslet_7 extends Pluslet {

    public function __construct($pluslet_id, $flag="", $subject_id) {

        parent::__construct($pluslet_id, $flag, $subject_id);

        $this->_editable = FALSE;
        $this->_subject_id = $subject_id;
        $this->_pluslet_id = 7;
        $this->_pluslet_id_field = "pluslet-" . $this->_pluslet_id;
        $this->_title = _("Chat with a Librarian");
    }

    public function output($action="", $view="public") {

        // public vs. admin
        parent::establishView($view);
        // example form action:  http://icarus.ithaca.edu/cgi-bin/Pwebrecon.cgi?
        $this->_body = '<div class="needs-js">JavaScript disabled or chat unavailable.</div>
<!-- Place this script as near to the end of your BODY as possible. -->
<script type="text/javascript">
  (function() {
    var x = document.createElement("script"); x.type = "text/javascript"; x.async = true;
    x.src = (document.location.protocol === "https:" ? "https://" : "http://") + "us.libraryh3lp.com/js/libraryh3lp.js?5452";
    var y = document.getElementsByTagName("script")[0]; y.parentNode.insertBefore(x, y);
  })();
</script>
            ';



        parent::assemblePluslet();

        return $this->_pluslet;
    }

}

?>
