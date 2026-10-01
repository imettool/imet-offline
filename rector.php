<?php

/*
 * Copyright (C) 2025 European Union
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by the Free Software Foundation,
 * either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

use Rector\CodingStyle\Rector\FuncCall\FunctionFirstClassCallableRector;
use Rector\CodingStyle\Rector\String_\SimplifyQuoteEscapeRector;
use Rector\Config\RectorConfig;
use Rector\Php81\Rector\Array_\ArrayToFirstClassCallableRector;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\SafeDeclareStrictTypesRector;
use RectorLaravel\Rector\Class_\AddHasFactoryToModelsRector;
use RectorLaravel\Rector\Class_\AppendsPropertyToAppendsAttributeRector;
use RectorLaravel\Rector\Class_\DescriptionPropertyToDescriptionAttributeRector;
use RectorLaravel\Rector\Class_\FillablePropertyToFillableAttributeRector;
use RectorLaravel\Rector\Class_\GuardedPropertyToGuardedAttributeRector;
use RectorLaravel\Rector\Class_\HiddenPropertyToHiddenAttributeRector;
use RectorLaravel\Rector\Class_\RemoveModelPropertyFromFactoriesRector;
use RectorLaravel\Rector\Class_\SignaturePropertyToSignatureAttributeRector;
use RectorLaravel\Rector\Class_\TablePropertyToTableAttributeRector;
use RectorLaravel\Rector\Class_\UseForwardsCallsTraitRector;
use RectorLaravel\Rector\Class_\WithoutIncrementingPropertyToWithoutIncrementingAttributeRector;
use RectorLaravel\Rector\Class_\WithoutTimestampsPropertyToWithoutTimestampsAttributeRector;
use RectorLaravel\Rector\ClassMethod\MakeModelAttributesAndScopesProtectedRector;
use RectorLaravel\Rector\Empty_\EmptyToBlankAndFilledFuncRector;
use RectorLaravel\Rector\MethodCall\ResponseHelperCallToJsonResponseRector;
use RectorLaravel\Rector\MethodCall\UseComponentPropertyWithinCommandsRector;
use RectorLaravel\Set\LaravelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/bootstrap/*.php',
        __DIR__.'/config',
        __DIR__.'/database',
        __DIR__.'/lang',
        __DIR__.'/public',
        __DIR__.'/resources',
        __DIR__.'/routes',
        __DIR__.'/tests',
    ])
    ->withSkip([

        // Do not force strict type
        SafeDeclareStrictTypesRector::class,

        AddHasFactoryToModelsRector::class,

        // Don't like first-class callables
        FunctionFirstClassCallableRector::class => [
            __DIR__.'/routes',
        ],

        // Do not convert to first class callable in routes
        ArrayToFirstClassCallableRector::class => [
            __DIR__.'/routes',
        ],

        MakeModelAttributesAndScopesProtectedRector::class,

        // Keep always same quote style in lang files
        SimplifyQuoteEscapeRector::class => [
            __DIR__.'/lang',
        ],

        UseComponentPropertyWithinCommandsRector::class => [
            __DIR__.'/app/Console/Commands/ResetDevEnv.php',
        ],

        // Ignore attribute rules on Laravel models
        FillablePropertyToFillableAttributeRector::class,
        GuardedPropertyToGuardedAttributeRector::class,
        AppendsPropertyToAppendsAttributeRector::class,
        HiddenPropertyToHiddenAttributeRector::class,
        TablePropertyToTableAttributeRector::class,
        WithoutIncrementingPropertyToWithoutIncrementingAttributeRector::class,
        WithoutTimestampsPropertyToWithoutTimestampsAttributeRector::class,
        DescriptionPropertyToDescriptionAttributeRector::class,
        SignaturePropertyToSignatureAttributeRector::class,

    ])
    ->withComposerBased(laravel: true)
    ->withSets([
        LaravelSetList::LARAVEL_ARRAYACCESS_TO_METHOD_CALL,
        LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_COLLECTION,
        LaravelSetList::LARAVEL_CONTAINER_STRING_TO_FULLY_QUALIFIED_NAME,
        LaravelSetList::LARAVEL_ELOQUENT_MAGIC_METHOD_TO_QUERY_BUILDER,
        LaravelSetList::LARAVEL_FACTORIES,
        LaravelSetList::LARAVEL_IF_HELPERS,
        LaravelSetList::LARAVEL_LEGACY_FACTORIES_TO_CLASSES,
        // LaravelSetList::LARAVEL_STATIC_TO_INJECTION      // No, not this one!! What's wrong with Laravel's Facades??
    ])
    ->withPhpSets(php82: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        //        naming: true,                 // not necessary, and sometimes harmful
        instanceOf: true,
        earlyReturn: true,
        carbon: true,
        //        rectorPreset: true,           // To be decided: introduce strict type declaration
    )
    ->withRules([
        EmptyToBlankAndFilledFuncRector::class,
        RemoveModelPropertyFromFactoriesRector::class,
        ResponseHelperCallToJsonResponseRector::class,
        UseComponentPropertyWithinCommandsRector::class,
        UseForwardsCallsTraitRector::class,
    ]);
