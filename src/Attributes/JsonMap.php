<?php declare(strict_types=1);

/**
 * This file is part of Reymon.
 * Reymon is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * Reymon is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 * If not, see <http://www.gnu.org/licenses/>.
 *
 * @author    AhJ <AmirHosseinJafari8228@gmail.com>
 * @copyright 2023-2024 AhJ <AmirHosseinJafari8228@gmail.com>
 * @license   https://choosealicense.com/licenses/gpl-3.0/ GPLv3
 */

namespace Reymon\Attributes;

use Attribute;
use JsonPath\JsonObject;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class JsonMap
{
    public function __construct(private string $path, private mixed $default = null)
    {
    }

    public function map(JsonObject $json): mixed
    {
        $value = $json->get($this->path);
        return $value[0] ?? $this->default;
    }
}
