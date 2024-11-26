<?php

namespace Xbigdaddyx\Fuse\Domain\User\Enums;

enum UserManagementPermissionEnums: string
{

    case EDIT_USER = 'edit_user';
    case CREATE_USER = 'create_user';
    case DELETE_USER = 'delete_user';
    case VIEW_USER = 'view_user';
    case VIEW_ANY_USER = 'view_any_user';
    case RESTORE_USER = 'restore_user';
    case FORCE_DELETE_USER = 'force_delete_user';
    case ASSIGN_ROLE_USER = 'assign_role_user';

    public function label(): string
    {
        return match ($this) {

            self::EDIT_USER => 'Edit User',
            self::CREATE_USER => 'Create User',
            self::DELETE_USER => 'Delete User',
            self::VIEW_USER => 'View User',
            self::VIEW_ANY_USER => 'View Any User',
            self::RESTORE_USER => 'Restore User',
            self::FORCE_DELETE_USER => 'Force Delete User',
            self::ASSIGN_ROLE_USER => 'Assign Role User',
        };
    }
}
