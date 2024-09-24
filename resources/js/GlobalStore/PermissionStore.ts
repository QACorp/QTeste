import { reactive } from 'vue'

export const PermissionStore = reactive({
    permissions: [],
    setPermissions(permissions: any) {
        PermissionStore.permissions = permissions;
    },
    hasPermission(permission: string) {
        return PermissionStore.permissions.includes(permission);
    }
})
