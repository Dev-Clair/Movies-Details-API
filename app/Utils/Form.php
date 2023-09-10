<?php

declare(strict_types=1);

namespace app\Utils;

trait FormInputAttributes
{
    /** Additional Form Input Attributes */
    public function formInputAttributes(mixed $value = null, ?string $autocomplete = null, ?string $max = null, ?string $min = null, ?string $step = null, ?string $maxlength = null, ?string $minlength = null, ?string $required = null, ?string $selected = null, ?string $checked = null, ?string $disabled = null): ?string
    {
        $attribute = "";
        $attributeList = ["value" => $value, "autocomplete" => $autocomplete, "max" => $max, "min" => $min, "step" => $step, "maxlength" => $maxlength, "minlength" => $minlength];

        foreach ($attributeList as $key => $value) {
            if (!empty($value)) {
                $attribute .= "$key=\"$value\" ";
            }
        }

        if (!is_null($required)) {
            $attribute .= "required ";
        }

        if (!is_null($selected)) {
            $attribute .= "selected ";
        }

        if (!is_null($checked)) {
            $attribute .= "checked ";
        }

        if (!is_null($disabled)) {
            $attribute .= "disabled ";
        }

        return trim($attribute);
    }
}
interface FormDiv
{
    public function formDiv(?string $divID = null, ?string $divClass = null): void;
}

interface StatusAlert
{
    public function statusAlert(?string $alertType = null, ?string $alertMsg = null): void;
}

interface FieldAlert
{
    public function fieldAlert(?string $alertClass = null, ?string $alertMsg = null): void;
}

interface LinkAlert
{
    public function linkAlert(?string $anchorID = null, ?string $anchorClass = null, ?string $anchorLink = null, ?string $anchorTitle = null,): void;
}

interface FormLabel
{
    public function formLabel(?string $labelID = null, ?string $labelClass = null, ?string $labelTitle = null): void;
}

interface FormFieldInput
{
    public function formFieldInput(?string $inputID = null, ?string $inputName = null, ?string $inputType = null, ?string $inputClass = null, ?string $inputPlaceholder = null, mixed $value = null, ?string $autocomplete = "off", ?string $max = null, ?string $min = null, ?string $step = null, ?string $maxlength = null, ?string $minlength = null, ?string $required = null, ?string $disabled = null): void;
}

interface FormRadioInput
{
    public function formRadioInput(?string $inputID = null, ?string $inputName = null, ?string $inputType = null, ?string $inputClass = null, ?string $inputValue = null, ?string $checked = null, ?string $disabled = null): void;
}

interface FormCheckBoxInput
{
    public function formCheckBoxInput(?string $inputID = null, ?string $inputName = null, ?string $inputType = null, ?string $inputClass = null, ?string $inputValue = null, ?string $checked = null, ?string $disabled = null): void;
}

interface FormFileUpload
{
    public function formFileUploadInput(?string $fileInputID = null, ?string $fileInputName = null, ?string $fileInputClass = null, ?string $acceptFileType = null, ?string $multiple = null, ?string $disabled = null, ?string $fileInputValue = null): void;
}

interface FormSelectInput
{
    public function formSelectInput(?string $selectID = null, ?string $selectName = null, ?string $selectClass = null, array $options = [], ?string $selectedValue = null, ?string $disabled = null): void;
}

interface FormTextAreaInput
{
    public function formTextAreaInput(?string $textareaID = null, ?string $textareaName = null, ?string $textareaClass = null, ?string $textareaPlaceholder = null, ?string $rows = null, ?string $cols = null, ?string $disabled = null): void;
}

interface FormButton
{
    public function formButton(?string $buttonID = null, ?string $buttonName = null, ?string $buttonType = null, ?string $buttonClass = null, ?string $buttonTitle = null, ?string $data_bs_toggle = null, ?string $data_bs_target = null): void;
}

/** Form */
class Form implements FormDiv, StatusAlert, FieldAlert, LinkAlert, FormLabel, FormFieldInput, FormRadioInput, FormCheckBoxInput, FormFileUpload, FormSelectInput, FormTextAreaInput, FormButton
{
    use FormInputAttributes;

    private string $form;

    public function createForm(string $formID, string $formName, string $formMethod, string $formAction, ?string $enctype = null): void
    {
        $this->form = "<form id=\"$formID\" name=\"$formName\" method=\"$formMethod\" action=\"$formAction\" enctype=\"$enctype\">";
    }

    public function statusAlert(?string $alertType = null, ?string $alertMsg = null): void
    {
        $this->form .= "<div class=\"alert alert-$alertType\" role=\"alert\">$alertMsg</div>";
    }

    public function fieldAlert(?string $alertClass = null, ?string $alertMsg = null): void
    {
        $this->form .= "<small class=\"$alertClass\"> $alertMsg </small>";
    }

