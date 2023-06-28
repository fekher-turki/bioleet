<?php

namespace App\Twig;

use Symfony\Component\Intl\Languages;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class LanguageExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('language_name', [$this, 'getLanguageName']),
        ];
    }

    public function getLanguageName($languageCode)
    {
        return Languages::getName($languageCode);
    }
}
