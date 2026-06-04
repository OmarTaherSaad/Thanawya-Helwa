<?php

namespace Tests\Unit\Tansik;

use App\Support\Tansik\DigitalGovCoordinationLimitParser;
use PHPUnit\Framework\TestCase;

class DigitalGovCoordinationLimitParserTest extends TestCase
{
    public function test_parses_table14_rows(): void
    {
        $html = <<<'HTML'
<table dir="ltr" border="1" width="60%" id="table14" cellspacing="0">
    <tr>
        <td align="center"><font class="content2">الكلية</font></td>
        <td align="center"><font class="content2">الحد الأدنى</font></td>
    </tr>
    <tr><td align="center">طب سوهاج</td><td align="center">387.5</td></tr>
    <tr><td align="center">هندسة القاهرة</td><td align="center">368.5</td></tr>
</table>
HTML;

        $parser = new DigitalGovCoordinationLimitParser;
        $rows = $parser->parseLimitTableHtml($html);

        $this->assertSame(387.5, $rows['طب سوهاج']);
        $this->assertSame(368.5, $rows['هندسة القاهرة']);
    }

    public function test_normalize_program_name_matches_legacy_rules(): void
    {
        $this->assertSame(
            'كليه القاهره',
            DigitalGovCoordinationLimitParser::normalizeProgramNameForStorage('كلية القاهرة')
        );
    }
}
