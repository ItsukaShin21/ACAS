<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Unit\FirstTest as UnitFirstTest;

class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function tryToTest(AcceptanceTester $I)
    {
        // Example usage of the unit test within an acceptance test
        $unitTest = new UnitFirstTest();
        $unitTest->testSanitizeInput();
        $unitTest->testGetCurrentTimestamp();
        $unitTest->testCheckExistingRecord();

        // Add similar calls for other unit test methods
    }
}
