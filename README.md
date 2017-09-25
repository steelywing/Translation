# Translation
PHP Translator, Simple, Lightweight

## Installation
### Composer
Run `composer require steelywing/translation`

### Manually
Clone this repo, run `composer dump-autoload` on root directory to 
generate `autoload.php`.

## Feature
- Support CSV, and PHP Array
- Support fallback language

```php
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

// 我喜爱编程！
echo $translator->translate('i love programming', [], 'zh_cn');
echo "\n<br>\n";

// 世界，你好！
echo $translator->translate('hello world', [], 'zh_tw');
echo "\n<br>\n";

// Echo empty, no fallback locale set
echo $translator->translate('english only', [], 'zh_tw');
echo "\n<br>\n";

// Return the key if key not found
$translator->setFallbackToKey(true);
echo $translator->translate('english only', [], 'zh_tw');
echo "\n<br>\n";

// Fallback to "en", echo "English Only"
$translator->setFallback('en');
echo $translator->translate('english only', [], 'zh_tw');
echo "\n<br>\n";
```

## Chinese conversion 繁簡轉換
```php
use SteelyWing\Translation\Dictionary\DictionaryChinese;

$chinese = new DictionaryChinese($dict);
$translator->addDictionary($chinese);

// Auto translate "繁體轉簡體中文測試" to "繁体转简体中文測試"
echo $translator->translate('simplified chinese testing', [], 'zh_cn');
echo "\n<br>\n";

// Auto translate "简体转繁体中文测试" to "簡體轉繁體中文測試"
echo $translator->translate('traditional chinese testing', [], 'zh_tw');
echo "\n<br>\n";
```
