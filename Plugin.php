<?php

namespace Kanboard\Plugin\DelegateTask;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Core\Security\Role;

use Kanboard\Model\TaskModel;


class Plugin extends Base
{
    public function initialize()
    {
        // Set relevant rights, so that project-viewers can create a task
        $this->projectAccessMap->add('TaskCreationController', array('show','save'), Role::PROJECT_VIEWER);
        $this->projectAccessMap->add('TaskMailController', array('create'), Role::PROJECT_VIEWER);
        //Helpers
        $this->helper->register('DelegateTaskHelper', '\Kanboard\Plugin\DelegateTask\Helper\DelegateTaskHelper');

        // template overrides
        $this->template->setTemplateOverride('board/table_column', 'DelegateTask:board/table_column');
        $this->template->setTemplateOverride('project_header/dropdown', 'DelegateTask:project_header/dropdown');

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
