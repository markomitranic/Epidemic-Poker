"use strict";

import Pie from "./Visual/Pie";

class VisualControls {

    constructor(container) {
        this.pie = new Pie(container);
    }

    populate(room) {
        this.pie.populate(room);
    }

}

export default VisualControls;