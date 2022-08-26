<?php

declare(strict_types=1);

namespace alvin0319\NetheriteAddon;

use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockFactory;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockToolType;
use pocketmine\block\Opaque;
use pocketmine\crafting\FurnaceRecipe;
use pocketmine\crafting\FurnaceType;
use pocketmine\crafting\ShapedRecipe;
use pocketmine\crafting\ShapelessRecipe;
use pocketmine\inventory\ArmorInventory;
use pocketmine\inventory\CreativeInventory;
use pocketmine\item\Armor;
use pocketmine\item\ArmorTypeInfo;
use pocketmine\item\Axe;
use pocketmine\item\Hoe;
use pocketmine\item\Item;
use pocketmine\item\ItemBlock;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\Pickaxe;
use pocketmine\item\Shovel;
use pocketmine\item\Sword;
use pocketmine\item\ToolTier;
use pocketmine\item\VanillaItems;
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

		BlockFactory::getInstance()->register($b = new Opaque(new BlockIdentifier(526, 0), "Ancient Debris", new BlockBreakInfo(30, BlockToolType::PICKAXE, ToolTier::DIAMOND()->getHarvestLevel(), 3600.0)), true);

		ItemFactory::getInstance()->register($i = new ItemBlock(new ItemIdentifier($b->getIdInfo()->getItemId(), 0), $b), true);

		CreativeInventory::getInstance()->add($i);

		ItemFactory::getInstance()->register($scrap = new Item(new ItemIdentifier(752, 0), "Netherite Scrap"));
		CreativeInventory::getInstance()->add($scrap);

		$this->getServer()->getCraftingManager()->getFurnaceRecipeManager(FurnaceType::FURNACE())
			->register(new FurnaceRecipe($scrap, $i));

		$this->getServer()->getCraftingManager()->registerShapedRecipe(new ShapedRecipe(
			[
				"AAA",
				"ABB",
				"BBC"
			],
			[
				"A" => $scrap,
				"B" => VanillaItems::GOLD_INGOT(),
				"C" => VanillaItems::AIR()
			],
			[$netheriteIngot]
		));

		$diamondSword = VanillaItems::DIAMOND_SWORD();
		$diamondPickaxe = VanillaItems::DIAMOND_PICKAXE();
		$diamondShovel = VanillaItems::DIAMOND_SHOVEL();
		$diamondAxe = VanillaItems::DIAMOND_AXE();
		$diamondHoe = VanillaItems::DIAMOND_HOE();
		$diamondHelmet = VanillaItems::DIAMOND_HELMET();
		$diamondChestplate = VanillaItems::DIAMOND_CHESTPLATE();
		$diamondLeggings = VanillaItems::DIAMOND_LEGGINGS();
		$diamondBoots = VanillaItems::DIAMOND_BOOTS();

		$this->getServer()->getCraftingManager()->registerShapedRecipe(new ShapedRecipe(
			[
				"ABC",
				"CCC",
				"CCC"
			],
			[
				"A" => $netheriteIngot,
				"B" => $diamondSword,
				"C" => VanillaItems::AIR()
			],
			[$sword]
		));

		$this->getServer()->getCraftingManager()->registerShapedRecipe(new ShapedRecipe(
			[
				"ABC",
				"CCC",
				"CCC"
			],
			[
				"A" => $netheriteIngot,
				"B" => $diamondPickaxe,
				"C" => VanillaItems::AIR()
			],
			[$pickaxe]
		));

		$this->getServer()->getCraftingManager()->registerShapedRecipe(new ShapedRecipe(
			[
				"ABC",
				"CCC",
				"CCC"
			],
			[
				"A" => $netheriteIngot,
				"B" => $diamondShovel,
				"C" => VanillaItems::AIR()
			],
			[$shovel]
		));

		$this->getServer()->getCraftingManager()->registerShapedRecipe(new ShapedRecipe(
			[
				"ABC",
				"CCC",
				"CCC"
			],
			[
				"A" => $netheriteIngot,
				"B" => $diamondAxe,
				"C" => VanillaItems::AIR()
			],
			[$axe]
		));

		$this->getServer()->getCraftingManager()->registerShapedRecipe(new ShapedRecipe(
			[
				"ABC",
				"CCC",
				"CCC"
			],
			[
				"A" => $netheriteIngot,
				"B" => $diamondHoe,
				"C" => VanillaItems::AIR()
			],
			[$hoe]
		));

		$this->getServer()->getCraftingManager()->registerShapedRecipe(new ShapedRecipe(
			[
				"ABC",
				"CCC",
				"CCC"
			],
			[
				"A" => $netheriteIngot,
				"B" => $diamondHelmet,
				"C" => VanillaItems::AIR()
			],
			[$head]
		));

		$this->getServer()->getCraftingManager()->registerShapedRecipe(new ShapedRecipe(
			[
				"ABC",
				"CCC",
				"CCC"
			],
			[
				"A" => $netheriteIngot,
				"B" => $diamondChestplate,
				"C" => VanillaItems::AIR()
			],
			[$chest]
		));

		$this->getServer()->getCraftingManager()->registerShapedRecipe(new ShapedRecipe(
			[
				"ABC",
				"CCC",
				"CCC"
			],
			[
				"A" => $netheriteIngot,
				"B" => $diamondLeggings,
				"C" => VanillaItems::AIR()
			],
			[$leggings]
		));

		$this->getServer()->getCraftingManager()->registerShapedRecipe(new ShapedRecipe(
			[
				"ABC",
				"CCC",
				"CCC"
			],
			[
				"A" => $netheriteIngot,
				"B" => $diamondBoots,
				"C" => VanillaItems::AIR()
			],
			[$foot]
		));


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