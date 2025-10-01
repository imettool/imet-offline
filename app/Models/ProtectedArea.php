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

namespace App\Models;

use Database\Factories\ProtectedAreaFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use ImetCore\Models\ProtectedArea as BaseProtectedArea;

/**
 * Class ProtectedArea
 * Extends the base ProtectedArea model from ImetCore to provide database factory support.
 */
class ProtectedArea extends BaseProtectedArea
{
    use HasFactory;

    protected static function newFactory(): Factory
    {
        return ProtectedAreaFactory::new();
    }

}
