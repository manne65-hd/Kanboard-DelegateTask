<div class="page-header">
    <h2><?= $this->text->e($project['name']) ?> &gt; <?= t('New task') ?></h2>
</div>
<form method="post" action="<?= $this->url->href('TaskCreationController', 'save', array('project_id' => $project['id'])) ?>" autocomplete="off">
    <?= $this->form->csrf() ?>

    <div class="task-form-container">
        <div class="task-form-main-column">
            <?= $this->task->renderTitleField($values, $errors) ?>
            <?= $this->task->renderDescriptionField($values, $errors) ?>
            <?= $this->task->renderDescriptionTemplateDropdown($project['id']) ?>
            <?= $this->task->renderTagField($project) ?>

            <?= $this->hook->render('template:task:form:first-column', array('values' => $values, 'errors' => $errors)) ?>
        </div>

        <div class="task-form-secondary-column">
            <?= $this->task->renderColorField($values) ?>
            <?= $this->task->renderAssigneeField($users_list, $values, $errors) ?>
            <?= $this->task->renderCategoryField($categories_list, $values, $errors) ?>
            <?= $this->task->renderSwimlaneField($swimlanes_list, $values, $errors) ?>
            <?php if ($this->projectRole->getProjectUserRole($project['id']) !== \Kanboard\Core\Security\Role::PROJECT_VIEWER): ?>
                <?= $this->task->renderColumnField($columns_list, $values, $errors) ?>
            <?php endif ?>
            <?= $this->task->renderPriorityField($project, $values) ?>
            <?= $this->hook->render('template:task:form:second-column', array('values' => $values, 'errors' => $errors)) ?>
        </div>

        <div class="task-form-secondary-column">
            <?= $this->task->renderDueDateField($values, $errors) ?>
            <?= $this->task->renderStartDateField($values, $errors) ?>
            <?= $this->task->renderTimeEstimatedField($values, $errors) ?>
            <?= $this->task->renderTimeSpentField($values, $errors) ?>
            <?= $this->task->renderScoreField($values, $errors) ?>
            <?= $this->task->renderReferenceField($values, $errors) ?>

            <?= $this->hook->render('template:task:form:third-column', array('values' => $values, 'errors' => $errors)) ?>
        </div>

        <div class="task-form-bottom">

            <?= $this->hook->render('template:task:form:bottom-before-buttons', array('values' => $values, 'errors' => $errors)) ?>

            <?php if (! isset($duplicate)): ?>
                <?= $this->form->checkbox('another_task', t('Create another task'), 1, isset($values['another_task']) && $values['another_task'] == 1, '', array("tabindex" => "16")) ?>
                <?php if ($this->projectRole->getProjectUserRole($project['id']) !== \Kanboard\Core\Security\Role::PROJECT_VIEWER): ?>
                    <?= $this->form->checkbox('duplicate_multiple_projects', t('Duplicate to multiple projects'), 1, false, '', array("tabindex" => "17")) ?>
                <?php endif ?>
            <?php endif ?>

            <?= $this->modal->submitButtons() ?>
        </div>
    </div>
</form>