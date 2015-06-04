<?php
namespace craft\plugins\entrycount\controllers;

use Craft;
use craft\app\web\Controller;
use craft\plugins\entrycount\services\EntryCountService;

/**
 * Entry Count Controller
 */
class EntryCountController extends Controller
{
    /**
     * Reset count
     */
    public function actionReset()
    {
        $entryId = craft()->request->getRequiredParam('entryId');

        EntryCountService::reset($entryId);

        Craft::$app->getSession()->setNotice(Craft::t('Entry count reset.'));

        $this->redirect('entrycount');
    }

}
