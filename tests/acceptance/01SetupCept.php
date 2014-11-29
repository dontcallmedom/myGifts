<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('set up the system');
$I->amOnPage('/');
$I->see('Installation/Setup');
$I->click('sauvegarder/save');
$I->see('Database setup');
$I->fillField('dbserver', 'localhost');
$I->fillField('dbuser', 'mygifts_dev');
$I->fillField('dbpassword', 'mygifts_dev');
$I->fillField('dbdatabase', 'mygifts_dev');
$I->click('save');
$I->amOnPage('/setup.php');
$I->see('Select a setup type');
$I->fillField('name', 'tester');
$I->fillField('email', 'tester@localhost.org');
$I->fillField('password', 'tester');
$I->click('add');
$I->amOnPage('/setup.php');
$I->see('Setup is finished');
?>