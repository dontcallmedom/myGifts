<?php
$I = new AcceptanceTester\AdminSteps($scenario);
$I->amOnPage('/?handler=adminUsers');
$I->login();
$I->addNormalUser();
$I->amOnPage('/?handler=adminUsers');
$I->click(['xpath' => '//a[.="change password"][1]']);
$I->see("Changing foo's password");
$I->fillField("password","bar");
$I->fillField("password2","bar");
$I->click("save");
$I->amOnPage('/?handler=adminUsers');
$I->logout();

$they = new AcceptanceTester\NormalUserSteps($scenario);
$they->login();
$they->see("bad password");
$they->login("bar");
$they->see("My List");
$they->click("Change password");
$they->fillField("password","user");
$they->fillField("password2","user");
$they->click("save");
$they->logout();
$they->login();
$they->see("My List");
$they->logout();

$I->login();
$I->deleteNormalUser();
