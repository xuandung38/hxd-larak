export const userStore = {
    state: {
        user: [],
    },
    getters: {
        getUser: state => state.user
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
        }
    }
};
