<?php
/**
 *   @file index.php
 *   @brief Display the subject guides splash page
 *
 *   @author adarby
 *   @date mar 2011
 */
use SubjectsPlus\Control\CompleteMe;
use SubjectsPlus\Control\Querier;

include("../control/includes/config.php");
include("../control/includes/functions.php");
include("../control/includes/autoloader.php");

// If you have a theme set, but DON'T want to use it for this page, comment out the next line
if (isset($subjects_theme)  && $subjects_theme != "") { include("themes/$subjects_theme/index.php"); exit;}

$use_jquery = array("ui");

$page_title = $resource_name;
$description = "The best stuff for your research.  No kidding.";
$keywords = "research, databases, subjects, search, find";
$noheadersearch = TRUE;

$db = new Querier;

// let's use our Pretty URLs if mod_rewrite = TRUE or 1
if ($mod_rewrite == 1) {
   $guide_path = "";
} else {
   $guide_path = "guide.php?subject=";
}

if (isset($_GET['type']) && in_array(($_GET['type']), $guide_types)) {

    // use the submitted value
    $view_type = scrubData($_GET['type']);
} else {
    $view_type = "all";
}

///////////////////////
// Have they done a search?

$search = "";

if (isset($_POST["search"])) {
    $search = scrubData($_POST["search"]);
}

// set up our checkboxes for guide types
$tickboxes = "<ul>";

foreach ($guide_types as $key) {
    // $tickboxes .= "<li><input type=\"checkbox\" id=\"show-" . ucfirst($key) . "\" name=\"show$key\"";  Fixed the checkboxes issue 03/21/16
    // if ($view_type == "all" || $view_type == $key) {
    //    $tickboxes .= " checked=\"checked\"";
    // }
    //$tickboxes .= "/>" . ucfirst($key) . " Guides</li></li>\n";
}

$tickboxes .= "</ul>";

// Get the subjects for jquery autocomplete
$suggestibles = "";  // init

$q = "select subject, shortform from subject where active = '1' order by subject";



//initialize $suggestibles
$suggestibles = '';

foreach ($db->query($q) as $myrow) {
    $item_title = trim($myrow[0][0]);


	if(!isset($link))
	{
		$link = '';
	}

    $suggestibles .= "{text:\"" . htmlspecialchars($item_title) . "\", url:\"$link$myrow[1][0]\"}, ";

}

$suggestibles = trim($suggestibles, ', ');


// Get our newest guides

$q2 = "select subject, subject_id, shortform from subject where active = '1' order by subject_id DESC limit 0,5";

//$r2 = $db->query($q2);

$newest_guides = "<ul>\n";

foreach ($db->query($q2) as $myrow2 ) {
    $guide_location = $guide_path . $myrow2[2];
    $newest_guides .= "<li><a href=\"$guide_location\">" . trim($myrow2[0]) . "</a></li>\n";
}

$newest_guides .= "</ul>\n";

//get featured resources Added by Dan
//select info for 1 active random guides
$qfeatured = "SELECT title, location, access_restrictions, description FROM title t, location_title lt, location l WHERE t.title_id = lt.title_id AND l.location_id = lt.location_id AND t.featured = 1 order by t.title_id DESC";

//$rnew = $db->query($qnew);

$featured_resources = "<ul>\n";
    foreach ($db->query($qfeatured) as $myrow) {
    $db_url = "";

    // add proxy string if necessary
    if ($myrow[2] != 1) {
        $db_url = $proxyURL;
    }

    $featured_resources .= "<li><a href=\"$db_url$myrow[1][0]\">$myrow[0]</a><p>$myrow[3]</p></li>\n";
}
$featured_resources .= "</ul>\n";

// Get our newest databases

$qnew = "SELECT title, location, access_restrictions FROM title t, location_title lt, location l WHERE t.title_id = lt.title_id AND l.location_id = lt.location_id AND eres_display = 'Y' order by t.title_id DESC limit 0,5";

//$rnew = $db->query($qnew);

$newlist = "<ul>\n";
    foreach ($db->query($qnew) as $myrow) {
    $db_url = "";

    // add proxy string if necessary
    if ($myrow[2] != 1) {
        $db_url = $proxyURL;
    }

    $newlist .= "<li><a href=\"$db_url$myrow[1][0]\">$myrow[0]</a></li>\n";
}
$newlist .= "</ul>\n";

$searchbox = '
<div class="autoC" id="autoC" style="margin: 1em 2em 2em 0;">
    <form id="sp_admin_search" class="pure-form" method="post" action="search.php">
        <span class="titlebar_text">' .  _("Search Research Guides") . '</span>
        <input type="text" placeholder="Search" autocomplete="off" name="searchterm" size="" id="sp_search" class="ui-autocomplete-input autoC"><span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
        <input type="submit" alt="Search" name="submitsearch" id="topsearch_button" class="pure-button pure-button-topsearch" value="Go">
    </form>
