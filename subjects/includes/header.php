<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<title><?php print $page_title; ?></title>

<title>Library Subject Resources</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="Description" content="The best stuff for your research.  No kidding.">
<meta name="Keywords" content="research, databases, subjects, search, find">

<link type="text/css" media="screen" rel="stylesheet" href="<?php print $AssetPath; ?>css/shared/pure-min.css">
<link type="text/css" media="screen" rel="stylesheet" href="<?php print $AssetPath; ?>css/shared/grids-responsive-min.css">
<link type="text/css" media="screen" rel="stylesheet" href="<?php print $AssetPath; ?>css/public/default.css">
<link type="text/css" media="print" rel="stylesheet" href="<?php print $AssetPath; ?>css/public/print.css">

<link type="text/css" media="all" rel="stylesheet" href="http://walter.drew.edu/splus/assets/css/bootstrap.css">
<link type="text/css" media="screen" rel="stylesheet" href="http://walter.drew.edu/splus/assets/css/default.css">
<link type="text/css" media="print" rel="stylesheet" href="http://walter.drew.edu/splus/assets/css/print.css"> 

<?php 
// Load our jQuery libraries + some css
if (isset($use_jquery)) { print generatejQuery($use_jquery);
}

if (!isset ($noheadersearch)) { 
    
    $search_form = '
            <div class="autoC" id="autoC">
                <form id="sp_admin_search" class="pure-form" method="post" action="' . getSubjectsURL() . 'search.php">
                <input type="text" placeholder="Search" autocomplete="off" name="searchterm" size="" id="sp_search" class="ui-autocomplete-input autoC"><span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                <input type="submit" alt="Search" name="submitsearch" id="topsearch_button" class="pure-button pure-button-topsearch" value="Go">
                </form>
            </div>    ';
} else {
    $search_form = '';
}

// We've got a variable for those who wish to keep the old styles
$v2styles = TRUE;
?>
</head>

<body>
<div id="wrap">

<div id="header"> 
    <div id="header_inner_wrap">
  	<div>
        <table border="0" cellspacing="10" class="navbar">
  <tbody><tr>
    <td rowspan="2"><img src="http://depts.drew.edu/lib/D_library.jpg" width="60" height="60"></td>
    <td colspan="5" valign="top" class="RunningHead"><a href="http://www.drew.edu/library">Drew Library</a></td>
 </tr>
  <tr valign="top">
    <td><a href="http://walter.drew.edu/splus/subjects/databases.php">Resources A-Z</a></td>
<td> | </td><td>
    </td><td><a href="http://walter.drew.edu/splus/subjects/index.php?type=Subject">Resources by Subject</a></td>
<td> | </td><td>
    </td><td><a href="http://walter.drew.edu/splus/subjects/index.php?type=Course">Course Pages</a></td>
<td> | </td><td>
    </td><td><a href="http://drew.summon.serialssolutions.com/">Summon</a></td>
<td> | </td><td>
    </td><td><a href="http://illiad.drew.edu">ILL</a></td>
<td> | </td><td>
    </td><td><a href="http://www.drew.edu/library/research">Research Resources</a></td>
</tr>

</tbody></table>
	</div>
<div style="float: right">
<!-- ?php
include ("proactive-custom-popout.php");
-->
 </div>
    </div>
</div>

<div class="wrapper-full">
    <div class="pure-g">
        <div class="pure-u-1">
            <?php if (!isset($v2styles)) { print "<h1>$page_title</h1>"; } ?>
            <div id="content_roof"></div> <!-- end #content_roof -->
            <div id="shadowkiller"></div> <!--end #shadowkiller-->
        
            <div id="body_inner_wrap">
