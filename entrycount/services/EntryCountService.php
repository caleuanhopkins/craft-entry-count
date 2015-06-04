<?php
namespace craft\plugins\entrycount\services;

use Craft;
use craft\app\base\Component;
use craft\app\elements\Entry;
use craft\plugins\entrycount\records\EntryCountRecord;
use craft\plugins\entrycount\models\EntryCountModel;

/**
 * Entry Count Service
 */
class EntryCountService extends Component
{
    /**
     * Returns count
     *
	 * @param int $entryId
	 *
	 * @return EntryCountModel
     */
    public static function getCount($entryId)
    {
        // create new model
        $entryCountModel = new EntryCountModel();

        // get record from DB
        $entryCountRecord = EntryCountRecord::find()
            ->where(['entryId' => $entryId])
            ->one();

        if ($entryCountRecord)
        {
            // populate model from record
            static::populateModel($entryCountModel, $entryCountRecord);
        }

        return $entryCountModel;
    }

    /**
     * Returns counted entries
     *
     * @return ElementCriteriaModel
     */
    public static function getEntries()
    {
        // get all records from DB ordered by count descending
        $entryCountRecords = EntryCountRecord::find()
            ->orderBy('count desc')
            ->all();

        // get entry ids from records
        $entryIds = array();

        foreach ($entryCountRecords as $entryCountRecord)
        {
            $entryIds[] = $entryCountRecord->entryId;
        }

        // create criteria for entry element type
        $criteria = Entry::find();

        // filter by entry ids
        $criteria->id = $entryIds;

        // enable fixed order
        $criteria->fixedOrder = true;

        return $criteria;
    }

    /**
     * Increment count
     *
	 * @param int $entryId
     */
    public static function increment($entryId)
    {
        // check if action should be ignored
        if (EntryCountService::_ignoreAction())
        {
            return;
        }

        // get record from DB
        $entryCountRecord = EntryCountRecord::find()
            ->where(['entryId' => $entryId])
            ->one();

        // if exists then increment count
        if ($entryCountRecord)
        {
            $entryCountRecord->setAttribute('count', $entryCountRecord->count + 1);
        }

        // otherwise create a new record
        else
        {
            $entryCountRecord = new EntryCountRecord;
            $entryCountRecord->setAttribute('entryId', $entryId);
            $entryCountRecord->setAttribute('count', 1);
        }

        // save record in DB
        $entryCountRecord->save();
    }

    /**
     * Reset count
     *
	 * @param int $entryId
     */
    public static function reset($entryId)
    {
        // get record from DB
        $entryCountRecord = EntryCountRecord::find()
            ->where(['entryId' => $entryId])
            ->one();

        // if record exists then delete
        if ($entryCountRecord)
        {
            // delete record from DB
            $entryCountRecord->delete();
        }

        // log reset
        EntryCountPlugin::log(
            'Entry count with entry ID '.$entryId.' reset by '.Craft::$app->getUser()->username,
            LogLevel::Info,
            true
        );

        // fire an onResetCount event
        $this->onResetCount(new Event($this, array('entryId' => $entryId)));
    }

    /**
     * On reset count
     *
     * @param Event $event
     */
    public static function onResetCount($event)
    {
        $this->raiseEvent('onResetCount', $event);
    }

    // Helper methods
    // =========================================================================

    /**
     * Check if action should be ignored
     */
    private static function _ignoreAction()
    {
        // get plugin settings
        $settings = Craft::$app->plugins->getPlugin('entrycount')->getSettings();

        // check if logged in users should be ignored based on settings
        if ($settings->ignoreLoggedInUsers AND Craft::$app->getUser()->isLoggedIn())
        {
            return true;
        }

        // check if ip address should be ignored based on settings
        if ($settings->ignoreIpAddresses AND in_array(Craft::$app->request->getUserIP(), explode("\n", $settings->ignoreIpAddresses)))
        {
            return true;
        }
    }
}
