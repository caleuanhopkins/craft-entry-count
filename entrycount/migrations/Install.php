<?php
namespace craft\plugins\entrycount\migrations;

use craft\app\db\InstallMigration;

/**
 * Entry Count Install
 */
class Install extends InstallMigration
{
    protected function defineSchema()
    {
        return [
            '{{%entrycount}}' => [
                'columns' => [
                    'entryId' => 'int NOT NULL',
                    'count' => 'int NOT NULL',
                ],
                'foreignKeys' => [
                    ['entryId', '{{%entries}}', 'id', 'CASCADE', null],
                ],
				'indexes' => [
                    ['entryId', false],
                ],
            ],
        ];
    }
}