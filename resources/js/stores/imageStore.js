export const imageStore = {
    state: {
        selector: '',
        image: '',
        imageList: [],
    },
    getters: {
        getImage: state => state.image,
        getImageList: state => state.imageList,
        getSelector: state => state.selector,
    },
    mutations: {
        setImage(state, image) {
            state.image = image;
        },
        setSelector(state, selector) {
            state.selector = selector;
        },
        setImageList(state, imageList) {
            state.imageList = imageList;
        },
    }
};
