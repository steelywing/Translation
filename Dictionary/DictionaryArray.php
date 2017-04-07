<?php
/**
 * @author      Wing Leong <steely.wing@gmail.com>
 * @copyright   2015 Wing Leong
 * @license     MIT public license
 */

namespace SteelyWing\Translation\Dictionary;

class DictionaryArray implements DictionaryInterface
{
    private $dictionary;

    public function __construct($resource = null)
    {
        $this->dictionary = [];

        if ($resource !== null) {
            $this->load($resource);
        }
    }

    /**
     * @param array $resource Path to CSV file
     */
    public function load($resource)
    {
        foreach ($resource as $locale => $dictionary) {
            if (isset($this->dictionary[$locale])) {
                array_merge($this->dictionary[$locale], $dictionary);
            } else {
                $this->dictionary[$locale] = $dictionary;
            }
        }
    }

    /**
     * @param string $key Translation Key
     * @param string $locale Locale
     * @return string Translated string, null if not found
     */
    public function get($key, $locale)
    {
        if (!isset($this->dictionary[$locale][$key])) {
            return null;
        }

        return $this->dictionary[$locale][$key];
    }
}
