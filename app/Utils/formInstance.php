<?php

use app\Form;

/**
 * This file is not for use.
 * It is meant for copying and filling in the form elements where needed
 * more like a form subtrait
 */
require __DIR__ . '/form.php';

// Instantiate Form and Create Form Members
$newForm = new Form();
$newForm->createForm(formID: "", formName: "", formMethod: "", formAction: "");
if (isset($_SESSION['errorAlertMsg'])) {
    $errorAlertMsg = sprintf("%s", $_SESSION['errorAlertMsg']);
    $newForm->statusAlert("danger", $errorAlertMsg);
}
unset($_SESSION['errorAlertMsg']);

if (isset($_SESSION['successAlertMsg'])) {
    $successAlertMsg = sprintf("%s", $_SESSION['successAlertMsg']);
    $newForm->statusAlert("success", $successAlertMsg);
}
unset($_SESSION['successAlertMsg']);

/** Form Text Field */
$newForm->formDiv(divID: "", divClass: "form-group mb-3");
$newForm->formLabel(labelID: "", labelClass: "form-label", labelTitle: "");
$newForm->formFieldInput(inputID: "", inputName: "", inputType: "text", inputClass: "form-control", inputPlaceholder: "");
if (isset($_SESSION['errors'][''])) {
    $alertMsg = sprintf("%s", $_SESSION['errors']['']);
    $newForm->fieldAlert(alertClass: "is-invalid", alertMsg: $alertMsg);
}

/** Form Radio Field */
$newForm->formDiv(divID: "", divClass: "form-group mb-3");
$newForm->formLabel(labelID: "", labelClass: "form-label", labelTitle: "");

$newForm->formDiv(divID: "", divClass: "form-row mb-2");

$newForm->formDiv(divID: "", divClass: "form-check-inline");
$newForm->formRadioInput(inputID: "", inputName: "", inputType: "radio", inputClass: "form-check-input", inputValue: "");
$newForm->formLabel(labelID: "", labelClass: "form-check-label", labelTitle: "");

$newForm->formDiv(divID: "", divClass: "form-check-inline");
$newForm->formRadioInput(inputID: "", inputName: "", inputType: "radio", inputClass: "form-check-input", inputValue: "");
$newForm->formLabel(labelID: "", labelClass: "form-check-label", labelTitle: "");

$newForm->formDiv(divID: "", divClass: "form-check-inline");
$newForm->formRadioInput(inputID: "", inputName: "", inputType: "radio", inputClass: "form-check-input", inputValue: "");
$newForm->formLabel(labelID: "", labelClass: "form-check-label", labelTitle: "");

/** Form Check Field */
$newForm->formDiv(divID: "", divClass: "form-check-inline");
$newForm->formLabel(labelID: "", labelClass: "form-label", labelTitle: "");

$newForm->formDiv(divID: "", divClass: "form-row mb-2");

$newForm->formDiv(divID: "", divClass: "form-check-inline");
$newForm->formCheckBoxInput(inputID: "", inputName: "", inputType: "checkbox", inputClass: "form-check-input", inputValue: "");
$newForm->formLabel(labelID: "", labelClass: "form-check-label", labelTitle: "");

$newForm->formDiv(divID: "", divClass: "form-check-inline");
$newForm->formCheckBoxInput(inputID: "", inputName: "", inputType: "checkbox", inputClass: "form-check-input", inputValue: "");
$newForm->formLabel(labelID: "", labelClass: "form-check-label", labelTitle: "");

$newForm->formDiv(divID: "", divClass: "form-check-inline");
$newForm->formCheckBoxInput(inputID: "", inputName: "", inputType: "checkbox", inputClass: "form-check-input", inputValue: "");
$newForm->formLabel(labelID: "", labelClass: "form-check-label", labelTitle: "");

/** Form Select Field */
$newForm->formDiv(divID: "", divClass: "form-group mb-3");
$newForm->formLabel(labelID: "", labelClass: "form-label", labelTitle: "");
$newForm->formSelectInput(selectID: "", selectName: "", selectClass: "form-select", options: ["" => "--Click to Select--", "" => "", "" => "", "" => ""], selectedValue: "--Click to Select--");

unset($_SESSION['errors']);

/** Form Submit Button */
$newForm->formDiv(divID: "submitButton", divClass: "form-group mb-3");
$newForm->formButton(buttonID: "submitButton", buttonName: "", buttonType: "submit", buttonClass: "btn btn-sm btn-primary", buttonTitle: "Submit");
// Render Form
echo $newForm->render();
