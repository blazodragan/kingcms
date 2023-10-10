<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $defaultPermissions = collect([
            // view admin as a whole
            'kingscms',

            // manage translations
            'kingscms.translation.index',
            'kingscms.translation.edit',
            'kingscms.translation.rescan',
            'kingscms.translation.publish',
            'kingscms.translation.export',
            'kingscms.translation.import',

            // manage users (access)
            'kingscms.kingscms-user.index',
            'kingscms.kingscms-user.create',
            'kingscms.kingscms-user.show',
            'kingscms.kingscms-user.edit',
            'kingscms.kingscms-user.destroy',
            'kingscms.kingscms-user.impersonal-login',

            // media
            'kingscms.media.index',
            'kingscms.media.upload',
            'kingscms.media.destroy',

            // permissions
            'kingscms.role.index',
            'kingscms.role.edit',

            // manage tags (access)
            'kingscms.tag.index',
            'kingscms.tag.store',

            // settings
            'kingscms.settings.edit',

            // permissions
            'kingscms.permission.index',
            'kingscms.permission.edit'
        ]);

        $adminRoleId = DB::table('roles')->insertGetId([
            'name' => 'Administrator',
            'guard_name' => 'kingscms',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $defaultPermissions->each(function ($permission) use ($adminRoleId) {
            $permissionId = DB::table('permissions')->insertGetId([
                'name' => $permission,
                'guard_name' => 'kingscms',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            DB::table('role_has_permissions')->insert([
                'permission_id' => $permissionId,
                'role_id' => $adminRoleId,
            ]);
        });

        // let's create a default Guest role in case self-registration is enabled
        $guestRoleId = DB::table('roles')->insertGetId([
            'name' => 'Guest',
            'guard_name' => 'kingscms',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => DB::table('permissions')
                ->where('name', '=', 'kingscms')
                ->where('guard_name', '=', 'kingscms')
                ->value('id'),
            'role_id' => $guestRoleId,
        ]);

        app()['cache']->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $guestRole = DB::table('roles')->where('name', 'Guest')->where('guard_name', 'kingscms')->first();
        DB::table('role_has_permissions')
            ->where('role_id', $guestRole->id)
            ->delete();
        DB::table('roles')->where('id', $guestRole->id)->delete();

        $adminRole = DB::table('roles')->where('name', 'Administrator')->where('guard_name', 'kingscms')->first();
        DB::table('role_has_permissions')
            ->where('role_id', $adminRole->id)
            ->delete();
        DB::table('roles')->where('id', $adminRole->id)->delete();

        $this->defaultPermissions->each(function ($permission){
            $permissionItem = DB::table('permissions')->where([
                'name' => $permission,
                'guard_name' => 'kingscms'
            ])->first();

            if ($permissionItem !== null) {
                DB::table('permissions')->where('id', $permissionItem->id)->delete();
                DB::table('model_has_permissions')->where('permission_id', $permissionItem->id)->delete();
            }
        });
        app()['cache']->forget(config('permission.cache.key'));
    }
};
