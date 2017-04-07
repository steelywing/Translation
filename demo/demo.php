<?php

require_once '../vendor/autoload.php';

use SteelyWing\Translation\Dictionary\DictionaryArray;
use SteelyWing\Translation\Dictionary\DictionaryCSV;
use SteelyWing\Translation\Translator;

$translator = new Translator();

// Use array as dictionary
//$dict = new DictionaryArray(include('dictionary.php'));

// Use CSV as dictionary
$dict = new DictionaryCSV('dictionary.csv');

$translator->addDictionary($dict);

$translator->setLocale('en');

// Hello World!
echo $translator->translate('hello world');

// I love programming!
echo $translator->translate('i love programming');

// 世界，你好！
echo $translator->translate('hello world', 'zh_tw');

// Echo empty, no fallback locale set
echo $translator->translate('english only', 'zh_tw');

$translator->setFallbackLocale('en');
// Fallback to "en", echo "English Only"
echo $translator->translate('english only', 'zh_tw');
