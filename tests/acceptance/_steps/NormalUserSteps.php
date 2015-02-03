<?php
namespace AcceptanceTester;

class NormalUserSteps extends \AcceptanceTester
{
    public function login($password = 'user')
    {
        $I = $this;
        $I->see("Login");
        $I->fillField('name', 'foo');
        $I->fillField('password', $password);
        $I->click('login');

    }
    public function logout()
    {
        $I = $this;
        $I->click('logout');
    }

    public function addGift()
    {
        $I = $this;
        $I->amOnPage('/');
        $I->click('add a gift');
        $I->fillField("name", "Test Gift");
        $I->fillField("comment", "With a comment");
        $I->fillField("url", "http://example.org");
        $I->fillField("picture", "http://example.org/foo");
        $I->fillField("price", "30");
        $I->selectOption('priority', 1);
        $I->click('add');
    }
}