<?php
// Test if book search is currently added to page
$I = new AcceptanceTester($scenario);
$I->wantTo('see if added Catalog Search Pluslet returns search results');
/*$I->amOnPage('/subjects/guide.php?subject=general');
$I->canSee("Book Search");*/
//login to edit page
$I->amOnPage('/control/login.php');
$I->see('Please enter your credentials to proceed');
$I->fillField('Email', 'jheise@drew.edu');
$I->fillField('Password', 'w3bm@n@g3r');
$I->click('Submit');
$I->click('Guides');
$I->seeInCurrentUrl('/control/guides');
$I->click('Basketweaving');
$I->see("Book Search");
$I->fillField('box1', 'art');
$I->click('Search');
$I->seeInCurrentUrl('solr/keyword.php?box1=art');
/*
$I->seeInCurrentUrl('/control/guides/guide.php?subject_id=1');
$I->moveMouseOver('#');
$I->seeElement('pluslet-id-5');
$I->dragAndDrop('pluslet-id-5', 'dropsport-sidebar-1');
$I->click('SAVE CHANGES');
//Go back to page and
$I->amOnPage('/subjects/guide.php?subject=general');
$I->canSee('Book Search');
$I->fillField('Search_Arg','Apples');
$I->click('Go!');
*/
?>
