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

namespace Reymon;

use JsonPath\JsonObject;
use ReflectionClass;
use ReflectionProperty;
use Reymon\Attributes\JsonMap;

abstract class TypeMapper
{
    protected function mapProperties(array $json)
    {
        $ref  = new ReflectionClass($this);
        $json = new JsonObject($json);

        foreach ($ref->getProperties() as $property) {
            $name      = $property->getName();
            $attribute = $this->getAttribute($property, JsonMap::class);

            if ($attribute) {
                if ($property->isStatic()) {
                    $this::$name = $attribute->map($json);
                } else {
                    $this->$name = $attribute->map($json);
                }
            }
        }
    }

    /**
     * @internal
     * @param class-string $name
     */
    protected function getAttribute(ReflectionProperty $property, string $name, int $flags = 0): object
    {
        $attribute = $property->getAttributes($name, $flags)[0] ?? null;
        return $attribute?->newInstance();
    }
}
