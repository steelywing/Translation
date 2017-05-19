<?php

require_once '../vendor/autoload.php';

use SteelyWing\Translation\Dictionary\DictionaryArray;
use SteelyWing\Translation\Dictionary\DictionaryCsv;
use SteelyWing\Translation\Translator;

$translator = new Translator();

// Use array as dictionary
//$dict = new DictionaryArray(include('dictionary.php'));

// Use CSV as dictionary
$dict = new DictionaryCsv('dictionary.csv');

$translator->addDictionary($dict);

$translator->locale = 'en';

// Hello World!
echo $translator->translate('hello world');
echo "\n<br>\n";

// Hello, Steely Wing!
echo $translator->translate('hello', [':user' => 'Steely Wing']);
echo "\n<br>\n";

// 你好，Steely Wing！
echo $translator->translate('hello', [':user' => 'Steely Wing'], 'zh_tw');
echo "\n<br>\n";

// I love programming!
echo $translator->translate('i love programming');
echo "\n<br>\n";

// 世界，你好！
echo $translator->translate('hello world', 'zh_tw');
echo "\n<br>\n";

// Echo empty, no fallback locale set
echo $translator->translate('english only', 'zh_tw');
echo "\n<br>\n";

// Return the key if key not found
$translator->fallbackToKey = true;
echo $translator->translate('english only', 'zh_tw');
echo "\n<br>\n";

// Fallback to "en", echo "English Only"
$translator->fallbackLocale = 'en';
echo $translator->translate('english only', 'zh_tw');
echo "\n<br>\n";
