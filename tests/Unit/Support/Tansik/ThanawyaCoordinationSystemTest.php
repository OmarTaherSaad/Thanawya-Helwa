<?php

namespace Tests\Unit\Support\Tansik;

use App\Support\Tansik\ThanawyaCoordinationSystem;
use PHPUnit\Framework\TestCase;

class ThanawyaCoordinationSystemTest extends TestCase
{
    public function test_percent_max_totals_match_thanawya_era_scales(): void
    {
        $totals = ThanawyaCoordinationSystem::percentMaxTotalsForFrontend();

        $this->assertSame(410, $totals[ThanawyaCoordinationSystem::PRE_SINGLE_YEAR]);
        $this->assertSame(410, $totals[ThanawyaCoordinationSystem::SINGLE_YEAR_PAPER]);
        $this->assertSame(410, $totals[ThanawyaCoordinationSystem::ELECTRONIC_BANK]);
        $this->assertSame(320, $totals[ThanawyaCoordinationSystem::NEW_CURRICULUM]);
        $this->assertSame(410, $totals[ThanawyaCoordinationSystem::OLDER_CANDIDATES]);
    }

    public function test_percent_max_total_for_system_returns_null_for_unknown_slug(): void
    {
        $this->assertNull(ThanawyaCoordinationSystem::percentMaxTotalForSystem('not_a_system'));
    }
}
