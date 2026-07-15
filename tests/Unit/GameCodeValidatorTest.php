<?php

namespace Tests\Unit;

use App\Services\GameCodeValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GameCodeValidatorTest extends TestCase
{
    private GameCodeValidator $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = new GameCodeValidator;
    }

    #[Test]
    public function it_normalizes_finnish_characters_and_spacing(): void
    {
        $this->assertSame('SJOBERG', $this->validator->normalize('SJ ÖBERG'));
        $this->assertSame('RADHUS', $this->validator->normalize('RÅDHUS'));
        $this->assertSame('EIVARASTETTUKATKETTY', $this->validator->normalize('EI VARASTETTU. KÄTKETTY.'));
    }

    #[Test]
    #[DataProvider('matchingCodesProvider')]
    public function it_matches_expected_codes(string $input, string $expected, ?array $alternatives, bool $shouldMatch): void
    {
        $this->assertSame(
            $shouldMatch,
            $this->validator->matches($input, $expected, $alternatives),
        );
    }

    public static function matchingCodesProvider(): array
    {
        return [
            'exact match' => ['VANKILA', 'VANKILA', null, true],
            'case insensitive' => ['valo', 'VALO', null, true],
            'alternative with spaces' => ['sj oberg', 'SJÖBERG', ['SJOBERG'], true],
            'kurtén without accent' => ['kurten', 'KURTÉN', ['KURTEN'], true],
            'wrong code' => ['PRISON', 'VANKILA', null, false],
        ];
    }
}