    public function linkAlert(?string $anchorID = null, ?string $anchorClass = null, ?string $anchorLink = null, ?string $anchorTitle = null): void
    {
        $this->form .= "<a id=\"$anchorID\" class=\"$anchorClass\", href=\"tel:$anchorLink\">$anchorTitle";
    }

    public function formDiv(?string $divID = null, ?string $divClass = null): void
    {
        $this->form .= "<div for=\"$divID\" class=\"$divClass\"></div>";
    }

    public function formLabel(?string $labelID = null, string $labelClass = null, ?string $labelTitle = null): void
    {
        $this->form .= "<label for=\"$labelID\" class=\"$labelClass\"><strong>$labelTitle</strong></label>";
    }

    public function formFieldInput(?string $inputID = null, ?string $inputName = null, ?string $inputType = null, ?string $inputClass = null, ?string $inputPlaceholder = null, mixed $value = null, ?string $autocomplete = "off", ?string $max = null, ?string $min = null, ?string $step = null, ?string $maxlength = null, ?string $minlength = null, ?string $required = null, ?string $disabled = null): void
    {
        $this->form .= "<input id=\"$inputID\" name=\"$inputName\" type=\"$inputType\" class=\"$inputClass\" placeholder=\"$inputPlaceholder\"" . $this->formInputAttributes(value: $value, autocomplete: $autocomplete, max: $max, min: $min, step: $step, maxlength: $maxlength, minlength: $minlength, required: $required, disabled: $disabled) . ">";
    }

    public function formRadioInput(?string $inputID = null, ?string $inputName = null, ?string $inputType = null, ?string $inputClass = null, ?string $inputValue = null, ?string $checked = null, ?string $disabled = null): void
    {
        $this->form .= "<input id=\"$inputID\" name=\"$inputName\" type=\"$inputType\" class=\"$inputClass\" value=\"$inputValue\"" . $this->formInputAttributes(checked: $checked, disabled: $disabled) . ">";
    }

    public function formCheckBoxInput(?string $inputID = null, ?string $inputName = null, ?string $inputType = null, ?string $inputClass = null, ?string $inputValue = null, ?string $checked = null, ?string $disabled = null): void
    {
        $this->form .= "<input id=\"$inputID\" name=\"$inputName\" type=\"$inputType\" class=\"$inputClass\" value=\"$inputValue\"" . $this->formInputAttributes(checked: $checked, disabled: $disabled) . ">";
    }

    public function formFileUploadInput(?string $fileInputID = null, ?string $fileInputName = null, ?string $fileInputClass = null, ?string $acceptFileType = null, ?string $multiple = null, ?string $disabled = null, ?string $fileInputValue = null): void
    {
        $this->form .= "<input id=\"$fileInputID\" name=\"$fileInputName\" type=\"file\" class=\"$fileInputClass\" accept=\"$acceptFileType\"" . $this->formInputAttributes(disabled: $disabled, value: $fileInputValue) . ">";
    }

    public function formSelectInput(?string $selectID = null, ?string $selectName = null, ?string $selectClass = null, array $options = [], ?string $selectedValue = null, ?string $disabled = null): void
    {
        $selectOptions = "";
        foreach ($options as $value => $label) {
            $selected = ($selectedValue !== null && $selectedValue == $value) ? "selected" : "";
            $selectOptions .= "<option value=\"$value\" $selected>$label</option>";
        }

        $this->form .= "<select id=\"$selectID\" name=\"$selectName\" class=\"$selectClass\" " . $this->formInputAttributes(selected: $selectedValue, disabled: $disabled) . ">
                            $selectOptions
                        </select>";
    }

    public function formTextAreaInput(?string $textareaID = null, ?string $textareaName = null, ?string $textareaClass = null, ?string $textareaPlaceholder = null, ?string $rows = null, ?string $cols = null, ?string $disabled = null): void
    {
        $this->form .= "<textarea id=\"$textareaID\" name=\"$textareaName\" class=\"$textareaClass\" placeholder=\"$textareaPlaceholder\" rows=\"$rows\" cols=\"$cols\"" . $this->formInputAttributes(disabled: $disabled) . "></textarea>";
    }

    public function formButton(?string $buttonID = null, ?string $buttonName = null, ?string $buttonType = null, ?string $buttonClass = null, ?string $buttonTitle = null, ?string $data_bs_toggle = null, ?string $data_bs_target = null): void
    {
        $this->form .= "<button id=\"$buttonID\" name=\"$buttonName\" type=\"$buttonType\" class=\"$buttonClass\" data-bs-toggle=\"$data_bs_toggle\" data-bs-target=\"$data_bs_target\">$buttonTitle</button>";
    }

    public function render(): string
    {
        $this->form .= "</form>";
        return $this->form;
    }
}
