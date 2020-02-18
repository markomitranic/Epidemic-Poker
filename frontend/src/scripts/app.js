"use strict";

import '@fortawesome/fontawesome-free/js/all.js';
import Join from "./Poker/Join";
import PanelManager from "./Panels/PanelManager";
import NavigationPanel from "./Panels/NavigationPanel";
import RoomManager from "./Poker/Room/RoomManager";
import Create from "./Poker/Create";

const panelManager = new PanelManager();

const navigationPanel = new NavigationPanel(panelManager);
const roomManager = new RoomManager();
const join = new Join(panelManager, roomManager);
const create = new Create(panelManager, roomManager);
