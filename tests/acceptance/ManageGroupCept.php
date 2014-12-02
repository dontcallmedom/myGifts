<?php
$I = new AcceptanceTester\AdminSteps($scenario);
$I->amOnPage('/');
$I->login();
$I->click('administration');
$I->click('Group administration');
$I->see('Default group');
$I->click('modify');
$I->fillField('name', 'Special group');
$I->click('save');
$I->see('Special group');
$I->click('modify');
$I->fillField('name', 'Default group');
$I->click('save');
$I->click('add');
$I->fillField('name', 'Test group');
$I->click('add');
$I->see('Default group');
$I->see('Test group');

$I->addNormalUser();
$I->amOnPage('/index.php?handler=adminUsers');
$I->click(['xpath' => '//a[.="modify"][1]']);


$I->seeCheckboxIsChecked("#group-1");
$I->dontSeeCheckboxIsChecked("#group-2");
$I->checkOption("Test group");
$I->uncheckOption("Default group");
$I->click('save');
$I->click(['xpath' => '//a[.="modify"][1]']);
$I->seeCheckboxIsChecked("#group-2");
$I->dontSeeCheckboxIsChecked("#group-1");
$I->logout();

$they = new AcceptanceTester\NormalUserSteps($scenario);
$they->login();
$they->dontSee("tester");
$they->logout();
// Undo

$I->login();
$I->amOnPage('/index.php?handler=adminGroups');
$I->click(['xpath' => '//a[.="delete"][2]']);
$I->see('delete group Test group');
$I->click('Yes');
$I->dontSee('Test group');
$I->deleteNormalUser();