</div>
';

// Add header now, because we need a value ($v2styles) from it

include("includes/header.php");

// put together our main result display

$guide_results = listGuides($search, $view_type);

if (isset ($v2styles) && $v2styles == 1) {
  $our_results = "<div id=\"letterhead\">$tickboxes</div>
  $guide_results";

  $layout = makePluslet("", $our_results, "","",FALSE);

} else {
  print "version 3 styles not set up yet";
}

////////////////////////////
// Now we are finally read to display the page
////////////////////////////

?>
<br />
<div class="pure-g" id="guidesplash">
<div class="pure-u-1 pure-u-md-2-3" id="listguides">
<?php print $layout; ?>

    </div>

    <div class="pure-u-1 pure-u-md-1-3">

      <!-- start pluslet -->
      <div class="pluslet">
        <div class="titlebar">
          <div class="titlebar_text"><?php print _("Search Guides"); ?></div>
        </div>
        <div class="pluslet_body"><?php print $searchbox; ?></div>
      </div>
      <!-- end pluslet -->
        <div class="pluslet">
            <div class="titlebar">
                <div class="titlebar_text"><?php print _("Newest Guides"); ?></div>
            </div>
            <div class="pluslet_body"> <?php print $newest_guides; ?> </div>
        </div>
        <!-- start pluslet -->
        <div class="pluslet">
            <div class="titlebar">
                <div class="titlebar_text"><?php print _("Newest Databases"); ?></div>
            </div>
            <div class="pluslet_body"> <?php print $newlist; ?> </div>
        </div>
        <!-- end pluslet -->
		    <!-- start pluslet -->
        <div class="pluslet">
            <div class="titlebar">
                <div class="titlebar_text"><?php print _("Featured Resources"); ?></div>
            </div>
            <div class="pluslet_body"> <?php print $featured_resources; ?> </div>
        </div>

        <!-- start pluslet -->
        <div class="pluslet">
            <div class="titlebar">
                <div class="titlebar_text"><?php print _("Search Library Catalog"); ?></div>
            </div>
                <div class="pluslet_body">
				             <form name="walter" action="http://walter.drew.edu/solr/keyword.php" method="post" target="_parent">Look here for books, print journals, and reserves.<br>
                       <input type="text" name="box1" size="50%" value="" onchange="document.summon.q.value=document.walter.box1.value;document.worldcat.q.value=document.walter.box1.value;document.gScholar.q.value=document.walter.box1.value;"><br>
                       <p align="right"><input type="submit" value="Search">
                         <input type="hidden" name="box1is" value="anywhere">
                         <input type="hidden" name="pubYear" value="pubYear">
                         <input type="hidden" name="whatitis" value="whatitis">
                         <input type="hidden" name="whereitsat" value="whereitsat">
                       </p></form>
					     </div>
        </div>
        <!-- end plusley -->
		<!-- start pluslet -->
    <div class="pluslet">
        <div class="titlebar">
          <div class="titlebar_text"><?php print _("Summon Search"); ?></div>
        </div>
        <div class="pluslet_body">
              <form name="summon" action="http://drew.summon.serialssolutions.com/search" method="get" target="_parent">Summon searches nearly everything (including journal articles) !
				 <br><input name="box2" type="text" name="q" size="50%" value="" onchange="document.walter.box1.value=document.summon.q.value;document.worldcat.q.value=document.summon.q.value;document.gScholar.q.value=document.summon.q.value;"><br>
				 <input type="hidden" name="ho" value="t">
				 <input type="hidden" name="l" value="en">
				 <p align="right"><input type="submit" value="Search Summon">
				 </p></form>
        </div>
      </div>

	  <!-- end pluslet -->
