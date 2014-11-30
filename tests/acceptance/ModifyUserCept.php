<?php
$I = new AcceptanceTester\AdminSteps($scenario);
$I->amOnPage('/?handler=adminUsers');
$I->login();
$I->addNormalUser();
$I->amOnPage('/?handler=adminUsers');
$I->click(['xpath' => '//a[.="modify"][1]']);
$I->see('Edit user');
$I->seeInField("name", "foo");
$I->seeInField("email", "user@localhost.net");
$I->seeOptionIsSelected("birthDate[Date_Month]", "February");
$I->seeOptionIsSelected("birthDate[Date_Day]", "29");
$I->seeOptionIsSelected("accessLevel", "normal (has a wish list)");
$I->fillField("email", "foo@localhost.net");
$I->click('save');
$I->click(['xpath' => '//a[.="modify"][1]']);
$I->seeInField("email", "foo@localhost.net");
$I->logout();

$they = new AcceptanceTester\NormalUserSteps($scenario);
$they->login();
$they->click("Edit my profile");
$they->seeInField("email", "foo@localhost.net");
$they->dontSee("Access level");
$they->fillField("email", "user@localhost.net");
$they->click('save');
$they->seeInField("email", "user@localhost.net");
$they->logout();

$I->login();
$I->deleteNormalUser();
