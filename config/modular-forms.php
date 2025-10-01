<?php
return [

    'user' => \App\Models\User::class,

    // Imet custom lists
    'custom_lists_method' => '\App\Helpers\SelectionList::getCustomList',

    // IMET views and models from module keys
    'model_view_by_key_custom_method' => '\ImetCore\Helpers\ModuleKey::KeyToView',
    'model_class_by_key_custom_method' => '\ImetCore\Helpers\ModuleKey::KeyToClassName',


    // CustomInput Component Class: extend with custom input types
    'custom_inputs_view' => \ImetCore\View\CustomInput::class,
    'custom_inputs-preview_view' => \ImetCore\View\CustomInputPreview::class,


];
