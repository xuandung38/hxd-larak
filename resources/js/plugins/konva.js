import Konva from "konva";

export default {
    getRotatedPoint({x, y}, rad) {
        const rcos = Math.cos(rad);
        const rsin = Math.sin(rad);
        return {x: x * rcos - y * rsin, y: y * rcos + x * rsin};
    },
    getRotatedShapePosition(element, rotation) {
        const topLeft = {x: -element.width() / 2, y: -element.height() / 2};
        const current = this.getRotatedPoint(topLeft, Konva.getAngle(element.rotation()));
        const rotated = this.getRotatedPoint(topLeft, Konva.getAngle(rotation));
        const dx = rotated.x - current.x;
        const dy = rotated.y - current.y;

        return {x: element.x() + dx, y: element.y() + dy};
    },
}
