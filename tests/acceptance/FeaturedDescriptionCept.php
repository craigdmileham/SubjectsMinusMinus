<?php
//barebones test of featured resource
$I = new AcceptanceTester($scenario);
$I->wantTo('make sure that featured resource description is visible');
$I->amOnPage('/subjects/index.php');
$I->see("Links to Mathematics journals, bibliographies, listservs, government resources, career information, and other general resources.");
?>