<?php

namespace App\Twig;

use Symfony\Component\Intl\Countries;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CountryExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('country_name', [$this, 'getCountryName']),
        ];
    }

    public function getCountryName($countryCode)
    {
        return Countries::getName($countryCode);
    }
}
