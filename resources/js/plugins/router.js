import route from "ziggy";
import {Ziggy} from "./ziggy";

export default {
    route: (name, params, absolute) => route(name, params, absolute, Ziggy),
};
