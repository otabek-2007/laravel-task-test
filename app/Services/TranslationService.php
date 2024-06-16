<?php
namespace App\Services;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationService
{
    protected $translator;

    public function __construct()
    {
        $this->translator = new GoogleTranslate();
    }

    public function translate($text, $targetLanguage, $sourceLanguage = 'en')
    {
        $this->translator->setSource($sourceLanguage);
        $this->translator->setTarget($targetLanguage);

        return $this->translator->translate($text);
    }
}
