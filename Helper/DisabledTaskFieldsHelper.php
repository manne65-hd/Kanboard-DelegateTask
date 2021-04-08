<?php

namespace Kanboard\Plugin\DelegateTask\Helper;

use Kanboard\Helper\TaskHelper;
use Kanboard\Core\Base;

/**
 * Task helpers
 *
 * @package helper
 * @author  Frederic Guillot
 */
class DisabledTaskFieldsHelper extends TaskHelper
{

    public function renderDisabledDescriptionField(array $values, array $errors)
    {
        return $this->helper->form->textEditor('description', $values, $errors, array('tabindex' => 2, 'aria-label' => t('Description')));
    }

    public function renderDisabledDescriptionTemplateDropdown($projectId)
    {
        $templates = $this->predefinedTaskDescriptionModel->getAll($projectId);

        if (! empty($templates)) {
            $html = '<div class="dropdown dropdown-smaller">';
            $html .= '<a href="#" class="dropdown-menu dropdown-menu-link-icon"><i class="fa fa-floppy-o fa-fw" aria-hidden="true"></i>'.t('Template for the task description').' <i class="fa fa-caret-down" aria-hidden="true"></i></a>';
            $html .= '<ul>';

            foreach ($templates as  $template) {
                $html .= '<li>';
                $html .= '<a href="#" data-template-target="textarea[name=description]" data-template="'.$this->helper->text->e($template['description']).'" class="js-template">';
                $html .= $this->helper->text->e($template['title']);
                $html .= '</a>';
                $html .= '</li>';
            }

            $html .= '</ul></div>';
            return $html;
        }

        return '';
    }

    public function renderDisabledTagField(array $project, array $tags = array())
    {
        $options = $this->tagModel->getAssignableList($project['id'], $project['enable_global_tags']);

        $html = $this->helper->form->label(t('Tags'), 'tags[]');
        $html .= '<input type="hidden" name="tags[]" value="">';
        $html .= '<select name="tags[]" id="form-tags" class="tag-autocomplete" multiple tabindex="3">';

        foreach ($options as $tag) {
            $html .= sprintf(
                '<option value="%s" %s>%s</option>',
                $this->helper->text->e($tag),
                in_array($tag, $tags) ? 'selected="selected"' : '',
                $this->helper->text->e($tag)
            );
        }

        $html .= '</select>';

        return $html;
    }

    public function renderDisabledColorField(array $values)
    {
        $html = $this->helper->form->colorSelect('color_id', $values);
        return $html;
    }

    public function renderDisabledAssigneeField(array $users, array $values, array $errors = array(), array $attributes = array())
    {
        if (isset($values['project_id']) && ! $this->helper->projectRole->canChangeAssignee($values)) {
            return '';
        }

        $attributes = array_merge(array('tabindex="5"'), $attributes);

        $html = $this->helper->form->label(t('Assignee'), 'owner_id');
        $html .= $this->helper->form->selectDisabled('owner_id', $users, $values, $errors, $attributes);
        $html .= '&nbsp;';
        $html .= '<small>';
        $html .= '<a href="#" class="assign-me" data-target-id="form-owner_id" data-current-id="'.$this->userSession->getId().'" title="'.t('Assign to me').'" aria-label="'.t('Assign to me').'">'.t('Me').'</a>';
        $html .= '</small>';

        return $html;
    }

    public function renderDisabledCategoryField(array $categories, array $values, array $errors = array(), array $attributes = array(), $allow_one_item = false)
    {
        $attributes = array_merge(array('tabindex="6"'), $attributes);
        $html = '';

        if (! (! $allow_one_item && count($categories) === 1 && key($categories) == 0)) {
            $html .= $this->helper->form->label(t('Category'), 'category_id');
            $html .= $this->helper->form->selectDisabled('category_id', $categories, $values, $errors, $attributes);
        }

        return $html;
    }

