<?php

namespace App\Portal\Permissions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

/**
 * Class Permissions
 *
 * This class handles interactions with user permissions
 *
 * @package App\Portal\Permissions
 */
class Permissions
{
    /**
     * Get Dashboard Permissions
     *
     * Return an array of Dashboard Module permissions for a passed user ID
     *
     * @param int $user_id
     * @return Collection
     */
    public function getDashboardPermissions(int $user_id) :Collection
    {
        return DB::table('dashboard_agent_permissions')
            ->join('dashboard_permissions', 'dashboard_agent_permissions.permission_id', '=', 'dashboard_permissions.id')
            ->where('dashboard_agent_permissions.user_id', $user_id)
            ->pluck('dashboard_permissions.field_name');
    }

    /**
     * Get Clients Permissions
     *
     * Return an array of Clients Module permissions for a passed user ID
     *
     * @param int $user_id
     * @return Collection
     */
    public function getClientsPermissions(int $user_id) :Collection
    {
        return DB::table('clients_agent_permissions')
            ->join('clients_permissions', 'clients_agent_permissions.permission_id', '=', 'clients_permissions.id')
            ->where('clients_agent_permissions.user_id', $user_id)
            ->pluck('clients_permissions.field_name');
    }

    /**
     * Get Products Permissions
     *
     * Return an array of Products Module permissions for a passed user ID
     *
     * @param int $user_id
     * @return Collection
     */
    public function getProductsPermissions(int $user_id) :Collection
    {
        return DB::table('products_agent_permissions')
            ->join('products_permissions', 'products_agent_permissions.permission_id', '=', 'products_permissions.id')
            ->where('products_agent_permissions.user_id', $user_id)
            ->pluck('products_permissions.field_name');
    }

    /**
     * Get MIDs Permissions
     *
     * Return an array of MIDs Module permissions for a passed user ID
     *
     * @param int $user_id
     * @return Collection
     */
    public function getMIDsPermissions(int $user_id) :Collection
    {
        return DB::table('mids_agent_permissions')
            ->join('mids_permissions', 'mids_agent_permissions.permission_id', '=', 'mids_permissions.id')
            ->where('mids_agent_permissions.user_id', $user_id)
            ->pluck('mids_permissions.field_name');
    }

    /**
     * Get Orders Permissions
     *
     * Return an array of Orders Module permissions for a passed user ID
     *
     * @param int $user_id
     * @return Collection
     */
    public function getOrdersPermissions(int $user_id) :Collection
    {
        return DB::table('orders_agent_permissions')
            ->join('orders_permissions', 'orders_agent_permissions.permission_id', '=', 'orders_permissions.id')
            ->where('orders_agent_permissions.user_id', $user_id)
            ->pluck('orders_permissions.field_name');
    }
}