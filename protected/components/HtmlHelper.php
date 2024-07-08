<?php
class HtmlHelper {
    public static function requiredLabelEx($model, $attribute, $htmlOptions = array()) {
        $label = CHtml::activeLabelEx($model, $attribute, $htmlOptions);
        return str_replace('*', '<span class="required text-danger">*</span>', $label);
    }
}
