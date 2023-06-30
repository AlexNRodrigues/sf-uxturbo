<?php

namespace App\Twig\Components;

use Symfony\Component\Form\FormErrorIterator;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('formError')]
final class FormError
{
    public FormErrorIterator $formError;
}
