<?php
namespace RconManager\Utils;

class ArkConfig
{
    const VALUE_TYPE_INT = 'integer';
    const VALUE_TYPE_FLOAT = 'float';
    const VALUE_TYPE_STRING = 'string';
    const VALUE_TYPE_NONE = 'none';
    const VALUE_TYPE_LIST = 'list';
    const VALUE_TYPE_BOOL = 'boolean';

    const CONFIG_TYPE_COMMANDLINE_OPTION = 'commandLine';
    const CONFIG_TYPE_GAMEUSERSETTINGS = 'gameUserSettings';
    const CONFIG_TYPE_GAME = 'game';
    const CONFIG_TYPE_PLAYER_EXCLUSIVE_JOIN_LIST = 'PlayersExclusiveJoinList';
    const CONFIG_TYPE_PLAYER_JOIN_NO_CHECK_LIST = 'PlayersJoinNoCheckList';
    const CONFIG_TYPE_ALLOWED_CHEATER_ACCOUNT_IDS = 'AllowedCheaterAccountIDs';
    const CONFIG_TYPE_BANLIST = 'Banlist';

    public static function getConfig()
    {
        return [
            self::CONFIG_TYPE_COMMANDLINE_OPTION => [
                '?AltSaveDirectoryName' => [
                    'type' => self::VALUE_TYPE_STRING,
                    'default' => false,
                ],
                '-AlwaysTickDedicatedSkeletalMeshes' => [
                    'type' => self::VALUE_TYPE_NONE,
                    'default' => false,
                ],
                '-AutoDestroyStructures' => [
                    'type' => self::VALUE_TYPE_NONE,
                    'default' => false,
                ],
                '-culture' => [
                    'type' => self::VALUE_TYPE_STRING,
                    'default' => 'en',
                ],
                '-DisableCustomCosmetics' => [
                    'type' => self::VALUE_TYPE_NONE,
                    'default' => false,
                ],
                '-disabledinonetrangescaling' => [
                    'type' => self::VALUE_TYPE_NONE,
                    'default' => false,
                ],
                '-EasterColors' => [
                    'type' => self::VALUE_TYPE_NONE,
                    'default' => false,
                ],
                '-exclusivejoin' => [
                    'type' => self::VALUE_TYPE_LIST,
                    'default' => false,
                ],
                '-ForceAllowCaveFlyers' => [
                    'type' => self::VALUE_TYPE_NONE,
                    'default' => false,
                ],
                '-GBUsageToForceRestart' => [
                    'type' => self::VALUE_TYPE_INT,
                    'default' => false,
                ],
                '-Mods' => [
                    'type' => self::VALUE_TYPE_LIST,
                    'default' => false,
                ],
                '-NoBattlEye' => [
                    'type' => self::VALUE_TYPE_NONE,
                    'default' => false,
                ],
                '-NoDinos' => [
                    'type' => self::VALUE_TYPE_NONE,
                    'default' => false,
                ],
                '-NoWildBabies' => [
                    'type' => self::VALUE_TYPE_NONE,
                    'default' => false,
                ],
                '-passivemods' => [
                    'type' => self::VALUE_TYPE_LIST,
                    'default' => false,
                ],
                '-port' => [
                    'type' => self::VALUE_TYPE_INT,
                    'default' => 7777,
                ],
                '-servergamelog' => [
                    'type' => self::VALUE_TYPE_NONE,
                    'default' => false,
                ],
                '-servergamelogincludetribelogs' => [
                    'type' => self::VALUE_TYPE_NONE,
                    'default' => false,
                ],
                '-ServerRCONOutputTribeLogs' => [
                    'type' => self::VALUE_TYPE_NONE,
                    'default' => false,
                ],
                '-StasisKeepControllers' => [
                    'type' => self::VALUE_TYPE_NONE,
                    'default' => false,
                ],
                '-UseDynamicConfig' => [
                    'type' => self::VALUE_TYPE_NONE,
                    'default' => false,
                ],
                '-ClusterDirOverride' => [
                    'type' => self::VALUE_TYPE_STRING,
                    'default' => false,
                ],
                '-clusterid' => [
                    'type' => self::VALUE_TYPE_STRING,
                    'default' => false,
                ],
                '-NoTransferFromFiltering' => [
                    'type' => self::VALUE_TYPE_NONE,
                    'default' => false,
                ],
                '-WinLiveMaxPlayers' => [
                    'type' => self::VALUE_TYPE_INT,
                    'default' => false,
                ],
                '-MaxPlayers' => [
                    'type' => self::VALUE_TYPE_INT,
                    'default' => false,
                ],
                '-ServerPlatform' => [
                    'type' => self::VALUE_TYPE_STRING,
                    'default' => false,
                ],
                '-ForceRespawnDinos' => [
                    'type' => self::VALUE_TYPE_NONE,
                    'default' => false,
                ],
            ],
            self::CONFIG_TYPE_GAMEUSERSETTINGS => [
                'ServerSettings' => [
                    'ActiveMods' => [
                        'type' => self::VALUE_TYPE_LIST,
                        'default' => false,
                    ],
                    'ActiveMapMod' => [
                        'type' => self::VALUE_TYPE_STRING,
                        'default' => false,
                    ],
                    'AdminLogging' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'AllowAnyoneBabyImprintCuddle' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'AllowCaveBuildingPvE' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'AllowCaveBuildingPvP' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => true,
                    ],
                    'AllowCrateSpawnsOnTopOfStructures' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'AllowCryoFridgeOnSaddle' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'AllowFlyerCarryPvE' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'AllowHideDamageSourceFromLogs' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => true,
                    ],
                    'AllowHitMarkers' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => true,
                    ],
                    'AllowMultipleAttachedC4' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'AllowRaidDinoFeeding' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'AllowThirdPersonPlayer' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => true,
                    ],
                    'AlwaysAllowStructurePickup' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'AutoDestroyOldStructuresMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 0,
                    ],
                    'AutoSavePeriodMinutes' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 15.0,
                    ],
                    'BanListURL' => [
                        'type' => self::VALUE_TYPE_STRING,
                        'default' => false,
                    ],
                    'ClampItemSpoilingTimes' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'ClampResourceHarvestDamage' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'DayCycleSpeedScale' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'DayTimeSpeedScale' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'DifficultyOffset' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'DinoCharacterFoodDrainMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'DinoCharacterHealthRecoveryMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'DinoCharacterStaminaDrainMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'DinoCountMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'DinoDamageMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'DinoResistanceMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'DestroyTamesOverTheSoftTameLimit' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'DisableCryopodEnemyCheck' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'DisableCryopodFridgeRequirement' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'DisableDinoDecayPvE' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'DisableImprintDinoBuff' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'DisablePvEGamma' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'DisableStructureDecayPvE' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'DisableWeatherFog' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'DontAlwaysNotifyPlayerJoined' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'EnableExtraStructurePreventionVolumes' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'EnablePvPGamma' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'FastDecayUnsnappedCoreStructures' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'ForceAllStructureLocking' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'globalVoiceChat' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'HarvestAmountMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'HarvestHealthMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'ImplantSuicideCD' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 28800,
                    ],
                    'ItemStackSizeMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'KickIdlePlayersPeriod' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 3600.0,
                    ],
                    'MaxPersonalTamedDinos' => [
                        'type' => self::VALUE_TYPE_INT,
                        'default' => 0,
                    ],
                    'MaxPlatformSaddleStructureLimit' => [
                        'type' => self::VALUE_TYPE_INT,
                        'default' => 75,
                    ],
                    'MaxTamedDinos' => [
                        'type' => self::VALUE_TYPE_INT,
                        'default' => 5000,
                    ],
                    'MaxTamedDinos_SoftTameLimit' => [
                        'type' => self::VALUE_TYPE_INT,
                        'default' => 5000,
                    ],
                    'MaxTamedDinos_SoftTameLimit' => [
                        'type' => self::VALUE_TYPE_INT,
                        'default' => 604800,
                    ],
                    'MaxTrainCars' => [
                        'type' => self::VALUE_TYPE_INT,
                        'default' => 8,
                    ],
                    'MaxTributeDinos' => [
                        'type' => self::VALUE_TYPE_INT,
                        'default' => 20,
                    ],
                    'MaxTributeItems' => [
                        'type' => self::VALUE_TYPE_INT,
                        'default' => 50,
                    ],
                    'NightTimeSpeedScale' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'NonPermanentDiseases' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'OnlyAutoDestroyCoreStructures' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'OverrideOfficialDifficulty' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 0.0,
                    ],
                    'OverrideSecondsUntilBuriedTreasureAutoReveals' => [
                        'type' => self::VALUE_TYPE_INT,
                        'default' => false,
                    ],
                    'OverrideStructurePlatformPrevention' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'OxygenSwimSpeedStatMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'PerPlatformMaxStructuresMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'PlatformSaddleBuildAreaBoundsMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'PlayerCharacterFoodDrainMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'PlayerCharacterHealthRecoveryMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'PlayerCharacterStaminaDrainMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'PlayerCharacterWaterDrainMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'PlayerDamageMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'PlayerResistanceMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'PreventDiseases' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'PreventMateBoost' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'PreventOfflinePvP' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'PreventOfflinePvPInterval' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 0.0,
                    ],
                    'PreventSpawnAnimations' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'PreventTribeAlliances' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'ProximityChat' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'PvEAllowStructuresAtSupplyDrops' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'PvEDinoDecayPeriodMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'PvEStructureDecayPeriodMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'PvPDinoDecay' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'RaidDinoCharacterFoodDrainMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'RandomSupplyCratePoints' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'RCONEnabled' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'RCONPort' => [
                        'type' => self::VALUE_TYPE_INT,
                        'default' => 27020,
                    ],
                    'RCONServerGameLogBuffer' => [
                        'type' => self::VALUE_TYPE_INT,
                        'default' => 600,
                    ],
                    'ResourcesRespawnPeriodMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'ServerAdminPassword' => [
                        'type' => self::VALUE_TYPE_STRING,
                        'default' => false,
                    ],
                    'ServerCrosshair' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => true,
                    ],
                    'ServerForceNoHUD' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'ServerHardcore' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'ServerPassword' => [
                        'type' => self::VALUE_TYPE_STRING,
                        'default' => false,
                    ],
                    'serverPVE' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'ShowFloatingDamageText' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'ShowMapPlayerLocation' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => true,
                    ],
                    'StructurePickupHoldDuration' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 0.5,
                    ],
                    'StructurePickupTimeAfterPlacement' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 30.0,
                    ],
                    'StructurePreventResourceRadiusMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'StructureResistanceMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'TamingSpeedMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'TheMaxStructuresInRange' => [
                        'type' => self::VALUE_TYPE_INT,
                        'default' => 10500,
                    ],
                    'TribeNameChangeCooldown' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 15.0,
                    ],
                    'XPMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
    
                    // CrossARK Transfers
                    'noTributeDownloads' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'PreventDownloadDinos' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'PreventDownloadItems' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'PreventDownloadSurvivors' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'PreventUploadDinos' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'PreventUploadItems' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'PreventUploadSurvivors' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'TributeCharacterExpirationSeconds' => [
                        'type' => self::VALUE_TYPE_INT,
                        'default' => 0,
                    ],
                    'TributeDinoExpirationSeconds' => [
                        'type' => self::VALUE_TYPE_INT,
                        'default' => 86400,
                    ],
                    'TributeItemExpirationSeconds' => [
                        'type' => self::VALUE_TYPE_INT,
                        'default' => 86400,
                    ],
                ],
                'SessionSettings' => [
                    // Session Settings
                    'Port' => [
                        'type' => self::VALUE_TYPE_INT,
                        'default' => 7777,
                    ],
                    'QueryPort' => [
                        'type' => self::VALUE_TYPE_INT,
                        'default' => 27015,
                    ],
                    'SessionName' => [
                        'type' => self::VALUE_TYPE_STRING,
                        'default' => false,
                    ],
                ],

                'MessageOfTheDay' => [
                    'Duration' => [
                        'type' => self::VALUE_TYPE_INT,
                        'default' => 20,
                    ],
                    'Message' => [
                        'type' => self::VALUE_TYPE_STRING,
                        'default' => false,
                    ],
                ],
            ],
            self::CONFIG_TYPE_GAME => [
                '/Script/shootergame.shootergamemode' => [
                    'BabyCuddleGracePeriodMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'BabyCuddleIntervalMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'BabyCuddleLoseImprintQualitySpeedMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'BabyFoodConsumptionSpeedMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'BabyImprintAmountMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'BabyImprintingStatScaleMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'BabyMatureSpeedMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'bAllowCustomRecipes' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => true,
                    ],
                    'bAllowFlyerSpeedLeveling' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'bAllowSpeedLeveling' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'bAllowUnlimitedRespecs' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'bDisableFriendlyFire' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'bDisablePhotoMode' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'bDisableStructurePlacementCollision' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'bPvEAllowTribeWar' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => true,
                    ],
                    'bPvEAllowTribeWarCancel' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'bPvEDisableFriendlyFire' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'bUseDinoLevelUpAnimations' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => true,
                    ],
                    'bUseSingleplayerSettings' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'CraftingSkillBonusMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'CraftXPMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'CropDecaySpeedMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'CropGrowthSpeedMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'CustomRecipeEffectivenessMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'CustomRecipeSkillMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'DestroyTamesOverLevelClamp' => [
                        'type' => self::VALUE_TYPE_INT,
                        'default' => 0,
                    ],
                    'DinoHarvestingDamageMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 3.2,
                    ],
                    'EggHatchSpeedMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'GenericXPMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'GlobalItemDecompositionTimeMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'GlobalSpoilingTimeMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'HarvestXPMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'KillXPMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'LayEggIntervalMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'MatingIntervalMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'MaxDifficulty' => [
                        'type' => self::VALUE_TYPE_BOOL,
                        'default' => false,
                    ],
                    'MatingSpeedMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'MaxNumberOfPlayersInTribe' => [
                        'type' => self::VALUE_TYPE_INT,
                        'default' => 0,
                    ],
                    'ResourceNoReplenishRadiusPlayers' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'ResourceNoReplenishRadiusStructures' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'SpecialXPMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                    'SpecialXPMultiplier' => [
                        'type' => self::VALUE_TYPE_FLOAT,
                        'default' => 1.0,
                    ],
                ],
            ],
        ];
    }
}