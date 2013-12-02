pimcore.registerNS("pimcore.plugin.groupdocsviewerjava");

pimcore.plugin.groupdocsviewerjava = Class.create(pimcore.plugin.admin, {
    getClassName: function() {
        return "pimcore.plugin.groupdocsviewerjava";
    },

    initialize: function() {
        pimcore.plugin.broker.registerPlugin(this);
    },
 
    pimcoreReady: function (params,broker){
        // alert("Example Ready!");
    }
});

var groupdocsviewerjavaPlugin = new pimcore.plugin.groupdocsviewerjava();

