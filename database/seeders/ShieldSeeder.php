<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_inventory","view_any_inventory","update_inventory","reorder_inventory","view_menu::category","view_any_menu::category","update_menu::category","reorder_menu::category","view_menu::product","view_any_menu::product","update_menu::product","reorder_menu::product","view_order","view_any_order","create_order","replicate_order","update_order","reorder_order","restore_order","restore_any_order","delete_order","delete_any_order","view_order::review","view_any_order::review","reorder_order::review","page_Menu","page_BaristaView","widget_OrderWidget","widget_OrdersRadar","widget_OriginOrders","widget_OrdersPerMonth","widget_PopularItems","widget_ReviewsChart","view_employee","view_any_employee","reorder_employee","view_employee::role","view_any_employee::role","reorder_employee::role","create_inventory","replicate_inventory","restore_any_inventory","restore_inventory","delete_any_inventory","delete_inventory","create_menu::category","replicate_menu::category","restore_any_menu::category","restore_menu::category","delete_menu::category","restore_menu::product","create_menu::product","restore_any_menu::product","replicate_menu::product","delete_menu::product","restore_order::review","restore_any_order::review","view_role","view_any_role","update_role","view_user","view_any_user","reorder_user","page_SalesPage","widget_Revenue","create_employee","update_employee","restore_employee","restore_any_employee","replicate_employee","delete_employee","delete_any_employee","create_employee::role","update_employee::role","restore_employee::role","restore_any_employee::role","replicate_employee::role","delete_employee::role","delete_any_employee::role","delete_any_menu::category","delete_any_menu::product","replicate_order::review","delete_order::review","delete_any_order::review","create_role","delete_role","delete_any_role","create_user","update_user","restore_user","restore_any_user","replicate_user","delete_user","delete_any_user","force_delete_employee","force_delete_any_employee","force_delete_employee::role","force_delete_any_employee::role","force_delete_inventory","force_delete_any_inventory","force_delete_menu::category","force_delete_any_menu::category","force_delete_menu::product","force_delete_any_menu::product","force_delete_order","force_delete_any_order","create_order::review","update_order::review","force_delete_order::review","force_delete_any_order::review","force_delete_user","force_delete_any_user"]},{"name":"Barista Operativo","guard_name":"web","permissions":["view_inventory","view_any_inventory","update_inventory","reorder_inventory","view_menu::category","view_any_menu::category","update_menu::category","reorder_menu::category","view_menu::product","view_any_menu::product","update_menu::product","reorder_menu::product","view_order","view_any_order","create_order","replicate_order","update_order","reorder_order","restore_order","restore_any_order","delete_order","delete_any_order","view_order::review","view_any_order::review","reorder_order::review","page_Menu","page_BaristaView","widget_OrderWidget","widget_OrdersRadar","widget_OriginOrders","widget_OrdersPerMonth","widget_PopularItems","widget_ReviewsChart"]},{"name":"Supervisor","guard_name":"web","permissions":["view_inventory","view_any_inventory","update_inventory","reorder_inventory","view_menu::category","view_any_menu::category","update_menu::category","reorder_menu::category","view_menu::product","view_any_menu::product","update_menu::product","reorder_menu::product","view_order","view_any_order","create_order","replicate_order","update_order","reorder_order","restore_order","restore_any_order","delete_order","delete_any_order","view_order::review","view_any_order::review","reorder_order::review","page_Menu","page_BaristaView","widget_OrderWidget","widget_OrdersRadar","widget_OriginOrders","widget_OrdersPerMonth","widget_PopularItems","widget_ReviewsChart","view_employee","view_any_employee","reorder_employee","view_employee::role","view_any_employee::role","reorder_employee::role","create_inventory","replicate_inventory","restore_any_inventory","restore_inventory","delete_any_inventory","delete_inventory","create_menu::category","replicate_menu::category","restore_any_menu::category","restore_menu::category","delete_menu::category","restore_menu::product","create_menu::product","restore_any_menu::product","replicate_menu::product","delete_menu::product","restore_order::review","restore_any_order::review","view_role","view_any_role","update_role","view_user","view_any_user","reorder_user","page_SalesPage","widget_Revenue"]},{"name":"Gerente","guard_name":"web","permissions":["view_inventory","view_any_inventory","update_inventory","reorder_inventory","view_menu::category","view_any_menu::category","update_menu::category","reorder_menu::category","view_menu::product","view_any_menu::product","update_menu::product","reorder_menu::product","view_order","view_any_order","create_order","replicate_order","update_order","reorder_order","restore_order","restore_any_order","delete_order","delete_any_order","view_order::review","view_any_order::review","reorder_order::review","page_Menu","page_BaristaView","widget_OrderWidget","widget_OrdersRadar","widget_OriginOrders","widget_OrdersPerMonth","widget_PopularItems","widget_ReviewsChart","view_employee","view_any_employee","reorder_employee","view_employee::role","view_any_employee::role","reorder_employee::role","create_inventory","replicate_inventory","restore_any_inventory","restore_inventory","delete_any_inventory","delete_inventory","create_menu::category","replicate_menu::category","restore_any_menu::category","restore_menu::category","delete_menu::category","restore_menu::product","create_menu::product","restore_any_menu::product","replicate_menu::product","delete_menu::product","restore_order::review","restore_any_order::review","view_role","view_any_role","update_role","view_user","view_any_user","reorder_user","page_SalesPage","widget_Revenue","create_employee","update_employee","restore_employee","restore_any_employee","replicate_employee","delete_employee","delete_any_employee","create_employee::role","update_employee::role","restore_employee::role","restore_any_employee::role","replicate_employee::role","delete_employee::role","delete_any_employee::role","delete_any_menu::category","delete_any_menu::product","replicate_order::review","delete_order::review","delete_any_order::review","create_role","delete_role","delete_any_role","create_user","update_user","restore_user","restore_any_user","replicate_user","delete_user","delete_any_user"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
