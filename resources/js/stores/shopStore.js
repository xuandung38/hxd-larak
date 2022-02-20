import Vue from 'vue';
import Vuex from 'vuex';
import sharedMutations from 'vuex-shared-mutations';
import {imageStore} from './imageStore';
import {userStore} from './userStore';

Vue.use(Vuex);

export const shopStore = new Vuex.Store({
    modules: {
        imageStore,
        userStore,
    },
    plugins: [sharedMutations({
        predicate: [
            'setImage',
            'setImageList',
            'setSelector',
            'setShowPopup',
            'setUser'
        ]
    })],
});
