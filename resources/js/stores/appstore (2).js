import { defineStore } from 'pinia';

export const useAppStore = defineStore('app', {
    // export const uApStore = defineStore('app', {
    state: () => ({
        user: null, // Store user information here
    }),
    actions: {
        setUser(user) {
            this.user = user;
        },
    },
});
