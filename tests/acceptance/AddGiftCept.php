<?php
$I = new AcceptanceTester\AdminSteps($scenario);
$I->amOnPage('/');
$I->login();
$I->addNormalUser();
$I->logout();

$they = new AcceptanceTester\NormalUserSteps($scenario);
$they->login();
$they->addGift();
$they->amOnPage('/');
$they->logout();

$I->login();
$I->click("foo");
$I->see("Gift List of : foo");
$I->see("Test Gift");
$I->see("With a comment");
$I->seeLink("example.org", "http://example.org");
$I->seeElement("//img[contains(@src,'default/static/1.gif')]");
// Undo
$I->deleteNormalUser();
$I->logout();