<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;

trait DataFixturesTrait
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
        $this->faker->seed(1234);
    }

    public function generateParagraphs(
        int $paragraphMin = 6,
        int $paragraphMax = 7,
        int $sentencesMin = 7,
        int $sentencesMax = 9
    ): string {
        $paragraphs = [];

        $paragraphCount = $this->faker->numberBetween($paragraphMin, $paragraphMax);
        $sentences = $this->faker->numberBetween($sentencesMin, $sentencesMax);

        for ($i = 0; $i < $paragraphCount; ++$i) {
            $paragraphs[] = $this->faker->paragraph($sentences);
        }

        return implode("\n\n", $paragraphs);
    }
}
