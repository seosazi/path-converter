<?php

namespace unit;

use PHPUnit\Framework\TestCase;
use seosazi\PathConverter\ConvertToAbsolutePath;
use seosazi\PathConverter\RemovePathWithPointPointSlash;

class RemovePathWithPointPointSlashTest extends TestCase
{
    private $removePathWithPointPointSlash;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->removePathWithPointPointSlash = new RemovePathWithPointPointSlash(
            new ConvertToAbsolutePath('https://www.jquery-az.com/html/demo.php'),
            '../strawberries.jpg'
        );
    }

    /**
     * @dataProvider dataForCompute
     * @param $pagePath
     * @param $baseTag
     * @param $path
     * @param $result
     * @throws \Exception
     */
    public function testCompute($pagePath, $baseTag, $path, $result)
    {
        $address = new ConvertToAbsolutePath($pagePath);
        if (isset($baseTag)) {
            $address->setBaseTag($baseTag);
        }

        $removeAdditional = new RemovePathWithPointPointSlash($address, $path);

        $this->assertSame($removeAdditional->compute(), $result);
    }

    public function dataForCompute()
    {
        return [
            'once ../'  => [
                'https://www.jquery-az.com/html/demo.php?ex=151.0_4',
                null,
                '../strawberries.jpg',
                'https://www.jquery-az.com/strawberries.jpg'
            ],
            'without ../'  => [
                'https://www.jquery-az.com/html/demo.php?ex=151.0_5',
                null,
                'strawberries.jpg',
                'https://www.jquery-az.com/html/strawberries.jpg'
            ],
            'twice ../../'  => [
                'https://www.jquery-az.com/html/test/demo.php?ex=151.0_5',
                null,
                '../../banana.jpg',
                'https://www.jquery-az.com/banana.jpg'
            ],
            'twice ../../ with base tag'  => [
                'https://www.jquery-az.com/html/test/demo.php?ex=151.0_5',
                'https://www.jquery-az.com/html/test/demo.php',
                '../../banana.jpg',
                'https://www.jquery-az.com/banana.jpg'
            ]

        ];
    }

    public function testGetPath()
    {
        $this->removePathWithPointPointSlash->setPath('../strawberries.jpg');
        $this->assertEquals($this->removePathWithPointPointSlash->getPath(), '../strawberries.jpg');
    }

    public function testGetScheme()
    {
        $this->removePathWithPointPointSlash->setScheme('https');
        $this->assertEquals($this->removePathWithPointPointSlash->getScheme(), 'https');
    }

    public function testGetDomain()
    {
        $this->removePathWithPointPointSlash->setDomain('www.jquery-az.com');
        $this->assertEquals($this->removePathWithPointPointSlash->getDomain(), 'www.jquery-az.com');
    }

    public function testGetStarterPath()
    {
        $this->removePathWithPointPointSlash->setStarterPath('https://www.jquery-az.com/');
        $this->assertEquals($this->removePathWithPointPointSlash->getStarterPath(), 'https://www.jquery-az.com/');
    }
}
