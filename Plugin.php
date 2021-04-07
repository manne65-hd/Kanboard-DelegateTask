<?php

namespace Kanboard\Plugin\DelegateTask;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;



class Plugin extends Base
{
    public function initialize()
    {
        $this->template->setTemplateOverride('board/table_column', 'DelegateTask:board/table_column');
    }

    public function onStartup()
    {
        // load Translation
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__ . '/Locale');
    }

    public function getPluginName()
    {
        return 'DelegateTask';
    }

    public function getPluginDescription()
    {
        return t('Allows project-viewers to delegate a task into the first column of the project');
    }

    public function getPluginAuthor()
    {
        return 'Manfred Hoffmann';
    }

    public function getPluginVersion()
    {
        return '0.0.1';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/manne65-hd/DelegateTask';
    }
}
