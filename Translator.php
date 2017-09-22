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
    private $dictionaries = [];
    public $locale;
    public $fallbackLocale;
    public $fallbackToKey;

    public function __construct($locale = null, $fallbackLocale = null)
    {
        $this->locale = $locale;
        $this->fallbackLocale = $fallbackLocale;
    }

    /**
     * @param DictionaryInterface $dictionary
     */
    public function addDictionary(DictionaryInterface $dictionary)
    {
        $this->dictionaries[] = $dictionary;
    }

    /**
     * @param string $string
     * @param array $args
     * @return string
     */
    private static function replace($string, array $args)
    {
        return str_replace(
            array_keys($args),
            array_values($args),
            $string
        );
    }

    /**
     * Get translated string
     *
     * @param string $key Translation key
     * @param mixed $args Replacement list, set to locale if this is string
     * @param string $locale
     * @return string Translated string, null if not found
     */
    public function translate($key, array $args = [], $locale = null)
    {
        if ($locale === null) {
            $locale = $this->locale;
        }

        foreach ($this->dictionaries as $dictionary) {
            $result = $dictionary->get($key, $locale);
            if ($result !== null) {
                return self::replace($result, $args);
            }
        }

        // Fallback

        if ($this->fallbackLocale !== null &&
            $this->fallbackLocale !== $locale
        ) {
            $result = $this->translate($key, $args, $this->fallbackLocale);
            if ($result !== null) {
                return $result;
            }
        }

        if ($this->fallbackToKey) {
            return $key;
        }

        return null;
    }
}
