<?php
namespace craft\plugins\entrycount;

use Craft;
use craft\plugins\entrycount\models\Settings;

/**
 * Entry Count Plugin
 */
class Plugin extends \craft\app\base\Plugin
{
    public function init()
    {
        Craft::$app->createController('EntryCountController');
    }

    protected function createSettingsModel()
    {
        return new Settings();
    }

    protected function getSettingsHtml()
    {
        return Craft::$app->view->renderTemplate('entrycount/settings', [
            'settings' => $this->getSettings()
        ]);
    }

    public static function hasCpSection()
    {
        return true;
    }

    public function getVariableDefinition()
    {
        return 'craft\plugins\entrycount\variables\EntryCountVariable';
    }

	// Hooks
	// =========================================================================

    public function modifyEntryTableAttributes(&$attributes, $source)
    {
        if ($this->getSettings()->showCountOnEntryIndex)
        {
            $attributes['count'] = Craft::t('Count');
        }
    }

    public function getEntryTableAttributeHtml($entry, $attribute)
    {
        if ($this->getSettings()->showCountOnEntryIndex AND $attribute == 'count')
        {
            return craft()->entryCount->getCount($entry->id)->count;
        }
    }

    public function addEntryActions($source)
    {
        if ($this->getSettings()->showCountOnEntryIndex)
        {
            return array('EntryCount_Reset');
        }
    }
}
