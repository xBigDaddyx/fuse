<?php

namespace Xbigdaddyx\Fuse\Domain\User\Enums;

enum RoleEnums: string
{
    case VENDOR = 'vendor';
    case IT = 'information_technology_staff';
    case ITMGR = 'information_technology_manager';
    case HR = 'human_resource_staff';
    case HRMGR = 'human_resource_manager';
    case PACKING = 'packing_staff';
    case PACKINGMGR = 'packing_manager';

    public function label(): string
    {
        return match ($this) {
            self::VENDOR => 'Vendor',
            self::IT => 'Information Technology Staff',
            self::ITMGR => 'Information Technology Manager',
            self::HR => 'Human Resource Staff',
            self::HRMGR => 'Human Resource Manager',
            self::PACKING => 'Packing Staff',
            self::PACKINGMGR => 'Packing Manager',
        };
    }
}
