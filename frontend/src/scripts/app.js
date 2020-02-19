"use strict";

import '@fortawesome/fontawesome-free/js/all.js';
import Join from "./Poker/Join";
import PanelManager from "./Panels/PanelManager";
import NavigationPanel from "./Panels/NavigationPanel";
import RoomManager from "./Poker/Room/RoomManager";
import Create from "./Poker/Create";
import roomWindow from "./Poker/Room/Window/RoomWindow";
import RedirectService from "./RedirectService";


const panelManager = new PanelManager();
const navigationPanel = new NavigationPanel(panelManager, roomWindow);
const roomManager = new RoomManager(navigationPanel, roomWindow);
const redirectService = new RedirectService(roomManager);
const join = new Join(panelManager, roomManager);
const create = new Create(panelManager, roomManager);

if (window.location.pathname.startsWith('/join/')) {
    redirectService.redirectWithAutojoin();
} else {
    redirectService.checkForAutojoin();
}