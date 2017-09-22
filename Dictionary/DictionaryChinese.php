<?php
/**
 * @author      Wing Leong <steely.wing@gmail.com>
 * @copyright   2015 Wing Leong
 * @license     MIT public license
 */

namespace SteelyWing\Translation\Dictionary;

use SteelyWing\Chinese\Chinese;

class DictionaryChinese implements DictionaryInterface
{
    const CHS = 'zh_cn';
    const CHT = 'zh_tw';

    private $dictionary = null;
    private $chineseDict = null;

    public function __construct($resource = null)
    {
        if ($resource !== null) {
            $this->load($resource);
        }

        $this->chineseDict = new Chinese();
    }

    /**
     * @param array $resource Parent dictionary
     */
    public function load($resource)
    {
        if (!($resource instanceof DictionaryInterface)) {
            throw new \InvalidArgumentException(
                '$resource should be ' . DictionaryInterface::class
            );
        }
        $this->dictionary = $resource;
    }

    /**
     * @param string $key Translation Key
     * @param string $locale Locale
     * @return string Translated string, null if not found
     */
    public function get($key, $locale)
    {
        if ($this->dictionary === null) {
            return null;
        }

        $result = $this->dictionary->get($key, $locale);
        if ($result !== null) {
            return $result;
        }

        $sourceLocale = null;
        $targetLocale = null;

        if ($locale === self::CHS) {
            $sourceLocale = self::CHT;
            $targetLocale = Chinese::CHS;
        }

        if ($locale === self::CHT) {
            $sourceLocale = self::CHS;
            $targetLocale = Chinese::CHT;
        }

        if ($sourceLocale !== null) {
            $result = $this->dictionary->get($key, $sourceLocale);
            if ($result !== null) {
                return $this->chineseDict->to($targetLocale, $result);
            }
        }

        return null;
    }
}
