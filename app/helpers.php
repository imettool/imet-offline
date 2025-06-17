<?php
/*
 * Copyright (C) 2025 European Union
 * This program is free software: you can redistribute it and/or modify it under the terms of the
 * EUROPEAN UNION PUBLIC LICENCE v. 1.2 as published by the European Union.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the EUROPEAN UNION PUBLIC LICENCE v. 1.2 for
 * further details. You should have received a copy of the EUROPEAN UNION PUBLIC LICENCE v. 1.2. along with this program.
 * If not, see <https://joinup.ec.europa.eu/collection/eupl/eupl-text-eupl-12 >.
 */

use ImetCore\Helpers\ModuleKey;
use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;

/**
 * Return the IMET offline tool version
 */
function imet_offline_tool_version(): ?string
{
    return App::environment('local')
        ? 'DEV (' . config('nativephp.version') . ')'
        : config('nativephp.version');
}

/**
 * Return ClassName from module key
 */
function get_custom_model_class_by_key($module_key): ?string
{
    // IMET namespace
    if (class_exists(ModuleKey::class)) {
        $module_class = ModuleKey::KeyToClassName($module_key);
        if ($module_class !== null) {
            return $module_class;
        }
    }

    return null;
}

/**
 * Return view from module key
 */
function get_custom_model_view_by_key($module_key, $view_type = null): ?string
{
    // IMET views
    if (Str::startsWith($module_key, 'imet')) {
        $view = ModuleKey::KeyToView($module_key, $view_type);
        if ($view !== null) {
            return $view;
        }
    }

    return null;
}


/**
 * Retrieve a list
 * Custom helper function used by ModularForms\Helpers\Input::getList() to retrieve custom lists
 *
 * NOTE: Do not call this directly. Use instead ModularForms\Helpers\Input::getList()
 */
function get_custom_list(string $type): array
{
    $list = imet_selection_lists($type);

    if(empty($list)){

        if ($type == "Country") {
            $list = Country::selectionList();
        }

    }

    return $list;
}
