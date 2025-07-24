<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\RegionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RegionFixtures extends Fixture implements FixtureGroupInterface
{
    use DataFixturesTrait;

    /**
     * @var array<int, mixed>
     */
    private array $regions = [
        [
            'id' => 'AFRICA',
            'name' => 'Africa',
            'briefDescription' => 'Africa is the world\'s second-largest and second-most populous continent, after Asia in both cases. At about 30.3 million km² including adjacent islands, it covers 6% of Earth\'s total surface area and 20% of its land area.',
            'shortDescription' => 'Africa is the world\'s second-largest and second-most populous continent, after Asia in both cases.',
            'longDescription' => 'Africa is the world\'s second-largest and second-most populous continent, after Asia in both cases. At about 30.3 million km² including adjacent islands, it covers 6% of Earth\'s total surface area and 20% of its land area. With 1.3 billion people as of 2018, it accounts for about 16% of the world\'s human population. Africa\'s population is the youngest amongst all the continents; the median age in 2012 was 19.7, when the worldwide median age was 30.4. Despite a wide range of natural resources, Africa is the least wealthy continent per capita, in part due to geographic impediments, legacies of European colonization in Africa and the Cold War, predatory/neo-colonialistic activities by Western nations and China, and undemocratic rule and deleterious policies. Despite this low concentration of wealth, recent economic expansion and the large and young population make Africa an important economic market in the broader global context.',
            'active' => true,
            'sortOrder' => 1,
        ],
        [
            'id' => 'ASIA',
            'name' => 'Asia',
            'briefDescription' => 'Asia is Earth\'s largest and most populous continent, located primarily in the Eastern and Northern Hemispheres. It shares the continental landmass of Eurasia with the continent of Europe and the continental landmass of Afro-Eurasia with both Europe and Africa.',
            'shortDescription' => 'Asia is Earth\'s largest and most populous continent, located primarily in the Eastern and Northern Hemispheres.',
            'longDescription' => 'Asia is Earth\'s largest and most populous continent, located primarily in the Eastern and Northern Hemispheres. It shares the continental landmass of Eurasia with the continent of Europe and the continental landmass of Afro-Eurasia with both Europe and Africa. Asia covers an area of 44,579,000 square kilometers, about 30% of Earth\'s total land area and 8.7% of the Earth\'s total surface area. The continent, which has long been home to the majority of the human population, was the site of many of the first civilizations. Asia is notable for not only its overall large size and population, but also dense and large settlements, as well as vast barely populated regions. Its 4.5 billion people constitute roughly 60% of the world\'s population.',
            'active' => true,
            'sortOrder' => 2,
        ],
        [
            'id' => 'CARIBBEAN',
            'name' => 'Caribbean',
            'briefDescription' => 'The Caribbean is a region of the Americas that comprises the Caribbean Sea, its surrounding coasts, and its islands. The region lies southeast of the Gulf of Mexico and of the North American mainland, east of Central America, and north of South America.',
            'shortDescription' => 'The Caribbean is a region of the Americas that comprises the Caribbean Sea, its surrounding coasts, and its islands.',
            'longDescription' => 'The Caribbean is a region of the Americas that comprises the Caribbean Sea, its surrounding coasts, and its islands. The region lies southeast of the Gulf of Mexico and of the North American mainland, east of Central America, and north of South America. Situated largely on the Caribbean Plate, the region has more than 700 islands, islets, reefs and cays. Island arcs delineate the eastern and northern edges of the Caribbean Sea: The Greater Antilles and the Lucayan Archipelago on the north and the Lesser Antilles on the south and east (which includes the Leeward Antilles).',
            'active' => true,
            'sortOrder' => 3,
        ],
        [
            'id' => 'EUROPE',
            'name' => 'Europe',
            'briefDescription' => 'Europe is a continent located entirely in the Northern Hemisphere and mostly in the Eastern Hemisphere. It comprises the westernmost peninsulas of the continental landmass of Eurasia, and is bordered by the Arctic Ocean to the north, the Atlantic Ocean to the west, the Mediterranean Sea to the south, and Asia to the east.',
            'shortDescription' => 'Europe is a continent located entirely in the Northern Hemisphere and mostly in the Eastern Hemisphere.',
            'longDescription' => 'Europe is a continent located entirely in the Northern Hemisphere and mostly in the Eastern Hemisphere. It comprises the westernmost peninsulas of the continental landmass of Eurasia, and is bordered by the Arctic Ocean to the north, the Atlantic Ocean to the west, the Mediterranean Sea to the south, and Asia to the east. Europe is commonly considered to be separated from Asia by the watershed of the Ural Mountains, the Ural River, the Caspian Sea, the Greater Caucasus, the Black Sea, and the waterways of the Turkish Straits. Although much of this border is over land, Europe is recognised as its own continent because of its great physical size and the weight of its history and traditions.',
            'active' => true,
            'sortOrder' => 4,
        ],
        [
            'id' => 'MIDDLE_EAST',
            'name' => 'Middle East',
            'briefDescription' => 'The Middle East is a transcontinental region in Afro-Eurasia which generally includes Western Asia, all of Egypt, and Turkey. The term has come into wider usage as a replacement of the term Near East beginning in the early 20th century.',
            'shortDescription' => 'The Middle East is a transcontinental region in Afro-Eurasia which generally includes Western Asia, all of Egypt, and Turkey.',
            'longDescription' => 'The Middle East is a transcontinental region in Afro-Eurasia which generally includes Western Asia, all of Egypt, and Turkey. The term has come into wider usage as a replacement of the term Near East beginning in the early 20th century. The broader concept of the "Greater Middle East" (or "Middle East and North Africa") also adds the Maghreb, Sudan, Djibouti, Somalia, Afghanistan, Pakistan, and sometimes even Transcaucasia and Central Asia into the region. The term "Middle East" has led to some confusion over its changing definitions.',
            'active' => true,
            'sortOrder' => 5,
        ],
        [
            'id' => 'OCEANIA',
            'name' => 'Oceania',
            'briefDescription' => 'Oceania is a geographic region that includes Australasia, Melanesia, Micronesia, and Polynesia. Spanning the eastern and western hemispheres, Oceania has a land area of 8,525,989 square kilometers and a population of over 41 million.',
            'shortDescription' => 'Oceania is a geographic region that includes Australasia, Melanesia, Micronesia, and Polynesia.',
            'longDescription' => 'Oceania is a geographic region that includes Australasia, Melanesia, Micronesia, and Polynesia. Spanning the eastern and western hemispheres, Oceania has a land area of 8,525,989 square kilometers and a population of over 41 million. Situated in the southeast of the Asia-Pacific region, Oceania, when compared to continental regions, is the smallest in land area and the second smallest in population after Antarctica.',
            'active' => true,
            'sortOrder' => 6,
        ],
        [
            'id' => 'NORTH_AMERICA',
            'name' => 'North America',
            'briefDescription' => 'North America is a continent entirely within the Northern Hemisphere and almost all within the Western Hemisphere. It can also be described as the northern subcontinent of a single continent, America.',
            'shortDescription' => 'North America is a continent entirely within the Northern Hemisphere and almost all within the Western Hemisphere.',
            'longDescription' => 'North America is a continent entirely within the Northern Hemisphere and almost all within the Western Hemisphere. It can also be described as the northern subcontinent of a single continent, America. It is bordered to the north by the Arctic Ocean, to the east by the Atlantic Ocean, to the southeast by South America and the Caribbean Sea, and to the west and south by the Pacific Ocean. Because it is on the North American Tectonic Plate, Greenland is included as part of North America geographically.',
            'active' => true,
            'sortOrder' => 7,
        ],
        [
            'id' => 'CENTRAL_AMERICA',
            'name' => 'Central America',
            'briefDescription' => 'Central America is a region of the Americas. It is bordered by Mexico to the north, Colombia to the southeast, the Caribbean Sea to the east and the Pacific Ocean to the west and south.',
            'shortDescription' => 'Central America is a region of the Americas.',
            'longDescription' => 'Central America is a region of the Americas. It is bordered by Mexico to the north, Colombia to the southeast, the Caribbean Sea to the east and the Pacific Ocean to the west and south. Central America consists of seven countries: Belize, Costa Rica, El Salvador, Guatemala, Honduras, Nicaragua, and Panama. The combined population of Central America is estimated to be between 41,739,000 (2009 estimate) and 42,688,190 (2012 estimate).',
            'active' => true,
            'sortOrder' => 8,
        ],
        [
            'id' => 'SOUTH_AMERICA',
            'name' => 'South America',
            'briefDescription' => 'South America is a continent entirely in the Western Hemisphere and mostly in the Southern Hemisphere, with a relatively small portion in the Northern Hemisphere. It can also be described as the southern subcontinent of the Americas.',
            'shortDescription' => 'South America is a continent entirely in the Western Hemisphere and mostly in the Southern Hemisphere.',
            'longDescription' => 'South America is a continent entirely in the Western Hemisphere and mostly in the Southern Hemisphere, with a relatively small portion in the Northern Hemisphere. It can also be described as the southern subcontinent of the Americas. The reference to South America instead of other regions (like Latin America or the Southern Cone) has increased in recent decades due to changing geopolitical dynamics (in particular, the rise of Brazil).',
            'active' => true,
            'sortOrder' => 9,
        ],
        [
            'id' => 'ANTARCTICA',
            'name' => 'Antarctica',
            'briefDescription' => 'Antarctica is Earth\'s southernmost continent. It contains the geographic South Pole and is situated in the Antarctic region of the Southern Hemisphere, almost entirely south of the Antarctic Circle, and is surrounded by the Southern Ocean.',
            'shortDescription' => 'Antarctica is Earth\'s southernmost continent.',
            'longDescription' => 'Antarctica is Earth\'s southernmost continent. It contains the geographic South Pole and is situated in the Antarctic region of the Southern Hemisphere, almost entirely south of the Antarctic Circle, and is surrounded by the Southern Ocean. At 14,200,000 square kilometers (5,500,000 square miles), it is the fifth-largest continent and nearly twice the size of Australia. It is by far the least populated continent, with around 5,000 people in the summer and around 1,000 in the winter. About 98% of Antarctica is covered by ice that averages 1.9 km (1.2 mi; 6,200 ft) in thickness, which extends to all but the McMurdo Dry Valleys and the northernmost reaches of the Antarctic Peninsula.',
            'active' => true,
            'sortOrder' => 10,
        ],
    ];

    public static function getGroups(): array
    {
        return ['region', 'country', 'user', 'place', 'all'];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        RegionFactory::createSequence(
            function () use ($faker) {
                foreach ($this->regions as $region) {
                    yield [
                        'id' => $region['id'],
                        'name' => $region['name'],
                        'briefDescription' => $region['briefDescription'],
                        'shortDescription' => $region['shortDescription'],
                        'longDescription' => $region['longDescription'],
                        'active' => $region['active'],
                        'sortOrder' => $region['sortOrder'],
                        'createdBy' => 'SYSTEM',
                        'createdAt' => $faker->dateTimeInInterval('- 1 year', '+ 0 day'),
                    ];
                }
            }
        );
    }
}
