<?php

namespace Kanboard\Plugin\DelegateTask\Helper;

use Kanboard\Helper\TaskHelper;
use Kanboard\Core\Base;


/**
 * Task helpers
 *
 * @package helper
 * @author  Manfred Hoffmann
 */
class DelegateTaskHelper extends TaskHelper
{

    public function getNewBoardDelegateTaskButton(array $swimlane, array $column)
    {
        $html = '<div class="board-add-icon">';
        $html .= $this->helper->modal->largeIcon(
            'share-square-o',
            t('Delegate a task to this project'),
            'TaskCreationController',
            'show', array(
                'project_id'  => $column['project_id'],
                'column_id'   => $column['id'],
                'swimlane_id' => $swimlane['id'],
            )
        );
        $html .= '</div>';

        return $html;
    }
}
