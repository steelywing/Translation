<?php
/**
 * @author      Wing Leong <steely.wing@gmail.com>
 * @copyright   2015 Wing Leong
 * @license     MIT public license
 */

namespace SteelyWing\Translation\Dictionary;

interface DictionaryInterface
{
    public function load($resource);
    public function get($locale, $key);
}
