<?php
namespace craft\plugins\entrycount\models;

use craft\app\base\Model;

/**
 * Entry Count Settings
 */
class Settings extends Model
{
    public $showCountOnEntryIndex;
    public $ignoreLoggedInUsers;
    public $ignoreIpAddresses;

    public function rules()
    {
        return [
            ['showCountOnEntryIndex', 'bool', 'default' => 0],
            ['ignoreLoggedInUsers', 'bool', 'default' => 0],
            ['ignoreIpAddresses', 'mixed', 'default' => ''],
        ];
    }
}