    public function renderDisabledSwimlaneField(array $swimlanes, array $values, array $errors = array(), array $attributes = array())
    {
        $attributes = array_merge(array('tabindex="7"'), $attributes);
        $html = '';

        if (count($swimlanes) > 1) {
            $html .= $this->helper->form->label(t('Swimlane'), 'swimlane_id');
            $html .= $this->helper->form->selectDisabled('swimlane_id', $swimlanes, $values, $errors, $attributes);
        }

        return $html;
    }

    public function renderDisabledColumnField(array $columns, array $values, array $errors = array(), array $attributes = array())
    {
        $attributes = array_merge(array('tabindex="8"'), $attributes);

        $html = $this->helper->form->label(t('Column'), 'column_id');
        $html .= $this->helper->DisabledFormFieldsHelper->selectDisabled('column_id', $columns, $values, $errors, $attributes);

        return $html;
    }

    public function renderDisabledPriorityField(array $project, array $values)
    {
        $range = range($project['priority_start'], $project['priority_end']);
        $options = array_combine($range, $range);
        $values += array('priority' => $project['priority_default']);

        $html = $this->helper->form->label(t('Priority'), 'priority');
        $html .= $this->helper->form->select('priority', $options, $values, array(), array('tabindex="9"'));

        return $html;
    }

    public function renderDisabledScoreField(array $values, array $errors = array(), array $attributes = array())
    {
        $attributes = array_merge(array('tabindex="14"'), $attributes);

        $html = $this->helper->form->label(t('Complexity'), 'score');
        $html .= $this->helper->form->number('score', $values, $errors, $attributes);

        return $html;
    }

    public function renderDisabledReferenceField(array $values, array $errors = array(), array $attributes = array())
    {
        $attributes = array_merge(array('tabindex="15"'), $attributes);

        $html = $this->helper->form->label(t('Reference'), 'reference');
        $html .= $this->helper->form->text('reference', $values, $errors, $attributes, 'form-input-small');

        return $html;
    }

    public function renderDisabledTimeEstimatedField(array $values, array $errors = array(), array $attributes = array())
    {
        $attributes = array_merge(array('tabindex="12"'), $attributes);

        $html = $this->helper->form->label(t('Original estimate'), 'time_estimated');
        $html .= $this->helper->form->numeric('time_estimated', $values, $errors, $attributes);
        $html .= ' '.t('hours');

        return $html;
    }

    public function renderDisabledTimeSpentField(array $values, array $errors = array(), array $attributes = array())
    {
        $attributes = array_merge(array('tabindex="13"'), $attributes);

        $html = $this->helper->form->label(t('Time spent'), 'time_spent');
        $html .= $this->helper->form->numeric('time_spent', $values, $errors, $attributes);
        $html .= ' '.t('hours');

        return $html;
    }

    public function renderDisabledStartDateField(array $values, array $errors = array(), array $attributes = array())
    {
        $attributes = array_merge(array('tabindex="11"'), $attributes);
        return $this->helper->form->datetime(t('Start Date'), 'date_started', $values, $errors, $attributes);
    }

    public function renderDisabledDueDateField(array $values, array $errors = array(), array $attributes = array())
    {
        $attributes = array_merge(array('tabindex="10"'), $attributes);
        return $this->helper->form->datetime(t('Due Date'), 'date_due', $values, $errors, $attributes);
    }

    public function renderDisabledPriority($priority)
    {
        $html = '<span class="task-priority" title="'.t('Task priority').'">';
        $html .= '<span class="ui-helper-hidden-accessible">'.t('Task priority').' </span>';
        $html .= $this->helper->text->e($priority >= 0 ? 'P'.$priority : '-P'.abs($priority));
        $html .= '</span>';

        return $html;
    }

    public function renderDisabledReference(array $task)
    {
        if (! empty($task['reference'])) {
            $reference = $this->helper->text->e($task['reference']);

            if (filter_var($task['reference'], FILTER_VALIDATE_URL) !== false) {
                return sprintf('<a href="%s" target=_blank">%s</a>', $reference, $reference);
            }

            return $reference;
        }

        return '';
    }
}
