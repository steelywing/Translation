<?php
/**
 * @author      Wing Leong <steely.wing@gmail.com>
 * @copyright   2015 Wing Leong
 * @license     MIT public license
 */

namespace SteelyWing\Translation\Dictionary;

class DictionaryCSV implements DictionaryInterface
{
    private $delimiter;
    private $enclosure;
    private $escape;
    private $dictionary;

    public function __construct($resource = null)
    {
        $this->dictionary = [];
        $this->setCsvControl();

        if ($resource !== null) {
            $this->load($resource);
        }
    }

    /**
     * @param string $resource Path to CSV file
     */
    public function load($resource)
    {
        $file = new \SplFileObject($resource);
        $file->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::READ_AHEAD
        );
        $file->setCsvControl($this->delimiter, $this->enclosure, $this->escape);

        $locales = $file->current();

        // Remove key column
        array_shift($locales);
        $file->next();

        foreach ($file as $row) {
            if (count($row) > 1) {
                $key = array_shift($row);
                foreach ($row as $i => $message) {
                    if (strlen($message) > 0) {
                        $this->dictionary[$locales[$i]][$key] = $message;
                    }
                }
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

    /**
     * Sets the delimiter, enclosure, and escape character for CSV.
     *
     * @param string $delimiter delimiter character
     * @param string $enclosure enclosure character
     * @param string $escape    escape character
     */
    public function setCsvControl($delimiter = ',', $enclosure = '"', $escape = '\\')
    {
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->escape = $escape;
    }
}
