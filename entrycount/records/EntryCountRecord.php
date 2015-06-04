<?php
namespace craft\plugins\entrycount\records;

use craft\app\db\ActiveRecord;

/**
 * Entry Count Record
 */
class EntryCountRecord extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%entrycount}}';
    }

    public function __toString()
    {
        return (string)$this->count;
    }
}
