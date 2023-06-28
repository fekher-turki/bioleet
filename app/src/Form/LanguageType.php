<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LanguageType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => [
                'Afrikaans' => 'af',
                'Arabic' => 'ar',
                'Aramaic' => 'arc',
                'Armenian' => 'hy',
                'Bengali' => 'bn',
                'Berber' => 'ber',
                'Bosnian' => 'bs',
                'Brazilian' => 'pt_BR',
                'Bulgarian' => 'bg',
                'Burmese' => 'my',
                'Cantonese' => 'zh-yue',
                'Catalan' => 'ca',
                'Corsican' => 'co',
                'Creole' => 'ht',
                'Croatian' => 'hr',
                'Cypriot' => 'el',
                'Czech' => 'cs',
                'Danish' => 'da',
                'Dutch' => 'nl',
                'Egyptian' => 'egy',
                'English' => 'en',
                'Esperanto' => 'eo',
                'Estonian' => 'et',
                'Finn' => 'fi',
                'Finnish' => 'fi',
                'Flemish' => 'nl_BE',
                'French' => 'fr',
                'Georgian' => 'ka',
                'German' => 'de',
                'Greek' => 'el',
                'Gypsy' => 'rom',
                'Hawaiian' => 'haw',
                'Hebrew' => 'he',
                'Hindi' => 'hi',
                'Hungarian' => 'hu',
                'Icelandic' => 'is',
                'Indonesian' => 'id',
                'Inuit' => 'iu',
                'Irish' => 'ga',
                'Italian' => 'it',
                'Japanese' => 'ja',
                'Javanese' => 'jv',
                'Korean' => 'ko',
                'Latin' => 'la',
                'Lithuanian' => 'lt',
                'Malay' => 'ms',
                'Malayalam' => 'ml',
                'Mandarin' => 'zh',
                'Nepalese' => 'ne',
                'Norwegian' => 'no',
                'Panjabi' => 'pa',
                'Polish' => 'pl',
                'Portuguese' => 'pt',
                'Romanian' => 'ro',
                'Russian' => 'ru',
                'Sanskrit' => 'sa',
                'Scottish' => 'gd',
                'Serbian' => 'sr',
                'Sign language' => 'sgn',
                'Slovak' => 'sk',
                'Slovene' => 'sl',
                'Spanish' => 'es',
                'Swedish' => 'sv',
                'Tagalog' => 'tl',
                'Tahitian' => 'ty',
                'Tamil' => 'ta',
                'Telugu' => 'te',
                'Thai' => 'th',
                'Tibetan' => 'bo',
                'Turkish' => 'tr',
                'Ukrainian' => 'uk',
                'Vietnamese' => 'vi',
                'Welsh' => 'cy',
                'Wu' => 'wuu',
            ],
            'multiple' => true,
            'expanded' => false,
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
