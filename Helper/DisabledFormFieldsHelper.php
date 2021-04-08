<?php

namespace Kanboard\Plugin\DelegateTask\Helper;

use Kanboard\Helper\FormHelper;
use Kanboard\Core\Base;

/**
 * Form helpers
 *
 * @package helper
 * @author  Frederic Guillot
 */
class DisabledFormHelper extends FormHelper
{

    /**
     * Display a DISABLED select field
     *
     * @access public
     * @param  string $name Field name
     * @param  array $options Options
     * @param  array $values Form values
     * @param  array $errors Form errors
     * @param  array $attributes
     * @param  string $class CSS class
     * @return string
     */
    public function selectDisabled($name, array $options, array $values = array(), array $errors = array(), array $attributes = array(), $class = '')
    {
        $html = '<select name="'.$name.'" id="form-'.$name.'" class="'.$class.'" '.implode(' ', $attributes).' disabled>';

        foreach ($options as $id => $value) {
            $html .= '<option value="'.$this->helper->text->e($id).'"';

            if (isset($values->$name) && $id == $values->$name) {
                $html .= ' selected="selected"';
            }
            if (isset($values[$name]) && $id == $values[$name]) {
                $html .= ' selected="selected"';
            }

            $html .= '>'.$this->helper->text->e($value).'</option>';
        }

        $html .= '</select>';
        $html .= $this->errorList($errors, $name);

        return $html;
    }

    /**
     * Display a color select field
     *
     * @access public
     * @param  string $name Field name
     * @param  array $values Form values
     * @return string
     */
    public function colorSelectDisabled($name, array $values)
    {
      $colors = $this->colorModel->getList();
      $html = $this->label(t('Color'), $name);
      $html .= $this->select($name, $colors, $values, array(), array('tabindex="4"'), 'color-picker');
      return $html;
    }

    /**
     * Display a radio field
     *
     * @access public
     * @param  string  $name      Field name
     * @param  string  $label     Form label
     * @param  string  $value     Form value
     * @param  boolean $selected  Field selected or not
     * @param  string  $class     CSS class
     * @return string
     */
    public function radioDisabled($name, $label, $value, $selected = false, $class = '')
    {
        return '<label><input type="radio" name="'.$name.'" class="'.$class.'" value="'.$this->helper->text->e($value).'" '.($selected ? 'checked="checked"' : '').'> '.$this->helper->text->e($label).'</label>';
    }

    /**
     * Display a checkbox field
     *
     * @access public
     * @param  string  $name        Field name
     * @param  string  $label       Form label
     * @param  string  $value       Form value
     * @param  boolean $checked     Field selected or not
     * @param  string  $class       CSS class
     * @param  array   $attributes
     * @return string
     */
    public function checkboxDisabled($name, $label, $value, $checked = false, $class = '', array $attributes = array())
    {
        $htmlAttributes = '';

        if ($checked) {
            $attributes['checked'] = 'checked';
        }

        foreach ($attributes as $attribute => $attributeValue) {
            $htmlAttributes .= sprintf('%s="%s"', $attribute, $this->helper->text->e($attributeValue));
        }

        return sprintf(
            '<label><input type="checkbox" name="%s" class="%s" value="%s" %s disabled>&nbsp;%s</label>',
            $name,
            $class,
            $this->helper->text->e($value),
            $htmlAttributes,
            $this->helper->text->e($label)
        );
    }

    /**
     * Display a textarea
     *
     * @access public
     * @param  string  $name        Field name
     * @param  array   $values      Form values
     * @param  array   $errors      Form errors
     * @param  array   $attributes  HTML attributes
     * @param  string  $class       CSS class
     * @return string
     */
    public function textareaDisabled($name, $values = array(), array $errors = array(), array $attributes = array(), $class = '')
    {
        $class .= $this->errorClass($errors, $name);

        $html = '<textarea name="'.$name.'" id="form-'.$name.'" class="'.$class.'" ';
        $html .= implode(' ', $attributes).'>';
        $html .= isset($values[$name]) ? $this->helper->text->e($values[$name]) : '';
        $html .= '</textarea>';
        $html .= $this->errorList($errors, $name);

        return $html;
    }

    /**
     * Display a markdown editor
     *
     * @access public
     * @param  string  $name     Field name
     * @param  array   $values   Form values
     * @param  array   $errors   Form errors
     * @param  array   $attributes
     * @return string
     */
    public function textEditor($name, $values = array(), array $errors = array(), array $attributes = array())
    {
        $params = array(
            'name' => $name,
            'css' => $this->errorClass($errors, $name),
            'required' => isset($attributes['required']) && $attributes['required'],
            'tabindex' => isset($attributes['tabindex']) ? $attributes['tabindex'] : '-1',
            'labelPreview' => t('Preview'),
            'previewUrl' => $this->helper->url->to('TaskAjaxController', 'preview'),
            'labelWrite' => t('Write'),
            'labelTitle' => t('Title'),
            'placeholder' => t('Write your text in Markdown'),
            'ariaLabel' => isset($attributes['aria-label']) ? $attributes['aria-label'] : '',
            'autofocus' => isset($attributes['autofocus']) && $attributes['autofocus'],
            'suggestOptions' => array(
                'triggers' => array(
                    '#' => $this->helper->url->to('TaskAjaxController', 'suggest', array('search' => 'SEARCH_TERM')),
                )
            ),
        );

        if (isset($values['project_id'])) {
            $params['suggestOptions']['triggers']['@'] = $this->helper->url->to('UserAjaxController', 'mention', array('project_id' => $values['project_id'], 'search' => 'SEARCH_TERM'));
        }

        $html = '<div class="js-text-editor" data-params=\''.json_encode($params, JSON_HEX_APOS).'\'>';
        $html .= '<script type="text/template">'.(isset($values[$name]) ? htmlspecialchars($values[$name], ENT_QUOTES, 'UTF-8', true) : '').'</script>';
        $html .= '</div>';
        $html .= $this->errorList($errors, $name);

        return $html;
    }

    /**
     * Display file field
     *
     * @access public
     * @param  string  $name
     * @param  array   $errors
     * @param  boolean $multiple
     * @return string
     */
    public function fileDisabled($name, array $errors = array(), $multiple = false)
    {
        $html = '<input type="file" name="'.$name.'" id="form-'.$name.'" '.($multiple ? 'multiple' : '').' disabled>';
        $html .= $this->errorList($errors, $name);

        return $html;
    }

    /**
     * Display a input field
     *
     * @access public
     * @param  string  $type        HMTL input tag type
     * @param  string  $name        Field name
     * @param  array   $values      Form values
     * @param  array   $errors      Form errors
     * @param  array   $attributes  HTML attributes
     * @param  string  $class       CSS class
     * @return string
     */
    public function inputDisabled($type, $name, $values = array(), array $errors = array(), array $attributes = array(), $class = '')
    {
        $class .= $this->errorClass($errors, $name);

        $html = '<input type="'.$type.'" name="'.$name.'" id="form-'.$name.'" '.$this->formValue($values, $name).' class="'.$class.'" ';
        $html .= implode(' ', $attributes).' disabled>';

        if (in_array('required', $attributes)) {
            $html .= '<span class="form-required">*</span>';
        }

        $html .= $this->errorList($errors, $name);

        return $html;
    }


}
