class PanelManager {

    constructor() {
        this.panels = [];
        this.bootstrapDom();
    }

    bootstrapDom() {
        this.curtain = document.querySelector('#curtain');
        this.curtain.panelManager = this;
        this.curtain.addEventListener('click', this.onCurtainClick);
    }

    register(panel) {
        this.panels.push(panel);
    }

    open(panel) {
        this.closeAll();
        panel.element.classList.add('visible');
        document.body.classList.add('popup-open');
    }

    closeAll() {
        this.panels.forEach(function(panel) {
            panel.element.classList.remove('visible');
        });
        document.body.classList.remove('popup-open');
    }

    onCurtainClick(e) {
        this.panelManager.closeAll();
    }


}

export default PanelManager;
