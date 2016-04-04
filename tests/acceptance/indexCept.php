<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Ensure the index page displays the expected output');
$I->amOnPage('localhost:81/subjects/index.php');
$I->see('Music');
$I->see('General');
$I->see('Biology');


//$I->click('General');
//$I->see('General');
//$I->see('Audio Files');

//$I->amOnPage('/subjects/index.php');

$I->click('Art');
//$I->click(['class' => 'subject']);
//$I->see('Archives of American Art');

//$I->amOnPage('/subjects/index.php');

?>