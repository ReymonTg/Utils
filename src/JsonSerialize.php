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

use Attribute;
use JsonPath\JsonObject;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class JsonSerialize
{
    public function __construct(private string $name, private ?string $json = null, private bool $unpack = false)
    {
    }

    public function add(JsonObject $jsonObject, mixed $value)
    {
        if ($value instanceof JsonSerializable && $this->unpack) {
            $value->mapProperties();
        }

        if (!$this->json) {
            $this->json = "\$.{$this->name}";
            $jsonObject->set($this->json, $value);
            return;
        }
        $jsonObject->add($this->json, $value, $this->name);
    }
}
