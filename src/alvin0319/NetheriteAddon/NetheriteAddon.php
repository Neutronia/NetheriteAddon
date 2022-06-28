<?php

declare(strict_types=1);

namespace alvin0319\NetheriteAddon;

use pocketmine\inventory\ArmorInventory;
use pocketmine\inventory\CreativeInventory;
use pocketmine\item\Armor;
use pocketmine\item\ArmorTypeInfo;
use pocketmine\item\Axe;
use pocketmine\item\Hoe;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\Pickaxe;
use pocketmine\item\Shovel;
use pocketmine\item\Sword;
use pocketmine\item\ToolTier;
use pocketmine\plugin\PluginBase;
use ReflectionClass;

class NetheriteAddon extends PluginBase{

	protected function onEnable() : void{
		$ref = new ReflectionClass(ToolTier::class);
		$method = $ref->getMethod("register");
		$method->setAccessible(true);

		$toolTierClass = $ref->newInstanceWithoutConstructor();
		$prop = $ref->getProperty("enumName");
		$prop->setAccessible(true);
		$prop->setValue($toolTierClass, "netherite");
		$prop = $ref->getProperty("harvestLevel");
		$prop->setAccessible(true);
		$prop->setValue($toolTierClass, 6);
		$prop = $ref->getProperty("maxDurability");
		$prop->setAccessible(true);
		$prop->setValue($toolTierClass, 2031);
		$prop = $ref->getProperty("baseAttackPoints");
		$prop->setAccessible(true);
		$prop->setValue($toolTierClass, 8);
		$prop = $ref->getProperty("baseEfficiency");
		$prop->setAccessible(true);
		$prop->setValue($toolTierClass, 9);

		$method->invoke(null, $toolTierClass);

		ItemFactory::getInstance()->register(
			$sword = new Sword(new ItemIdentifier(743, 0), "Netherite Sword", ToolTier::NETHERITE())
		);

		ItemFactory::getInstance()->register(
			$pickaxe = new Pickaxe(new ItemIdentifier(745, 0), "Netherite Pickaxe", ToolTier::NETHERITE())
		);

		ItemFactory::getInstance()->register(
			$shovel = new Shovel(new ItemIdentifier(744, 0), "Netherite Shovel", ToolTier::NETHERITE())
		);

		ItemFactory::getInstance()->register(
			$axe = new Axe(new ItemIdentifier(746, 0), "Netherite Axe", ToolTier::NETHERITE())
		);

		ItemFactory::getInstance()->register(
			$hoe = new Hoe(new ItemIdentifier(747, 0), "Netherite Hoe", ToolTier::NETHERITE())
		);

		ItemFactory::getInstance()->register(
			$head = new Armor(new ItemIdentifier(748, 0), "Netherite Helmet", new ArmorTypeInfo(3, 407, ArmorInventory::SLOT_HEAD))
		);

		ItemFactory::getInstance()->register(
			$chest = new Armor(new ItemIdentifier(749, 0), "Netherite Chestplate", new ArmorTypeInfo(8, 592, ArmorInventory::SLOT_CHEST))
		);

		ItemFactory::getInstance()->register(
			$leggings = new Armor(new ItemIdentifier(750, 0), "Netherite Leggings", new ArmorTypeInfo(6, 555, ArmorInventory::SLOT_LEGS))
		);

		ItemFactory::getInstance()->register(
			$foot = new Armor(new ItemIdentifier(751, 0), "Netherite Boots", new ArmorTypeInfo(3, 481, ArmorInventory::SLOT_FEET))
		);

		ItemFactory::getInstance()->register(
			$netheriteIngot = new Item(new ItemIdentifier(742, 0), "Netherite Ingot")
		);

		$tools = [
			$sword,
			$pickaxe,
			$shovel,
			$axe,
			$hoe,
			$head,
			$chest,
			$leggings,
			$foot,
			$netheriteIngot
		];
		foreach($tools as $tool){
			if(CreativeInventory::getInstance()->getItemIndex($tool) === -1){
				CreativeInventory::getInstance()->add($tool);
			}
		}

		/*
		$blockMapping = new ReflectionClass(RuntimeBlockMapping::class);
		$states = $blockMapping->getProperty("bedrockKnownStates");
		$states->setAccessible(true);
		$register = $blockMapping->getMethod("registerMapping");
		$register->setAccessible(true);

		foreach($states->getValue(RuntimeBlockMapping::getInstance()) as $k => $state){
			$name = $state->getString("name");
			//$name = $state->getCompoundTag("block")->getString("name");
			if($name === "minecraft:netherite_block"){
				$register->invoke(RuntimeBlockMapping::getInstance(), $k, 525, 0);
				var_dump($k);
				break;
			}
		}
		*/
	}
}