<!-- EBSCOhost Custom Search Box Begins -->
<script src="http://support.ebsco.com/eit/scripts/ebscohostsearch.js" type="text/javascript"></script>
<style type="text/css">
		.choose-db-list{ list-style-type:none;padding:0;margin:10px 0 0 0;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:9pt;width:340px; }
		.choose-db-check{ width:20px;float:left;padding-left:5px;padding-top:5px; }
		.choose-db-detail{ margin-left:30px;border-left:solid 1px #E7E7E7;padding:5px 11px 7px 11px;line-height:1.4em; }
		.summary { background-color:#1D5DA7;color:#FFFFFF;border:solid 1px #1D5DA7; }
		.one { background-color: #FFFFFF;border:solid 1px #E7E7E7;border-top:solid 1px #FFFFFF; }
		.two { background-color: #F5F5F5;border:solid 1px #E7E7E7;border-top:solid 1px #FFFFFF; }
		.selected { background-color: #E0EFF7;border:solid 1px #E7E7E7;border-top:solid 1px #FFFFFF; }
		#ebscohostCustomSearchBox #disciplineBlock { width:auto; }
		#ebscohostCustomSearchBox .limiter { float:left;margin:0;padding:0;width:50%; }
		
		#ebscohostsearchtext { width: 144px; }
		#ebscohostsearchtext.edspub { width: 245px; }
		
		.ebscohost-search-button.edspub {
			border: 1px solid #156619;
			padding: 5px 10px !important;
			border-radius: 3px;
			color: #fff;
			font-weight: bold;
			background-color: #156619;
		}
		
		.ebscohost-title.edspub {
			color: #1c7020;
			font-weight: bold;
		}
	</style>
	<div class="pluslet">
        <div class="titlebar">
          <div class="titlebar_text"><?php print _("Ebsco Discovery Service"); ?></div>
        </div>
	<form id="ebscohostCustomSearchBox" action="" onsubmit="return ebscoHostSearchGo(this);" method="post" style="width:340px; overflow:auto;">
		<input id="ebscohostwindow" name="ebscohostwindow" type="hidden" value="1" />
		<input id="ebscohosturl" name="ebscohosturl" type="hidden" value="http://ezproxy.drew.edu/login?url=http://search.ebscohost.com/login.aspx?direct=true&site=eds-live&scope=site&type=0&custid=s8998431&groupid=main&profid=eds&mode=bool&lang=en&authtype=ip,uid" />
		<input id="ebscohostsearchsrc" name="ebscohostsearchsrc" type="hidden" value="db" />
		<input id="ebscohostsearchmode" name="ebscohostsearchmode" type="hidden" value="+" />
		<input id="ebscohostkeywords" name="ebscohostkeywords" type="hidden" value="" />
		
		<div style="background-image:url('http://support.ebscohost.com/images/logos/eds100.gif'); background-repeat:no-repeat; height:50px; width:340px; font-family:Verdana,Arial,Helvetica,sans-serif;font-size:9pt; color:#353535;">
			<div style="padding-top:5px;padding-left:115px;">
				<span class="ebscohost-title " style="font-weight:bold;">Research databases</span>

				<div>
					<input id="ebscohostsearchtext" class="" name="ebscohostsearchtext" type="text" size="23"  style="font-size:9pt;padding-left:5px;margin-left:0px;" />
					<input type="submit" value="Search" class="ebscohost-search-button " style="font-size:9pt;padding-left:5px;" />
					
					<div id="guidedFieldSelectors">
						<input class="radio" type="radio" name="searchFieldSelector" id="guidedField_0" value="" checked="checked" />
						<label class="label" for="guidedField_0"> Keyword</label>
						<input class="radio" type="radio" name="searchFieldSelector" id="guidedField_1" value="TI" />
						<label class="label" for="guidedField_1"> Title</label>
						<input class="radio" type="radio" name="searchFieldSelector" id="guidedField_2" value="AU" />
						<label class="label" for="guidedField_2"> Author</label>
					</div>
					
				</div>
			</div>
		</div>

		<div id="limiterblock" style="margin-left:-px; overflow: auto; ">
			<div id="limitertitle" style="font-weight:bold;padding-top:25px;padding-bottom:5px;">Limit Your Results</div>
			
			<div class="limiter" >
				<input type="checkbox" id="chkFullText" name="chkFullText"  />
				<label for="chkFullText">Full Text</label>
			</div>
			
			<div class="limiter" >
				<input type="checkbox" id="chkLibraryCollection" name="chkLibraryCollection"  />
				<label for="chkLibraryCollection">Available in Library Collection</label>
			</div>
			
			<div class="limiter" >
				<input type="checkbox" id="chkPeerReviewed" name="chkPeerReviewed"  />
				<label for="chkPeerReviewed">Peer Reviewed</label>
			</div>
			
			<div class="limiter" >
				<input type="checkbox" id="chkCatalogOnly" name="chkCatalogOnly"  />
				<label for="chkCatalogOnly">Catalog Only</label>
			</div>
			
		</div>

		
		<div id="disciplineBlock" style="margin-left:-px; overflow: auto;">
			
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="AERO"  />
				<label for="">Aerospace Sciences</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="AGRI"  />
				<label for="">Agriculture & Agribusiness</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="ANTH"  />
				<label for="">Anthropology</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="APPL"  />
				<label for="">Applied Sciences</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="ARCH"  />
				<label for="">Architecture</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="ARTS"  />
				<label for="">Arts & Entertainment</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="BIOG"  />
				<label for="">Biography</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="BIOL"  />
				<label for="">Biology</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="BIOT"  />
				<label for="">Biotechnology</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="BOTA"  />
				<label for="">Botany</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="BUSI"  />
				<label for="">Business & Management</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="CHEM"  />
				<label for="">Chemistry</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="COMM"  />
				<label for="">Communication & Mass Media</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="CALM"  />
				<label for="">Complementary & Alternative Medicine</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="COMP"  />
				<label for="">Computer Science</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="CONS"  />
				<label for="">Construction & Building</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="COHE"  />
				<label for="">Consumer Health</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="DANC"  />
				<label for="">Dance</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="DENT"  />
				<label for="">Dentistry</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="DIPL"  />
				<label for="">Diplomacy & International Relations</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="DRAM"  />
				<label for="">Drama & Theater Arts</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="EART"  />
				<label for="">Earth & Atmospheric Sciences</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="ECON"  />
				<label for="">Economics</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="EDUC"  />
				<label for="">Education</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="ENGI"  />
				<label for="">Engineering</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="ENVI"  />
				<label for="">Environmental Sciences</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="ETHN"  />
				<label for="">Ethnic & Cultural Studies</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="FILM"  />
				<label for="">Film</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="FORE"  />
				<label for="">Forests & Forestry</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="GEOG"  />
				<label for="">Geography & Cartography</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="GEOL"  />
				<label for="">Geology</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="HEAL"  />
				<label for="">Health & Medicine</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="HIST"  />
				<label for="">History</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="INFO"  />
				<label for="">Information Technology</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="LANG"  />
				<label for="">Language & Linguistics</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="LAWX"  />
				<label for="">Law</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="LIBR"  />
				<label for="">Library & Information Science</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="LIFE"  />
				<label for="">Life Sciences</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="LITE"  />
				<label for="">Literature & Writing</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="MARK"  />
				<label for="">Marketing</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="MATH"  />
				<label for="">Mathematics</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="MILI"  />
				<label for="">Military History & Science</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="MINI"  />
				<label for="">Mining & Mineral Resources</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="MUSI"  />
				<label for="">Music</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="NURS"  />
				<label for="">Nursing & Allied Health</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="NUTR"  />
				<label for="">Nutrition & Dietetics</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="OCEA"  />
				<label for="">Oceanography</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="PHAR"  />
				<label for="">Pharmacy & Pharmacology</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="PHYT"  />
				<label for="">Physical Therapy</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="PHYS"  />
				<label for="">Physics</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="POGV"  />
				<label for="">Politics & Government</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="POWE"  />
				<label for="">Power & Energy</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="PSYC"  />
				<label for="">Psychology</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="PUBL"  />
				<label for="">Public Health</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="RELI"  />
				<label for="">Religion & Philosophy</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="SCIE"  />
				<label for="">Science</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="SSHU"  />
				<label for="">Social Sciences & Humanities</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="SOWO"  />
				<label for="">Social Work</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="SOCY"  />
				<label for="">Sociology</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="SPLS"  />
				<label for="">Sports & Leisure</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="SPME"  />
				<label for="">Sports Medicine</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="TECH"  />
				<label for="">Technology</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="VETM"  />
				<label for="">Veterinary Medicine</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="VISU"  />
				<label for="">Visual Arts</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="WOFE"  />
				<label for="">Women's Studies & Feminism</label>
			</div>
			<div style="display:none;">
				<input type="checkbox" id="" name="" value="ZOOL"  />
				<label for="">Zoology</label>
			</div>
		</div>
		  </div>
      </div>

		
	</form>
	<!-- EBSCOhost Custom Search Box Ends -->
        <br />

    </div>
</div>
<?php
///////////////////////////
// Load footer file
///////////////////////////

include("includes/footer.php");

?>

<script type="text/javascript" language="javascript">
    $(document).ready(function(){

        // add rowstriping
        stripeR();


        $("[id*=show]").on("change", function() {

            var showtype_id = $(this).attr("id").split("-");
            //alert("u clicked: " + showtype_id[1]);
            unStripeR();
            $(".type-" + showtype_id[1]).toggle();
            stripeR();


        });

        function stripeR() {
            $(".zebra").not(":hidden").filter(":even").addClass("evenrow");
            $(".zebra").not(":hidden").filter(":odd").addClass("oddrow");
        }

        function unStripeR () {
            $(".zebra").removeClass("evenrow");
            $(".zebra").removeClass("oddrow");
        }

    });
</script>
