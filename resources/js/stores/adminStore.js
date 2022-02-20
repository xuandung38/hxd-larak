import Vue from 'vue'
import Vuex from 'vuex'
import sharedMutations from 'vuex-shared-mutations'
import {imageStore} from './imageStore'

Vue.use(Vuex);

export const adminStore = new Vuex.Store({
    modules: {
        imageStore,
    },
    plugins: [sharedMutations({
        predicate: [
            'setImage',
            'setImageList',
            'setSelector',
        ]
    })],
});
