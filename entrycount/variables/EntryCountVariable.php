<?php
namespace craft\plugins\entrycount\variables;

use craft\plugins\entrycount\services\EntryCountService;

/**
 * Entry Count Variable
 */
class EntryCountVariable
{
    /**
     * Returns count
     *
	 * @param int $entryId
	 *
	 * @return EntryCountModel
     */
    public function getCount($entryId)
    {
        return EntryCountService::getCount($entryId);
    }

    /**
     * Returns counted entries
     *
     * @return ElementCriteriaModel
     */
    public function getEntries()
    {
        return EntryCountService::getEntries();
    }

    /**
     * Increment count
     *
	 * @param int $entryId
     */
    public function increment($entryId)
    {
        EntryCountService::increment($entryId);
    }

}
