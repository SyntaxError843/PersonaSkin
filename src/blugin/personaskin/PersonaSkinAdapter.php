<?php

/*
 *
 *  ____  _             _         _____
 * | __ )| |_   _  __ _(_)_ __   |_   _|__  __ _ _ __ ___
 * |  _ \| | | | |/ _` | | '_ \    | |/ _ \/ _` | '_ ` _ \
 * | |_) | | |_| | (_| | | | | |   | |  __/ (_| | | | | | |
 * |____/|_|\__,_|\__, |_|_| |_|   |_|\___|\__,_|_| |_| |_|
 *                |___/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author  Blugin team
 * @link    https://github.com/Blugin
 * @license https://www.gnu.org/licenses/lgpl-3.0 LGPL-3.0 License
 *
 *   (\ /)
 *  ( . .) ♥
 *  c(")(")
 */

declare(strict_types=1);

namespace blugin\personaskin;

use pocketmine\entity\Skin;
use pocketmine\network\mcpe\convert\LegacySkinAdapter;
use pocketmine\network\mcpe\protocol\types\skin\SkinData;

use function random_bytes;
use function str_repeat;

class PersonaSkinAdapter extends LegacySkinAdapter{
    /** @var SkinData[] */
    private array $personaSkins = [];

    /** @override */
    public function fromSkinData(SkinData $data) : Skin{
        if($data->isPersona()){
            $id = $data->getSkinId();
            $this->personaSkins[$id] = $data;
            return new Skin($id, str_repeat(random_bytes(3) . "\xff", 2048));
        }
        return parent::fromSkinData($data);
    }

    /** @override */
    public function toSkinData(Skin $skin) : SkinData{
        return $this->personaSkins[$skin->getSkinId()] ?? parent::toSkinData($skin);
    }
}
