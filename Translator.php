<?php
/**
 * @author      Wing Leong <steely.wing@gmail.com>
 * @copyright   2015 Wing Leong
 * @license     MIT public license
 */

namespace SteelyWing\Translation;

use SteelyWing\Translation\Dictionary\DictionaryInterface;

class Translator
{
    protected $dictionaries = [];
    protected $locale;
    protected $fallbackLocale;

    public function __construct($locale = null, $fallbackLocale = null)
    {
//        $locale = isset($_COOKIE['locale']) ? $_COOKIE['locale'] : $defaultLocale;
        $this->setLocale($locale);
        $this->setFallbackLocale($fallbackLocale);
    }

    /**
     * @param DictionaryInterface $dictionary
     */
    public function addDictionary(DictionaryInterface $dictionary)
    {
        $this->dictionaries[] = $dictionary;
    }

    /**
     * Get translated string
     *
     * @param string $key Translation key
     * @param string $locale
     *
     * @return string Translated string, null if not found
     */
    public function translate($key, $locale = null)
    {
        if ($locale === null) {
            $locale = $this->locale;
        }

        foreach ($this->dictionaries as $dictionary) {
            $message = $dictionary->get($key, $locale);
            if ($message !== null) {
                return $message;
            }
        }

        // Fallback Locale
        if ($this->fallbackLocale !== null && $this->fallbackLocale !== $locale) {
            return $this->translate($key, $this->fallbackLocale);
        }

        return null;
    }

    public function getLocale()
    {
        return $this->locale;
    }
    
    public function setLocale($locale)
    {
        $this->locale = $locale;

        // Save locale to cookie
        /*if (!headers_sent()) {
            setcookie('locale', $this->locale, time() + 60*60*24*30, '/');
        }*/
    }

    /**
     * @return mixed
     */
    public function getFallbackLocale()
    {
        return $this->fallbackLocale;
    }

    /**
     * @param $locale
     */
    public function setFallbackLocale($locale = null)
    {
        $this->fallbackLocale = $locale;
    }
}
