"use strict";

import '@fortawesome/fontawesome-free/js/all.js';
import Join from "./Join";
import PanelManager from "./Panels/PanelManager";
import NavigationPanel from "./Panels/NavigationPanel";
import RoomManager from "./Poker/Room/RoomManager";

const panelManager = new PanelManager();

const navigationPanel = new NavigationPanel(panelManager);
const roomManager = new RoomManager();
const join = new Join(panelManager, roomManager);

console.log(roomManager.join("serverName1", "roomName1"));
