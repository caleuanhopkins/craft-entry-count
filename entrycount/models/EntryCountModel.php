<?php
namespace craft\plugins\entrycount\models;

use craft\app\base\Model;

/**
 * Entry Count Model
 */
class EntryCountModel extends Model
{
    public $id;
    public $entryId;
    public $count;
    public $dateCreated;
    public $dateUpdated;

    /**
     * Define what is returned when model is converted to string
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->count;
    }

    public function rules()
    {
        return [
            ['id', 'int'],
            ['entryId', 'int'],
            ['count', 'int', 'default' => 0],
            ['dateCreated', 'datetime'],
            ['dateUpdated', 'datetime'],
        ];
    }
}
