export const ClosableDirective = {
    bind(el, binding, vnode) {
        const handleOutsideClick = (e) => {
            e.stopPropagation();
            const {handler, exclude} = binding.value;
            const excludedEl = vnode.context.$refs[exclude];
            const clickedOnExcludedEl = excludedEl.contains(e.target);
            if (!el.contains(e.target) && !clickedOnExcludedEl) {
                vnode.context[handler]();
            }
        };
        el.__vueClickOutside__ = handleOutsideClick;
        document.addEventListener('click', handleOutsideClick);
        document.addEventListener('touchstart', handleOutsideClick);
    },

    unbind(el) {
        document.removeEventListener('click', el.__vueClickOutside__);
        document.removeEventListener('touchstart', el.__vueClickOutside__);
    },
};