<?php
namespace Craft;

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
    public function getCount($entryId, $type)
    {
        return craft()->entryCount->getCount($entryId, $type);
    }

    /**
     * Returns counted entries
     *
     * @return ElementCriteriaModel
     */
    public function getEntries()
    {
        return craft()->entryCount->getEntries();
    }

    /**
     * Increment count
     *
	 * @param int $entryId
     */
    public function increment($entryId, $type)
    {
        craft()->entryCount->increment($entryId, $type);
    }

}
